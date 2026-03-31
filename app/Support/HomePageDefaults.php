<?php

namespace App\Support;

final class HomePageDefaults
{
    /**
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        $path = resource_path('data/homepage.json');
        if (is_file($path)) {
            $decoded = json_decode((string) file_get_contents($path), true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        /** @var array<string, mixed> */
        return require __DIR__.'/homepage_defaults.php';
    }

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            'meta' => 'SEO & métadonnées',
            'styles' => 'Arrière-plans (CSS)',
            'header' => 'En-tête & navigation',
            'hero' => 'Hero (diaporama)',
            'simulateur' => 'Bandeau simulateur',
            'floating' => 'Barre flottante (mobile)',
            'sidebar_avis' => 'Encart avis (grand écran)',
            'services' => 'Nos services',
            'realisations' => 'Réalisations (avant / après)',
            'about' => 'À propos',
            'agences' => 'Agences & carte',
            'pourquoi' => 'Pourquoi nous ?',
            'processus' => 'Processus',
            'aides_renov' => 'Bloc aides MaPrimeRénov’',
            'stats' => 'Chiffres clés',
            'avis' => 'Avis clients',
            'contact_page' => 'Page contact (textes)',
            'devis' => 'Contact & devis',
            'blog' => 'Blog / conseils',
            'partners' => 'Partenaires',
            'footer' => 'Pied de page',
            'map' => 'Carte (Leaflet)',
        ];
    }

    public static function label(string $key): string
    {
        return self::labels()[$key] ?? $key;
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_keys(self::all());
    }
}
