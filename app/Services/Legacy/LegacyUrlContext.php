<?php

namespace App\Services\Legacy;

class LegacyUrlContext
{
    private const SERVICE_MAP = [
        'couvreur'       => ['label' => 'Couverture & Toiture',       'emoji' => '🏠', 'key' => 'couverture'],
        'couverture'     => ['label' => 'Couverture & Toiture',       'emoji' => '🏠', 'key' => 'couverture'],
        'toiture'        => ['label' => 'Toiture & Couverture',       'emoji' => '🏠', 'key' => 'couverture'],
        'demoussage'     => ['label' => 'Démoussage de toiture',      'emoji' => '🧹', 'key' => 'couverture'],
        'hydrofuge'      => ['label' => 'Hydrofugation de toiture',   'emoji' => '💧', 'key' => 'couverture'],
        'zinguerie'      => ['label' => 'Zinguerie & Toiture',        'emoji' => '🏠', 'key' => 'couverture'],
        'ardoise'        => ['label' => 'Toiture Ardoise',            'emoji' => '🏠', 'key' => 'couverture'],
        'isolation'      => ['label' => 'Isolation des combles',      'emoji' => '🌡️', 'key' => 'isolation'],
        'combles'        => ['label' => 'Isolation des combles',      'emoji' => '🌡️', 'key' => 'isolation'],
        'ravalement'     => ['label' => 'Ravalement de façade',       'emoji' => '🏗️', 'key' => 'facade'],
        'facade'         => ['label' => 'Rénovation de façade',       'emoji' => '🏗️', 'key' => 'facade'],
        'enduit'         => ['label' => 'Enduit & Façade',            'emoji' => '🏗️', 'key' => 'facade'],
        'vmc'            => ['label' => 'Ventilation VMC',            'emoji' => '💨', 'key' => 'ventilation'],
        'ventilation'    => ['label' => 'Ventilation VMC',            'emoji' => '💨', 'key' => 'ventilation'],
        'climatisation'  => ['label' => 'Climatisation',              'emoji' => '❄️', 'key' => 'climatisation'],
        'climatiseur'    => ['label' => 'Climatisation',              'emoji' => '❄️', 'key' => 'climatisation'],
        'photovoltaique' => ['label' => 'Panneaux solaires',          'emoji' => '☀️', 'key' => 'photovoltaique'],
        'solaire'        => ['label' => 'Panneaux solaires',          'emoji' => '☀️', 'key' => 'photovoltaique'],
        'electrique'     => ['label' => 'Installation électrique',    'emoji' => '⚡', 'key' => 'electricite'],
        'electricite'    => ['label' => 'Installation électrique',    'emoji' => '⚡', 'key' => 'electricite'],
        'humidite'       => ['label' => "Traitement de l'humidité",   'emoji' => '💧', 'key' => 'humidite'],
        'renovation'     => ['label' => 'Rénovation énergétique',     'emoji' => '🔨', 'key' => null],
        'bretagne'       => ['label' => 'Couverture & Toiture',       'emoji' => '🏠', 'key' => 'couverture'],
    ];

