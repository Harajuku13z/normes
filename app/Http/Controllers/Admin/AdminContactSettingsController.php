<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactSettingsController extends Controller
{
    /**
     * @return array<string, mixed>
     */
    private function contactPageDefaults(): array
    {
        return [
            'hero_bg' => '/slide/toiture.png',
            'featured_image' => '/slide/toiture.png',
            'hero_kicker' => 'Contact',
            'meta_title' => 'Contact | Normes & Rénovation',
            'meta_description' => 'Contactez-nous pour un devis gratuit, une question sur votre chantier ou nos agences. Réponse sous 48 h en général.',
            'meta_keywords' => '',
            'og_image' => '/slide/toiture.png',
            'hero_title_line1' => 'Vous avez',
            'hero_title_line2' => 'un projet de rénovation ?',
            'hero_subtitle' => 'Estimation personnalisée & rappel d\'un conseiller',
            'hero_intro' => 'Visualisez les grandes lignes de votre projet (toiture, surfaces, état du bien) — un interlocuteur vous rappelle pour affiner chiffrage et aides.',
            'hero_cta_form' => 'Formulaire de contact',
            'hero_cta_phone' => '03 85 41 98 86',
            'social_bg' => '/slide/toiture.png',
            'social_title' => 'Suivez nos actualités',
            'social_intro' => 'Retrouvez-nous sur les réseaux pour nos chantiers, conseils et nouveautés.',
            'map_title' => 'Nos implantations',
            'map_intro' => 'Repérez nos agences en un coup d’œil (Bretagne et Bourgogne).',
            'labels' => [
                'siege' => 'Siège social',
                'phone' => 'Téléphone',
                'email' => 'E-mail',
                'hours' => 'Horaires',
                'social' => 'Réseaux sociaux',
                'map' => 'Carte',
            ],
            'cta_card' => [
                'kicker' => 'Un projet de rénovation ?',
                'title' => 'Démarrez dès maintenant',
                'text' => 'Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.',
                'simulateur_text' => 'Ouvrir le simulateur de devis',
                'contact_text' => 'Accéder au formulaire de contact',
            ],
        ];
    }

    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $keys = ['contact_page', 'devis'];

        $saved = HomeSection::query()
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');

        $merged = [];
        foreach ($keys as $key) {
            $base = $defaults[$key] ?? [];
            if ($key === 'contact_page') {
                $base = is_array($base) && $base !== []
                    ? array_replace_recursive($this->contactPageDefaults(), $base)
                    : $this->contactPageDefaults();
            }
            $row = $saved->get($key);
            $payload = $row && is_array($row->payload) ? $row->payload : [];
            $merged[$key] = $payload
                ? array_replace_recursive($base, $payload)
                : $base;
        }

        return view('admin.contact_settings.edit', [
            'merged' => $merged,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $sections = $request->input('sections', []);
        if (! is_array($sections)) {
            $sections = [];
        }

        foreach (['contact_page', 'devis'] as $key) {
            if (! array_key_exists($key, $sections) || ! is_array($sections[$key])) {
                continue;
            }

            HomeSection::query()->updateOrCreate(
                ['key' => $key],
                ['payload' => $sections[$key]]
            );
        }

        return redirect()
            ->route('admin.contact_settings.edit')
            ->with('status', 'Paramètres de la page contact enregistrés.');
    }
}
