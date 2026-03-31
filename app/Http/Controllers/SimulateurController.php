<?php

namespace App\Http\Controllers;

use App\Models\ServicePage;
use App\Services\HomePageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SimulateurController extends Controller
{
    public function start(Request $request): RedirectResponse
    {
        $address = trim((string) $request->query('address', ''));
        $postalFromAddress = $this->extractPostalCode($address);

        $state = (array) $request->session()->get('simulateur_devis', []);
        if ($address !== '') {
            $state['address'] = $address;
        }
        if ($postalFromAddress !== null) {
            $state['code_postal'] = $postalFromAddress;
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
        $data = $request->validate([
            'nom_prenom' => ['required', 'string', 'max:190'],
            'code_postal' => ['required', 'regex:/^\d{5}$/'],
            'surface_m2' => ['required', 'numeric', 'min:10', 'max:5000'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $state = (array) $request->session()->get('simulateur_devis', []);
        $state = array_merge($state, [
            'nom_prenom' => trim((string) $data['nom_prenom']),
            'code_postal' => trim((string) $data['code_postal']),
            'surface_m2' => (string) $data['surface_m2'],
            'address' => trim((string) ($data['address'] ?? ($state['address'] ?? ''))),
        ]);
        $request->session()->put('simulateur_devis', $state);

        return redirect()->route('simulateur.step2');
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
            'service_slug' => ['required', Rule::in($serviceSlugs)],
            'sub_service' => ['nullable', 'string', 'max:190'],
        ]);

        $services = $this->servicesWithSubServices();
        $selected = collect($services)->firstWhere('slug', $data['service_slug']);
        if (! is_array($selected)) {
            return back()->withErrors(['service_slug' => 'Service introuvable.'])->withInput();
        }

        $subService = trim((string) ($data['sub_service'] ?? ''));
        if ($subService !== '' && ! in_array($subService, (array) ($selected['sub_services'] ?? []), true)) {
            return back()->withErrors(['sub_service' => 'Sous-service invalide pour ce service.'])->withInput();
        }

        $state = (array) $request->session()->get('simulateur_devis', []);
        $state = array_merge($state, [
            'service_slug' => (string) $selected['slug'],
            'service_title' => (string) $selected['title'],
            'sub_service' => $subService,
        ]);
        $request->session()->put('simulateur_devis', $state);

        return redirect()->route('simulateur.step3');
    }

    public function step3(Request $request, HomePageService $homePage): View
    {
        $state = (array) $request->session()->get('simulateur_devis', []);

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 3,
            'state' => $state,
            'services' => [],
        ]);
    }

    public function step3Store(Request $request): RedirectResponse
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

        return redirect()->route('simulateur.step4');
    }

    public function step4(Request $request, HomePageService $homePage): View
    {
        $state = (array) $request->session()->get('simulateur_devis', []);

        return view('simulateur.wizard', [
            'home' => $homePage->merged(),
            'step' => 4,
            'state' => $state,
            'services' => [],
        ]);
    }

    public function finish(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'telephone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:190'],
        ]);

        $state = (array) $request->session()->get('simulateur_devis', []);
        $state['telephone'] = trim((string) $data['telephone']);
        $state['email'] = trim((string) ($data['email'] ?? ''));

        $request->session()->forget('simulateur_devis');
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
     * @return array<int, array{slug:string,title:string,sub_services:array<int,string>}>
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
                    ->map(fn ($s) => trim((string) data_get($s, 'title', '')))
                    ->filter(fn ($s) => $s !== '')
                    ->unique()
                    ->values()
                    ->all();

                return [
                    'slug' => (string) $page->slug,
                    'title' => (string) $page->title,
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
}