    private const FAQ_MAP = [
        'couverture' => [
            ['q' => 'Combien coûte une rénovation de toiture ?', 'a' => 'Le prix d\'une rénovation de toiture varie selon la superficie, les matériaux et l\'état de la charpente. Comptez entre 50 et 120 €/m² pour une réfection complète. Normes Rénovation vous propose un devis gratuit et détaillé sous 48h.'],
            ['q' => 'Faut-il des autorisations pour rénover sa toiture ?', 'a' => 'La plupart des travaux de réfection à l\'identique ne nécessitent pas de permis. En revanche, un changement de matériaux ou de pente peut requérir une déclaration préalable. Notre équipe vous guide dans les démarches administratives.'],
            ['q' => 'Combien de temps durent les travaux de toiture ?', 'a' => 'Une rénovation complète prend généralement 1 à 2 semaines selon la taille du toit. Des réparations ponctuelles peuvent être réalisées en 1 à 2 jours. Nous planifions les travaux pour minimiser les nuisances.'],
            ['q' => 'Quelles aides financières existent pour la toiture ?', 'a' => 'MaPrimeRénov\', les CEE (Certificats d\'Économies d\'Énergie) et l\'éco-PTZ peuvent financer une partie de vos travaux de toiture si ceux-ci incluent une isolation. Nous sommes certifiés RGE, ce qui vous ouvre droit à ces aides.'],
            ['q' => 'Pourquoi faire appel à un couvreur certifié RGE ?', 'a' => 'Un couvreur certifié RGE vous garantit des travaux de qualité conformes aux normes en vigueur, et vous permet de bénéficier des aides de l\'État comme MaPrimeRénov\'. Normes Rénovation est certifié RGE.'],
        ],
        'isolation' => [
            ['q' => 'Combien coûte l\'isolation des combles ?', 'a' => 'L\'isolation des combles perdus par soufflage coûte entre 20 et 50 €/m². Les combles aménagés reviennent entre 40 et 90 €/m². Des aides comme MaPrimeRénov\' peuvent couvrir jusqu\'à 70% du montant.'],
            ['q' => 'Quelle économie réalise-t-on avec une bonne isolation ?', 'a' => 'Une isolation performante des combles peut réduire vos factures de chauffage de 25 à 30%. C\'est le poste de travaux avec le meilleur retour sur investissement en rénovation énergétique.'],
            ['q' => 'Combien de temps prend l\'isolation des combles ?', 'a' => 'L\'isolation des combles perdus par soufflage est réalisée en 1 journée. Les combles aménagés nécessitent 2 à 5 jours selon la surface. Nos équipes travaillent proprement et rapidement.'],
            ['q' => 'Quels matériaux utilise-t-on pour isoler les combles ?', 'a' => 'La ouate de cellulose, la laine de verre et la laine de roche sont les plus courants pour les combles perdus. Pour les rampants, on privilégie les panneaux rigides ou semi-rigides. Nous conseillons la solution adaptée à votre logement.'],
            ['q' => 'Ai-je droit aux aides pour l\'isolation des combles ?', 'a' => 'Oui, sous conditions de ressources et en faisant appel à un artisan certifié RGE comme Normes Rénovation. MaPrimeRénov\' peut couvrir 25 à 75% du coût selon votre situation fiscale. Demandez votre simulation gratuite.'],
        ],
        'facade' => [
            ['q' => 'Combien coûte un ravalement de façade ?', 'a' => 'Le prix d\'un ravalement varie entre 30 et 120 €/m² selon l\'état de la façade, le type d\'enduit et les éventuels travaux d\'isolation. Contactez-nous pour un devis gratuit et précis.'],
            ['q' => 'Faut-il une autorisation pour un ravalement de façade ?', 'a' => 'Dans la plupart des communes, un ravalement de façade implique une déclaration préalable de travaux. En zone protégée, des règles spécifiques s\'appliquent. Normes Rénovation vous accompagne dans vos démarches.'],
            ['q' => 'Combien de temps dure un ravalement de façade ?', 'a' => 'Un ravalement standard prend 1 à 3 semaines selon la superficie et l\'état initial. Les travaux incluent le nettoyage, la réparation des fissures et l\'application de l\'enduit ou de la peinture.'],
            ['q' => 'Peut-on isoler la façade en même temps que le ravalement ?', 'a' => 'Absolument, c\'est même recommandé ! L\'Isolation Thermique par l\'Extérieur (ITE) combinée au ravalement permet d\'optimiser les coûts et de profiter de MaPrimeRénov\'. Demandez notre offre combinée.'],
        ],
        'ventilation' => [
            ['q' => 'Qu\'est-ce qu\'une VMC et à quoi ça sert ?', 'a' => 'La VMC (Ventilation Mécanique Contrôlée) renouvelle l\'air de votre logement en permanence, élimine l\'humidité, les polluants et les odeurs. Elle est obligatoire dans tous les logements depuis 1982.'],
            ['q' => 'Quel type de VMC choisir ?', 'a' => 'La VMC simple flux est la plus économique. La VMC double flux récupère la chaleur de l\'air sortant pour préchauffer l\'air entrant — idéale pour les maisons bien isolées. Normes Rénovation vous conseille selon votre logement.'],
            ['q' => 'Combien coûte l\'installation d\'une VMC ?', 'a' => 'Une VMC simple flux coûte entre 500 et 1500 € installée. Une VMC double flux revient entre 2000 et 5000 €. Des aides existent si vous rénovez en même temps que vous isolez.'],
        ],
        'climatisation' => [
            ['q' => 'Quelle climatisation choisir pour une maison ?', 'a' => 'Le split system (unité extérieure + intérieure) est le plus courant. Pour plusieurs pièces, le multi-split est idéal. Normes Rénovation installe des climatisations réversibles qui chauffent aussi en hiver.'],
            ['q' => 'Combien coûte l\'installation d\'une climatisation ?', 'a' => 'Un split simple coûte entre 1000 et 3000 € installé. Un multi-split pour 3 pièces revient entre 3000 et 7000 €. La pose respecte les normes et réglementations en vigueur.'],
            ['q' => 'Existe-t-il des aides pour la climatisation ?', 'a' => 'Les climatiseurs réversibles (pompes à chaleur air/air) peuvent être éligibles aux CEE. En combinaison avec d\'autres travaux d\'efficacité énergétique, d\'autres aides peuvent s\'appliquer. Renseignez-vous auprès de notre équipe.'],
        ],
        'photovoltaique' => [
            ['q' => 'Combien coûte l\'installation de panneaux solaires ?', 'a' => 'Un kit de 3 kWc (typique maison individuelle) coûte entre 8000 et 12000 € installé. Des aides comme la prime à l\'autoconsommation et des crédits d\'impôt réduisent significativement le coût.'],
            ['q' => 'Combien économise-t-on avec des panneaux solaires ?', 'a' => 'Une installation de 3 kWc produit 3000 à 4000 kWh/an selon l\'orientation. L\'économie annuelle dépasse 500 € en autoconsommation totale. Le retour sur investissement se fait en 8 à 12 ans.'],
            ['q' => 'Faut-il un permis pour installer des panneaux solaires ?', 'a' => 'Pour une installation sur toiture existante, une simple déclaration préalable suffit dans la plupart des cas. En zone ABF, des règles spécifiques s\'appliquent. Nous gérons les démarches pour vous.'],
        ],
        'default' => [
            ['q' => 'Dans quelles régions intervenez-vous ?', 'a' => 'Normes Rénovation intervient principalement en Bourgogne-Franche-Comté (Chalon-sur-Saône, Mâcon, Dijon, Auxerre, Autun…) et en Bretagne. Contactez-nous pour vérifier si nous intervenons dans votre secteur.'],
            ['q' => 'Êtes-vous certifié RGE ?', 'a' => 'Oui, Normes Rénovation est certifié RGE (Reconnu Garant de l\'Environnement). Cette certification vous permet de bénéficier de MaPrimeRénov\', des CEE et de l\'éco-PTZ pour financer vos travaux.'],
            ['q' => 'Combien de temps pour obtenir un devis ?', 'a' => 'Nous vous répondons sous 48h après votre demande de devis. Pour les urgences (fuite, dommages), nous intervenons en priorité dans les plus brefs délais.'],
            ['q' => 'Proposez-vous des facilités de paiement ?', 'a' => 'Oui, nous proposons l\'éco-PTZ (prêt à taux zéro) et pouvons vous accompagner dans le montage de votre dossier MaPrimeRénov\' pour réduire votre reste à charge. Dans certains cas, le reste à charge peut être nul.'],
            ['q' => 'Quelle garantie sur vos travaux ?', 'a' => 'Tous nos travaux sont couverts par la garantie décennale et la garantie de parfait achèvement. Nous sommes assurés en responsabilité civile professionnelle. Vos travaux sont protégés pendant 10 ans.'],
        ],
    ];

