<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\ServicePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminServicePagesController extends Controller
{
    public function index(): View
    {
        $pages = ServicePage::query()
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('admin.services_pages.index', [
            'pages' => $pages,
        ]);
    }

    public function create(): View
    {
        return view('admin.services_pages.form', [
            'page' => new ServicePage(),
        ]);
    }

    public function edit(ServicePage $servicePage): View
    {
        return view('admin.services_pages.form', [
            'page' => $servicePage,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_num' => ['nullable', 'integer'],
            'slug' => ['required', 'string', 'max:190', 'unique:service_pages,slug'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'title' => ['required', 'string', 'max:190'],
            'subtitle' => ['nullable', 'string', 'max:190'],
            'intro' => ['nullable', 'string'],
            'body' => ['nullable', 'string', 'max:100000'],
            'image' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'sub_services_section_title' => ['nullable', 'string', 'max:190'],
            'sub_services_section_intro' => ['nullable', 'string'],
            'sub_services' => ['nullable', 'array'],
            'sub_services.*.title' => ['nullable', 'string', 'max:190'],
            'sub_services.*.subtitle' => ['nullable', 'string', 'max:300'],
            'sub_services.*.image' => ['nullable', 'string', 'max:800'],
            'sub_services.*.technical_doc' => ['nullable', 'string', 'max:800'],
            'realisations' => ['nullable', 'array'],
            'realisations.*.label' => ['nullable', 'string', 'max:190'],
            'realisations.*.before' => ['nullable', 'string', 'max:800'],
            'realisations.*.after' => ['nullable', 'string', 'max:800'],
            'service_partners' => ['nullable', 'array'],
            'service_partners.phrase' => ['nullable', 'string', 'max:300'],
            'service_partners.logos' => ['nullable', 'array'],
            'service_partners.logos.*' => ['nullable', 'string', 'max:800'],
            'technical_doc' => ['nullable', 'string', 'max:800'],
            'service_stats' => ['nullable', 'array'],
            'service_stats.items' => ['nullable', 'array'],
            'service_stats.items.*.label' => ['nullable', 'string', 'max:30'],
            'service_stats.items.*.value' => ['nullable', 'string', 'max:30'],
            'service_stats.items.*.text' => ['nullable', 'string', 'max:80'],
            'content_overrides' => ['nullable', 'array'],
            'cta_text' => ['nullable', 'string', 'max:190'],
            'cta_href' => ['nullable', 'string', 'max:500'],
            'cta_card_background' => ['nullable', 'string', 'max:800'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'service_num' => $data['service_num'] ?? null,
            ...$data,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ];

        if (! Schema::hasColumn('service_pages', 'content_overrides') && array_key_exists('content_overrides', $data)) {
            return back()
                ->withErrors(['content_overrides' => 'Les textes éditables ne peuvent pas être enregistrés : la migration de la colonne content_overrides n’a pas été exécutée. Lancez php artisan migrate.'])
                ->withInput();
        }

        // Compatibilité : si la migration n'est pas encore faite, on évite une erreur DB.
        if (! Schema::hasColumn('service_pages', 'meta_title')) {
            unset($payload['meta_title']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_description')) {
            unset($payload['meta_description']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_keywords')) {
            unset($payload['meta_keywords']);
        }
        if (! Schema::hasColumn('service_pages', 'cta_card_background')) {
            unset($payload['cta_card_background']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services')) {
            unset($payload['sub_services']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_title')) {
            unset($payload['sub_services_section_title']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_intro')) {
            unset($payload['sub_services_section_intro']);
        }
        if (! Schema::hasColumn('service_pages', 'realisations')) {
            unset($payload['realisations']);
        }
        if (! Schema::hasColumn('service_pages', 'service_partners')) {
            unset($payload['service_partners']);
        }
        if (! Schema::hasColumn('service_pages', 'technical_doc')) {
            unset($payload['technical_doc']);
        }
        if (! Schema::hasColumn('service_pages', 'service_stats')) {
            unset($payload['service_stats']);
        }
        if (! Schema::hasColumn('service_pages', 'content_overrides')) {
            unset($payload['content_overrides']);
        }

        ServicePage::query()->create($payload);

        return redirect()->route('admin.services_pages.index')->with('status', 'Page service créée.');
    }

    public function update(Request $request, ServicePage $servicePage): RedirectResponse
    {
        $data = $request->validate([
            'service_num' => ['nullable', 'integer'],
            'slug' => ['required', 'string', 'max:190', 'unique:service_pages,slug,'.$servicePage->id],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'title' => ['required', 'string', 'max:190'],
            'subtitle' => ['nullable', 'string', 'max:190'],
            'intro' => ['nullable', 'string'],
            'body' => ['nullable', 'string', 'max:100000'],
            'image' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'sub_services_section_title' => ['nullable', 'string', 'max:190'],
            'sub_services_section_intro' => ['nullable', 'string'],
            'sub_services' => ['nullable', 'array'],
            'sub_services.*.title' => ['nullable', 'string', 'max:190'],
            'sub_services.*.subtitle' => ['nullable', 'string', 'max:300'],
            'sub_services.*.image' => ['nullable', 'string', 'max:800'],
            'sub_services.*.technical_doc' => ['nullable', 'string', 'max:800'],
            'realisations' => ['nullable', 'array'],
            'realisations.*.label' => ['nullable', 'string', 'max:190'],
            'realisations.*.before' => ['nullable', 'string', 'max:800'],
            'realisations.*.after' => ['nullable', 'string', 'max:800'],
            'service_partners' => ['nullable', 'array'],
            'service_partners.phrase' => ['nullable', 'string', 'max:300'],
            'service_partners.logos' => ['nullable', 'array'],
            'service_partners.logos.*' => ['nullable', 'string', 'max:800'],
            'technical_doc' => ['nullable', 'string', 'max:800'],
            'service_stats' => ['nullable', 'array'],
            'service_stats.items' => ['nullable', 'array'],
            'service_stats.items.*.label' => ['nullable', 'string', 'max:30'],
            'service_stats.items.*.value' => ['nullable', 'string', 'max:30'],
            'service_stats.items.*.text' => ['nullable', 'string', 'max:80'],
            'content_overrides' => ['nullable', 'array'],
            'cta_text' => ['nullable', 'string', 'max:190'],
            'cta_href' => ['nullable', 'string', 'max:500'],
            'cta_card_background' => ['nullable', 'string', 'max:800'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'service_num' => $data['service_num'] ?? null,
            ...$data,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ];

        if (! Schema::hasColumn('service_pages', 'content_overrides') && array_key_exists('content_overrides', $data)) {
            return back()
                ->withErrors(['content_overrides' => 'Les textes éditables ne peuvent pas être enregistrés : la migration de la colonne content_overrides n’a pas été exécutée. Lancez php artisan migrate.'])
                ->withInput();
        }

        if (! Schema::hasColumn('service_pages', 'meta_title')) {
            unset($payload['meta_title']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_description')) {
            unset($payload['meta_description']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_keywords')) {
            unset($payload['meta_keywords']);
        }
        if (! Schema::hasColumn('service_pages', 'cta_card_background')) {
            unset($payload['cta_card_background']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services')) {
            unset($payload['sub_services']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_title')) {
            unset($payload['sub_services_section_title']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_intro')) {
            unset($payload['sub_services_section_intro']);
        }
        if (! Schema::hasColumn('service_pages', 'realisations')) {
            unset($payload['realisations']);
        }
        if (! Schema::hasColumn('service_pages', 'service_partners')) {
            unset($payload['service_partners']);
        }
        if (! Schema::hasColumn('service_pages', 'technical_doc')) {
            unset($payload['technical_doc']);
        }
        if (! Schema::hasColumn('service_pages', 'service_stats')) {
            unset($payload['service_stats']);
        }
        if (! Schema::hasColumn('service_pages', 'content_overrides')) {
            unset($payload['content_overrides']);
        }

        $servicePage->update($payload);

        return redirect()->route('admin.services_pages.edit', $servicePage)->with('status', 'Page service enregistrée.');
    }

    public function generateWithAi(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'description' => ['required', 'string', 'max:3000'],
        ]);

        $settings = $this->aiSettings();
        $apiKey = trim((string) data_get($settings, 'openai.api_key', ''));
        if ($apiKey === '') {
            return response()->json([
                'message' => 'La clé API OpenAI est absente. Configure-la dans Admin > IA Services.',
            ], 422);
        }

        $template = trim((string) data_get($settings, 'prompt_template', ''));
        if ($template === '') {
            return response()->json([
                'message' => 'Le prompt IA est vide. Configure-le dans Admin > IA Services.',
            ], 422);
        }

        $filledPrompt = str_replace(
            ['[TITRE]', '[DESCRIPTION]'],
            [trim((string) $data['title']), trim((string) $data['description'])],
            $template
        );
        $filledPrompt .= "\n\nStructure JSON attendue (respecte exactement ces clés):\n".
            "{\n".
            "  \"parametres\": {\"slug\": \"\", \"service_num\": 1},\n".
            "  \"seo\": {\"meta_title\": \"\", \"meta_keywords\": \"\", \"meta_description\": \"\"},\n".
            "  \"contenu_page\": {\"titre\": \"\", \"sous_titre\": \"\", \"intro\": \"\", \"description\": \"\"},\n".
            "  \"sous_services\": {\"titre_section\": \"\", \"sous_titre\": \"\", \"items\": [{\"nom\": \"\", \"description_courte\": \"\"}]},\n".
            "  \"processus\": {\"etapes\": [{\"titre\": \"\", \"texte\": \"\"}, {\"titre\": \"\", \"texte\": \"\"}, {\"titre\": \"\", \"texte\": \"\"}, {\"titre\": \"\", \"texte\": \"\"}]},\n".
            "  \"textes_ui\": {\"intro\": {\"kicker\": \"\", \"badge_1\": \"\", \"badge_2\": \"\", \"badge_3\": \"\"}, \"navigation\": {\"services\": \"\", \"realisations\": \"\", \"avis\": \"\", \"contact\": \"\"}},\n".
            "  \"chiffres\": [{\"titre\": \"\", \"valeur\": \"\", \"texte_court\": \"\"}, {\"titre\": \"\", \"valeur\": \"\", \"texte_court\": \"\"}, {\"titre\": \"\", \"valeur\": \"\", \"texte_court\": \"\"}, {\"titre\": \"\", \"valeur\": \"\", \"texte_court\": \"\"}],\n".
            "  \"partenaires\": {\"titre_bloc_partenaires\": \"\", \"lien_bloc_partenaires\": \"\"},\n".
            "  \"realisations\": {\"titre_realisations_accent\": \"\", \"titre_realisations_suite\": \"\", \"texte_intro_realisations\": \"\"},\n".
            "  \"cta\": {\"bouton_sous_service\": \"\", \"bouton_doc_technique\": \"\"}\n".
            "}\n";
        $filledPrompt .= "\nContraintes de qualite redactionnelle:\n".
            "- Ecris un francais naturel, fluide, sans tournures robotiques.\n".
            "- Evite les generalites vides et les repetitions.\n".
            "- Sois concret, orienté benefices client, et lisible rapidement.\n".
            "- Pour \"chiffres\", genere 4 blocs si possible, avec au minimum 3 blocs valides (titre + valeur non vides).\n".
            "- \"texte_court\" est optionnel mais recommande pour contextualiser la valeur.\n";

        $response = Http::withToken($apiKey)
            ->timeout(60)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => trim((string) data_get($settings, 'openai.model', 'gpt-4o-mini')),
                'temperature' => (float) data_get($settings, 'openai.temperature', 0.4),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu génères uniquement du JSON valide selon la structure demandée.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $filledPrompt,
                    ],
                ],
                'response_format' => ['type' => 'json_object'],
            ]);

        if (! $response->ok()) {
            return response()->json([
                'message' => 'Erreur IA: '.$response->status().' '.$response->body(),
            ], 422);
        }

        $content = (string) data_get($response->json(), 'choices.0.message.content', '');
        $decoded = $this->decodeAiJson($content);
        if (! is_array($decoded)) {
            return response()->json([
                'message' => 'Réponse IA invalide: JSON introuvable.',
            ], 422);
        }

        $generated = $this->mapGeneratedToForm($decoded, $data);
        $statsCount = count((array) data_get($generated, 'service_stats.items', []));
        if ($statsCount < 3) {
            return response()->json([
                'message' => 'La génération IA est incomplète : au moins 3 chiffres clés valides sont requis (titre + valeur). Relance la génération.',
            ], 422);
        }

        return response()->json([
            'generated' => $generated,
        ]);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodeAiJson(string $raw): ?array
    {
        $raw = trim($raw);
        if ($raw === '') {
            return null;
        }
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        if (preg_match('/\{.*\}/s', $raw, $m) === 1) {
            $decoded2 = json_decode((string) $m[0], true);
            if (is_array($decoded2)) {
                return $decoded2;
            }
        }
        return null;
    }

    /**
     * @param  array<string, mixed>  $decoded
     * @param  array<string, mixed>  $seed
     * @return array<string, mixed>
     */
    private function mapGeneratedToForm(array $decoded, array $seed): array
    {
        $slug = trim((string) data_get($decoded, 'parametres.slug', ''));
        if ($slug === '') {
            $slug = Str::slug((string) data_get($seed, 'title', 'service'));
        }

        $items = collect((array) data_get($decoded, 'sous_services.items', []))
            ->filter(fn ($it) => is_array($it))
            ->map(function (array $it): array {
                return [
                    'title' => trim((string) data_get($it, 'nom', '')),
                    'subtitle' => trim((string) data_get($it, 'description_courte', '')),
                ];
            })
            ->filter(fn (array $it) => $it['title'] !== '')
            ->take(9)
            ->values()
            ->all();

        $steps = collect((array) data_get($decoded, 'processus.etapes', []))
            ->filter(fn ($it) => is_array($it))
            ->map(function (array $it, int $idx): array {
                return [
                    'num' => (string) ($idx + 1),
                    'title' => trim((string) data_get($it, 'titre', '')),
                    'text' => trim((string) data_get($it, 'texte', '')),
                ];
            })
            ->take(4)
            ->values()
            ->all();

        $stats = collect((array) data_get($decoded, 'chiffres', []))
            ->filter(fn ($it) => is_array($it))
            ->map(function (array $it): array {
                return [
                    'label' => trim((string) data_get($it, 'titre', '')),
                    'value' => trim((string) data_get($it, 'valeur', '')),
                    'text' => trim((string) data_get($it, 'texte_court', '')),
                ];
            })
            ->filter(fn (array $it) => $it['label'] !== '' && $it['value'] !== '')
            ->take(4)
            ->values()
            ->all();

        return [
            'slug' => $slug,
            'service_num' => (int) data_get($decoded, 'parametres.service_num', 1),
            'meta_title' => trim((string) data_get($decoded, 'seo.meta_title', '')),
            'meta_keywords' => trim((string) data_get($decoded, 'seo.meta_keywords', '')),
            'meta_description' => trim((string) data_get($decoded, 'seo.meta_description', '')),
            'title' => trim((string) data_get($decoded, 'contenu_page.titre', data_get($seed, 'title', ''))),
            'subtitle' => trim((string) data_get($decoded, 'contenu_page.sous_titre', '')),
            'intro' => trim((string) data_get($decoded, 'contenu_page.intro', data_get($seed, 'description', ''))),
            'body' => trim((string) data_get($decoded, 'contenu_page.description', '')),
            'sub_services_section_title' => trim((string) data_get($decoded, 'sous_services.titre_section', '')),
            'sub_services_section_intro' => trim((string) data_get($decoded, 'sous_services.sous_titre', '')),
            'sub_services' => $items,
            'content_overrides' => [
                'intro' => [
                    'kicker' => trim((string) data_get($decoded, 'textes_ui.intro.kicker', '')),
                    'badges' => [
                        trim((string) data_get($decoded, 'textes_ui.intro.badge_1', '')),
                        trim((string) data_get($decoded, 'textes_ui.intro.badge_2', '')),
                        trim((string) data_get($decoded, 'textes_ui.intro.badge_3', '')),
                    ],
                ],
                'subnav' => [
                    'services' => trim((string) data_get($decoded, 'textes_ui.navigation.services', 'Services')),
                    'realisations' => trim((string) data_get($decoded, 'textes_ui.navigation.realisations', 'Réalisations')),
                    'avis' => trim((string) data_get($decoded, 'textes_ui.navigation.avis', 'Avis')),
                    'contact' => trim((string) data_get($decoded, 'textes_ui.navigation.contact', 'Contact')),
                ],
                'partners' => [
                    'heading' => trim((string) data_get($decoded, 'partenaires.titre_bloc_partenaires', 'Partenaires associés')),
                    'link_text' => trim((string) data_get($decoded, 'partenaires.lien_bloc_partenaires', 'Nous contacter')),
                ],
                'realisations' => [
                    'title_accent' => trim((string) data_get($decoded, 'realisations.titre_realisations_accent', 'Réalisations')),
                    'title_rest' => trim((string) data_get($decoded, 'realisations.titre_realisations_suite', 'avant / après')),
                    'intro' => trim((string) data_get($decoded, 'realisations.texte_intro_realisations', '')),
                ],
                'sub_services' => [
                    'cta_text' => trim((string) data_get($decoded, 'cta.bouton_sous_service', 'C’EST CE QU’IL ME FAUT')),
                    'doc_text' => trim((string) data_get($decoded, 'cta.bouton_doc_technique', 'DOC TECHNIQUE')),
                ],
                'process' => [
                    'kicker' => 'Processus',
                    'title_accent' => 'Processus',
                    'title_rest' => 'de prise en charge',
                    'steps' => $steps,
                ],
            ],
            'service_stats' => [
                'items' => $stats,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function aiSettings(): array
    {
        $row = HomeSection::query()->where('key', 'ai_service_settings')->first();
        $payload = is_array($row?->payload) ? $row->payload : [];

        $apiKey = '';
        $encrypted = trim((string) data_get($payload, 'openai.api_key', ''));
        if ($encrypted !== '') {
            try {
                $apiKey = Crypt::decryptString($encrypted);
            } catch (\Throwable) {
                $apiKey = '';
            }
        }

        data_set($payload, 'openai.api_key', $apiKey);
        data_set($payload, 'openai.model', trim((string) data_get($payload, 'openai.model', 'gpt-4o-mini')));
        data_set($payload, 'openai.temperature', (float) data_get($payload, 'openai.temperature', 0.4));

        return $payload;
    }
}

