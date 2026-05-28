<?php

namespace App\Http\Controllers;

use App\Models\SimulateurLead;
use App\Models\ServicePage;
use App\Services\HomePageService;
use App\Services\SimulateurMailer;
use App\Support\FormSpamGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SimulateurController extends Controller
{
    public function __construct(private readonly SimulateurMailer $mailer)
    {
    }

    public function start(Request $request): RedirectResponse
    {
        $address = trim((string) $request->query('address', ''));
        $postalFromAddress = $this->extractPostalCode($address);
        $source = trim((string) $request->query('source', ''));
        if ($source === '') {
            $source = $this->normalizeSourceFromReferer((string) $request->headers->get('referer', ''));
        }

        $state = (array) $request->session()->get('simulateur_devis', []);
        if ($address !== '') {
            $state['address'] = $address;
        }
        if ($postalFromAddress !== null) {
            $state['code_postal'] = $postalFromAddress;
        }
        if ($source !== '') {
            $state['source_page'] = $source;
        }
        $request->session()->put('simulateur_devis', $state);

        return redirect()->route('simulateur.step1');
    }

    public function step1(Request $request, HomePageService $homePage): View
    {
        $state = (array) $request->session()->get('simulateur_devis', []);

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 1,
            'state' => $state,
            'services' => [],
        ]);
    }

    public function step1Store(Request $request): RedirectResponse
    {
        app(FormSpamGuard::class)->ensureValid($request, 'simulateur-step1', [
            'nom_prenom',
            'telephone',
            'email',
            'code_postal',
            'surface_m2',
            'address',
        ]);

        $data = $request->validate([
            'nom_prenom' => ['required', 'string', 'max:190'],
            'code_postal' => ['required', 'regex:/^\d{5}$/'],
            'surface_m2' => ['required', 'numeric', 'min:10', 'max:5000'],
            'address' => ['nullable', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:190'],
        ]);

        $state = (array) $request->session()->get('simulateur_devis', []);
        $state = array_merge($state, [
            'nom_prenom' => trim((string) $data['nom_prenom']),
            'code_postal' => trim((string) $data['code_postal']),
            'surface_m2' => (string) $data['surface_m2'],
            'address' => trim((string) ($data['address'] ?? ($state['address'] ?? ''))),
            'telephone' => trim((string) $data['telephone']),
            'email' => trim((string) ($data['email'] ?? '')),
        ]);
        $request->session()->put('simulateur_devis', $state);
        $lead = $this->upsertLeadFromState($request, $state);
        if ($lead && $lead->admin_notified_started_at === null) {
            try {
                $this->mailer->sendAdminStep1($lead);
                $lead->forceFill([
                    'admin_notified_started_at' => now(),
                    'mail_error' => null,
                ])->save();
            } catch (\Throwable $e) {
                $lead->forceFill(['mail_error' => $e->getMessage()])->save();
            }
        }

        return redirect()->route('simulateur.step2')->with('status', 'Vos informations sont enregistrées. Vous pouvez continuer plus tard.');
    }

    public function step2(Request $request, HomePageService $homePage): View
    {
        $state = (array) $request->session()->get('simulateur_devis', []);
        $services = $this->servicesWithSubServices();

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 2,
            'state' => $state,
            'services' => $services,
        ]);
    }

    public function step2Store(Request $request): RedirectResponse
    {
        $serviceSlugs = ServicePage::query()
            ->where('is_active', true)
            ->pluck('slug')
            ->map(fn ($v) => (string) $v)
            ->values()
            ->all();

        $data = $request->validate([
            'service_slugs' => ['required', 'array', 'min:1'],
            'service_slugs.*' => ['required', Rule::in($serviceSlugs)],
        ]);

        $services = $this->servicesWithSubServices();
        $selectedServices = collect($services)
            ->filter(fn ($sv) => in_array((string) data_get($sv, 'slug'), (array) $data['service_slugs'], true))
            ->values()
            ->all();
        if ($selectedServices === []) {
            return back()->withErrors(['service_slugs' => 'Sélectionnez au moins un service.'])->withInput();
        }

        $state = (array) $request->session()->get('simulateur_devis', []);
        $selectedTitles = collect($selectedServices)->map(fn ($sv) => (string) data_get($sv, 'title'))->values()->all();
        $state = array_merge($state, [
            'service_slug' => (string) data_get($selectedServices, '0.slug', ''),
            'service_title' => (string) data_get($selectedServices, '0.title', ''),
            'service_slugs' => array_values((array) $data['service_slugs']),
            'service_titles' => $selectedTitles,
            'sub_service' => '',
            'sub_services' => [],
        ]);
        $request->session()->put('simulateur_devis', $state);
        $this->upsertLeadFromState($request, $state);

        return redirect()->route('simulateur.step3');
    }

    public function step3(Request $request, HomePageService $homePage): View|RedirectResponse
    {
        $state = (array) $request->session()->get('simulateur_devis', []);
        $serviceSlugs = collect((array) data_get($state, 'service_slugs', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->values()
            ->all();
        if ($serviceSlugs === []) {
            return redirect()->route('simulateur.step2');
        }

        $services = $this->servicesWithSubServices();
        $selectedServices = collect($services)
            ->filter(fn ($sv) => in_array((string) data_get($sv, 'slug'), $serviceSlugs, true))
            ->values()
            ->all();
        if ($selectedServices === []) {
            return redirect()->route('simulateur.step2');
        }

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 3,
            'state' => $state,
            'services' => $services,
            'selectedServices' => $selectedServices,
        ]);
    }

    public function step3Store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sub_services' => ['nullable', 'array'],
            'sub_services.*' => ['nullable', 'string', 'max:190'],
        ]);

        $state = (array) $request->session()->get('simulateur_devis', []);
        $serviceSlugs = collect((array) data_get($state, 'service_slugs', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->values()
            ->all();
        if ($serviceSlugs === []) {
            return redirect()->route('simulateur.step2');
        }

        $services = $this->servicesWithSubServices();
        $selectedServices = collect($services)
            ->filter(fn ($sv) => in_array((string) data_get($sv, 'slug'), $serviceSlugs, true))
            ->values()
            ->all();
        if ($selectedServices === []) {
            return redirect()->route('simulateur.step2');
        }

        $selectedSubServices = collect((array) ($data['sub_services'] ?? []))
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->unique()
            ->values()
            ->all();
        $allowedSubServices = collect($selectedServices)
            ->flatMap(fn ($sv) => (array) data_get($sv, 'sub_services', []))
            ->map(fn ($sub) => trim((string) data_get($sub, 'title', '')))
            ->filter(fn ($title) => $title !== '')
            ->unique()
            ->values()
            ->all();

        foreach ($selectedSubServices as $subService) {
            if (! in_array($subService, $allowedSubServices, true)) {
                return back()->withErrors(['sub_services' => 'Sous-service invalide pour les services sélectionnés.'])->withInput();
            }
        }

        $state['sub_service'] = (string) ($selectedSubServices[0] ?? '');
        $state['sub_services'] = $selectedSubServices;
        $request->session()->put('simulateur_devis', $state);
        $this->upsertLeadFromState($request, $state);

        return redirect()->route('simulateur.step4');
    }

    public function step4(Request $request, HomePageService $homePage): View|RedirectResponse
    {
        $state = (array) $request->session()->get('simulateur_devis', []);
        $serviceSlugs = collect((array) data_get($state, 'service_slugs', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->values()
            ->all();
        if ($serviceSlugs === []) {
            return redirect()->route('simulateur.step2');
        }

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 4,
            'state' => $state,
            'services' => [],
        ]);
    }

    public function step4Store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:3000'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['file', 'max:12288', 'mimetypes:image/jpeg,image/png,image/webp,application/pdf'],
        ]);

        $state = (array) $request->session()->get('simulateur_devis', []);
        $state['message'] = trim((string) ($data['message'] ?? ''));

        $existing = collect((array) ($state['photos'] ?? []))
            ->filter(fn ($p) => is_string($p) && $p !== '')
            ->values()
            ->all();

        $uploadedPaths = [];
        foreach ((array) $request->file('photos', []) as $file) {
            if (! $file) {
                continue;
            }
            $uploadedPaths[] = $file->store('simulateur', 'public');
        }

        $state['photos'] = array_values(array_merge($existing, $uploadedPaths));
        $request->session()->put('simulateur_devis', $state);
        $this->upsertLeadFromState($request, $state);

        return redirect()->route('simulateur.step5');
    }

    public function step5(Request $request, HomePageService $homePage): View|RedirectResponse
    {
        $state = (array) $request->session()->get('simulateur_devis', []);
        $serviceSlugs = collect((array) data_get($state, 'service_slugs', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter(fn ($v) => $v !== '')
            ->values()
            ->all();
        if ($serviceSlugs === []) {
            return redirect()->route('simulateur.step2');
        }

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 5,
            'state' => $state,
            'services' => [],
        ]);
    }

    public function finish(Request $request): RedirectResponse
    {
        app(FormSpamGuard::class)->ensureValid($request, 'simulateur-finish', [
            'telephone',
            'email',
        ]);

        $data = $request->validate([
            'telephone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:190'],
        ]);

        $state = (array) $request->session()->get('simulateur_devis', []);
        $state['telephone'] = trim((string) $data['telephone']);
        $state['email'] = trim((string) ($data['email'] ?? ''));
        $lead = $this->upsertLeadFromState($request, $state, true);
        // Guard against double-submission: only send emails once (when not already notified)
        if ($lead && $lead->admin_notified_completed_at === null) {
            try {
                $this->mailer->sendCompleted($lead);
                $lead->forceFill([
                    'admin_notified_completed_at' => now(),
                    'client_notified_at' => trim((string) $lead->email) !== '' ? now() : $lead->client_notified_at,
                    'mail_error' => null,
                ])->save();
            } catch (\Throwable $e) {
                $lead->forceFill(['mail_error' => $e->getMessage()])->save();
            }
        }

        $request->session()->forget('simulateur_devis');
        $request->session()->forget('simulateur_lead_id');
        $request->session()->flash('simulateur_summary', $state);

        return redirect()->route('simulateur.success');
    }

    public function success(Request $request, HomePageService $homePage): View|RedirectResponse
    {
        $summary = $request->session()->get('simulateur_summary');
        if (! is_array($summary) || $summary === []) {
            return redirect()->route('simulateur.start');
        }

        return view('simulateur.success', [
            'home' => $homePage->merged(),
            'summary' => $summary,
        ]);
    }

    /**
     * @return array<int, array{slug:string,title:string,subtitle:string,image:string,sub_services:array<int,array{title:string,subtitle:string,image:string}>}>
     */
    private function servicesWithSubServices(): array
    {
        return ServicePage::query()
            ->where('is_active', true)
            ->orderBy('service_num')
            ->orderBy('id')
            ->get()
            ->map(function (ServicePage $page): array {
                $subs = collect((array) ($page->sub_services ?? []))
                    ->filter(fn ($s) => is_array($s))
                    ->map(function ($s): array {
                        $title = trim((string) data_get($s, 'title', ''));
                        $image = trim((string) data_get($s, 'image', ''));
                        return [
                            'title' => $title,
                            'subtitle' => trim((string) data_get($s, 'subtitle', '')),
                            'image' => $this->publicUrl($image !== '' ? $image : 'slide/toiture.png'),
                        ];
                    })
                    ->filter(fn ($s) => $s['title'] !== '')
                    ->unique('title')
                    ->values()
                    ->all();

                return [
                    'slug' => (string) $page->slug,
                    'title' => (string) $page->title,
                    'subtitle' => trim((string) ($page->subtitle ?? '')),
                    'image' => $this->publicUrl(trim((string) ($page->image ?: $page->featured_image ?: 'slide/toiture.png'))),
                    'sub_services' => $subs,
                ];
            })
            ->values()
            ->all();
    }

    private function extractPostalCode(string $address): ?string
    {
        if (preg_match('/\b(\d{5})\b/', $address, $m) === 1) {
            return (string) $m[1];
        }

        return null;
    }

    private function publicUrl(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return asset('slide/toiture.png');
        }

        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : asset(ltrim($path, '/'));
    }

    /**
     * Sauvegarde silencieuse du lead pour ne jamais bloquer le parcours simulateur.
     *
     * @param  array<string, mixed>  $state
     */
    private function upsertLeadFromState(Request $request, array $state, bool $completed = false): ?SimulateurLead
    {
        try {
            $leadId = $request->session()->get('simulateur_lead_id');
            $payload = [
                'nom_prenom' => trim((string) ($state['nom_prenom'] ?? '')) ?: null,
                'code_postal' => trim((string) ($state['code_postal'] ?? '')) ?: null,
                'surface_m2' => is_numeric($state['surface_m2'] ?? null) ? (float) $state['surface_m2'] : null,
                'address' => trim((string) ($state['address'] ?? '')) ?: null,
                'source_page' => trim((string) ($state['source_page'] ?? '')) ?: null,
                'telephone' => trim((string) ($state['telephone'] ?? '')) ?: null,
                'email' => trim((string) ($state['email'] ?? '')) ?: null,
                'service_slug' => trim((string) ($state['service_slug'] ?? '')) ?: null,
                'service_title' => trim((string) ($state['service_title'] ?? '')) ?: null,
                'selected_services' => collect((array) ($state['service_titles'] ?? []))
                    ->map(fn ($v) => trim((string) $v))
                    ->filter(fn ($v) => $v !== '')
                    ->values()
                    ->all(),
                'sub_service' => trim((string) ($state['sub_service'] ?? '')) ?: null,
                'selected_sub_services' => collect((array) ($state['sub_services'] ?? []))
                    ->map(fn ($v) => trim((string) $v))
                    ->filter(fn ($v) => $v !== '')
                    ->values()
                    ->all(),
                'message' => trim((string) ($state['message'] ?? '')) ?: null,
                'photos' => is_array($state['photos'] ?? null) ? array_values((array) $state['photos']) : null,
                'status' => $completed ? 'completed' : 'draft',
                'completed_at' => $completed ? now() : null,
            ];

            if (is_numeric($leadId)) {
                $lead = SimulateurLead::query()->find((int) $leadId);
                if ($lead) {
                    $lead->update($payload);
                    return $lead->refresh();
                }
            }

            $lead = SimulateurLead::query()->create($payload);
            $request->session()->put('simulateur_lead_id', $lead->id);
            return $lead;
        } catch (QueryException $e) {
            logger()->error('SimulateurLead upsert failed: ' . $e->getMessage(), [
                'leadId' => $request->session()->get('simulateur_lead_id'),
                'completed' => $completed,
            ]);
            return null;
        }
    }

    private function normalizeSourceFromReferer(string $referer): string
    {
        $referer = trim($referer);
        if ($referer === '') {
            return '';
        }
        $parsed = parse_url($referer);
        $path = (string) ($parsed['path'] ?? '');
        $query = (string) ($parsed['query'] ?? '');
        if ($path === '' && $query === '') {
            return '';
        }

        return $path.($query !== '' ? '?'.$query : '');
    }
}