    /** @return array{service_label:?string, service_key:?string, service_emoji:?string, city:?string, h1:string, meta_title:string, meta_description:string} */
    public static function fromPath(string $path): array
    {
        $slug = mb_strtolower(trim($path, '/'));

        $serviceLabel = null;
        $serviceKey   = null;
        $serviceEmoji = null;
        $matchedKw    = null;

        foreach (self::SERVICE_MAP as $kw => $data) {
            if (str_contains($slug, $kw)) {
                $serviceLabel = $data['label'];
                $serviceKey   = $data['key'];
                $serviceEmoji = $data['emoji'];
                $matchedKw    = $kw;
                break;
            }
        }

        $city = null;
        if ($matchedKw !== null) {
            $after = substr($slug, strpos($slug, $matchedKw) + strlen($matchedKw));
            $after = ltrim($after, '-');
            foreach (['a-', 'en-', 'sur-', 'de-', 'du-', 'au-', 'aux-', 'les-'] as $prep) {
                if (str_starts_with($after, $prep)) {
                    $after = substr($after, strlen($prep));
                    break;
                }
            }
            $after = rtrim($after, '-');
            if ($after !== '' && strlen($after) > 2) {
                $city = self::slugToTitle($after);
            }
        }

        $h1              = self::buildH1($slug, $serviceLabel, $city);
        $metaTitle       = self::buildMetaTitle($serviceLabel, $city);
        $metaDescription = self::buildMetaDescription($serviceLabel, $city);

        return compact('serviceLabel', 'serviceKey', 'serviceEmoji', 'city', 'h1', 'metaTitle', 'metaDescription');
    }

