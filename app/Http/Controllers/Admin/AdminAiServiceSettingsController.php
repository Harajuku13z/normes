<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class AdminAiServiceSettingsController extends Controller
{
    public function edit(): View
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

        return view('admin.ai_service_settings.edit', [
            'settings' => [
                'openai' => [
                    'model' => (string) data_get($payload, 'openai.model', 'gpt-4o-mini'),
                    'temperature' => (string) data_get($payload, 'openai.temperature', '0.4'),
                    'api_key' => $apiKey,
                ],
                'prompt_template' => (string) data_get($payload, 'prompt_template', $this->defaultPromptTemplate()),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'openai.model' => ['required', 'string', 'max:120'],
            'openai.temperature' => ['nullable', 'numeric', 'min:0', 'max:2'],
            'openai.api_key' => ['required', 'string', 'max:255'],
            'prompt_template' => ['required', 'string', 'min:100', 'max:30000'],
        ]);

        HomeSection::query()->updateOrCreate(
            ['key' => 'ai_service_settings'],
            ['payload' => [
                'openai' => [
                    'model' => trim((string) data_get($data, 'openai.model', 'gpt-4o-mini')),
                    'temperature' => (float) data_get($data, 'openai.temperature', 0.4),
                    'api_key' => Crypt::encryptString(trim((string) data_get($data, 'openai.api_key', ''))),
                ],
                'prompt_template' => trim((string) data_get($data, 'prompt_template', '')),
            ]]
        );

        return redirect()
            ->route('admin.ai_service_settings.edit')
            ->with('status', 'Configuration IA enregistrée.');
    }

    private function defaultPromptTemplate(): string
    {
        return <<<'PROMPT'
Tu es un expert en rédaction web SEO spécialisé dans la rénovation énergétique (toiture, façade, ventilation, isolation, photovoltaïque).

À partir des éléments suivants :
- Titre du service : [TITRE]
- Description courte : [DESCRIPTION]

Génère une fiche service complète, professionnelle et optimisée SEO, prête à être intégrée sur un site web.

Respecte les consignes suivantes :
- Ton professionnel, clair et naturel (pas de texte robotique)
- Optimisé SEO (AIOSEO)
- Orienté conversion (incite à demander un devis)
- Français

Tu dois générer TOUS les champs suivants :

1. PARAMÈTRES
- Slug (URL)
- Service num (choisir un chiffre logique selon le type de service)

2. SEO
- Meta title (max 60 caractères)
- Meta keywords (max 200 caractères)
- Meta description (max 160 caractères)

3. CONTENU PAGE
- Titre
- Sous-titre
- Intro (court paragraphe engageant)
- Description (plus détaillée, 2 à 3 paragraphes)

4. SECTION SOUS-SERVICES
- Titre de section
- Sous-titre
- Liste de 3 à 4 sous-services avec :
  - Nom
  - Description courte (1 phrase)

5. PROCESSUS (4 étapes)
- Étape 1 : titre + texte
- Étape 2 : titre + texte
- Étape 3 : titre + texte
- Étape 4 : titre + texte

6. TEXTES UI
INTRO
- Kicker (court slogan)
- Badge 1
- Badge 2
- Badge 3

NAVIGATION
- Nav — Services
- Nav — Réalisations
- Nav — Avis
- Nav — Contact

7. CHIFFRES (4 blocs)
- Titre
- Valeur
- Texte court

8. PARTENAIRES
- Titre bloc partenaires
- Lien bloc partenaires

9. RÉALISATIONS
- Titre réalisations (accent)
- Titre réalisations (suite)
- Texte intro réalisations

10. CTA
- Bouton sous-service
- Bouton doc technique

Objectif :
Créer une page service complète, cohérente, professionnelle et prête à convertir des visiteurs en clients.

Important :
Retourne UNIQUEMENT un JSON valide sans markdown, sans commentaires, sans texte autour.
PROMPT;
    }
}