    /** @return list<array{q:string, a:string}> */
    public static function getFaq(array $context): array
    {
        $key = $context['serviceKey'] ?? null;
        $map = [
            'couverture'     => 'couverture',
            'isolation'      => 'isolation',
            'facade'         => 'facade',
            'ventilation'    => 'ventilation',
            'climatisation'  => 'climatisation',
            'photovoltaique' => 'photovoltaique',
        ];
        $faqKey = $map[$key] ?? 'default';

        return self::FAQ_MAP[$faqKey] ?? self::FAQ_MAP['default'];
    }

    private static function slugToTitle(string $slug): string
    {
        return mb_convert_case(str_replace('-', ' ', $slug), MB_CASE_TITLE, 'UTF-8');
    }

    private static function buildH1(string $slug, ?string $service, ?string $city): string
    {
        if ($service && $city) {
            return "{$service} à {$city}";
        }
        if ($service) {
            return $service;
        }

        return mb_strtoupper(mb_substr(str_replace('-', ' ', $slug), 0, 1))
            . mb_substr(str_replace('-', ' ', $slug), 1);
    }

    private static function buildMetaTitle(?string $service, ?string $city): string
    {
        if ($service && $city) {
            return "{$service} à {$city} – Normes Rénovation | Devis gratuit";
        }
        if ($service) {
            return "{$service} – Normes Rénovation | Expert & Devis gratuit";
        }

        return 'Normes Rénovation – Expert en rénovation énergétique | Devis gratuit';
    }

    private static function buildMetaDescription(?string $service, ?string $city): string
    {
        if ($service && $city) {
            return "Normes Rénovation, votre expert en {$service} à {$city}. Certifié RGE ✅, devis gratuit sous 48h ⚡. Plus de 5 000 chantiers réalisés en Bourgogne-Franche-Comté et Bretagne.";
        }
        if ($service) {
            return "Spécialiste en {$service} : Normes Rénovation intervient sur toute la région. Certifié RGE, +5 000 chantiers, devis gratuit et rapide.";
        }

        return 'Normes Rénovation, spécialiste en rénovation énergétique : toiture, isolation, façade, VMC, électrique. Certifié RGE. Devis gratuit sous 48h.';
    }
}
