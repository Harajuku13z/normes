<?php

/**
 * Valeurs par défaut de la page d'accueil (fusionnées avec la base `home_sections`).
 *
 * @return array<string, mixed>
 */
return [
    'meta' => [
        'title' => 'Normes & Rénovation — Rénovation énergétique en Bourgogne',
        'description' => 'Normes & Rénovation accompagne vos projets de rénovation énergétique, thermique et électrique en Bourgogne. Devis gratuit, entreprise certifiée RGE.',
        'description_social' => 'Devis gratuit, entreprise certifiée RGE en Bourgogne. Rénovation énergétique, thermique, électrique et toiture — accompagnement complet.',
        'og_image' => 'logo.png',
        'og_image_alt' => 'Normes & Rénovation — logo',
        'theme_color' => '#2F4251',
        'favicon' => '/iconne.png',
        'site_name' => 'Normes & Rénovation',
    ],

    'styles' => [
        'footer_bg' => '/slide/toiture.png',
        'aides_bg' => 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?auto=format&fit=crop&w=2000&q=80',
    ],

    'header' => [
        'logo' => '/logo.png',
        'logo_alt' => 'Normes & Renovation',
        'social' => [
            ['network' => 'facebook', 'url' => '#', 'label' => 'Facebook'],
            ['network' => 'linkedin', 'url' => '#', 'label' => 'LinkedIn'],
            ['network' => 'instagram', 'url' => '#', 'label' => 'Instagram'],
        ],
    ],

    'hero' => [
        'slides' => [
            [
                'image' => 'slide/toiture.png',
                'title' => 'Travaux de toiture durables et performants',
                'subtitle' => 'Protection, etancheite et renovation complete de votre toiture pour valoriser votre maison.',
                'primary_text' => 'Devis toiture',
                'primary_href' => '#devis',
                'secondary_text' => 'Nous contacter',
                'secondary_href' => '#devis',
            ],
            [
                'image' => 'slide/solaire.png',
                'title' => 'Photovoltaique: produisez votre propre energie',
                'subtitle' => 'Installez des panneaux solaires performants et reduisez durablement vos factures.',
                'primary_text' => 'Etude photovoltaique',
                'primary_href' => '#services',
                'secondary_text' => 'Nous contacter',
                'secondary_href' => '#devis',
            ],
        ],
    ],

    'simulateur' => [
        'label' => 'Entrez votre adresse (simulateur)',
        'placeholder' => 'Ex: 6 rue Pierre de Coubertin, Chalon-sur-Saone',
        'button' => 'Lancer le simulateur',
    ],

    'floating' => [
        'google_url' => 'https://share.google/14Nu70a8PfwWT4P4p',
        'logo' => '/logo.png',
        'title' => '5.0/5 — Avis Google',
        'subtitle' => '★★★★★',
        'subtitle_suffix' => '+100 avis',
        'link_text' => 'Voir les avis →',
        'phone' => '+33385419886',
        'phone_display' => '03 85 41 98 86',
    ],

    'sidebar_avis' => [
        'google_url' => 'https://share.google/14Nu70a8PfwWT4P4p',
        'icon' => '/iconne.png',
        'icon_alt' => 'Icone Normes & Renovation',
        'label' => 'Avis Google',
        'score' => '5.0/5',
        'stars' => '★★★★★',
        'text' => '+100 avis',
    ],

    'services' => [
        'title_accent' => 'Nos services',
        'title_rest' => ' de renovation',
        'intro' => 'Découvrez nos services principaux, pensés pour protéger, améliorer et valoriser votre habitat.',
        'items' => [
            [
                'num' => 1,
                'category' => 'toiture',
                'image' => 'services/nettoyage-demoussage-toiture.jpeg',
                'title' => 'Traitement et démoussage de toiture',
                'description' => 'Nettoyage complet, élimination des mousses et application de traitement hydrofuge pour protéger durablement votre toiture.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 2,
                'category' => 'toiture',
                'image' => 'slide/toiture.png',
                'title' => 'Remplacement de couverture et zinguerie',
                'description' => 'Réfection complète de toiture, pose de tuiles et éléments de zinguerie pour garantir l’étanchéité et la longévité.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 3,
                'category' => 'isolation',
                'image' => 'services/isolation-thermique.jpeg',
                'title' => 'Isolation thermique',
                'description' => 'Isolation des combles, rampants et planchers pour améliorer le confort et réduire les pertes de chaleur.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 4,
                'category' => 'air',
                'image' => 'services/ventilation-vmc-vmi.jpg',
                'title' => 'Ventilation (VMC / VMI)',
                'description' => 'Installation de systèmes de ventilation pour assainir l’air intérieur et lutter contre l’humidité.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 5,
                'category' => 'energie',
                'image' => 'services/installation-photovoltaique.jpg',
                'title' => 'Installation photovoltaïque',
                'description' => 'Production d’électricité solaire pour réduire vos factures et améliorer votre autonomie énergétique.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 6,
                'category' => 'air',
                'image' => 'services/climatisation-ete.jpg',
                'title' => 'Climatisation',
                'description' => 'Installation de systèmes de climatisation performants pour un intérieur confortable en toute saison.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 7,
                'category' => 'menuiserie',
                'image' => 'services/menuiserie2.jpg',
                'title' => 'Menuiserie',
                'description' => 'Installation et remplacement de fenêtres, portes et menuiseries pour améliorer l’isolation et la sécurité.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 8,
                'category' => 'facade',
                'image' => 'services/renovation-facade.jpeg',
                'title' => 'Rénovation de façade',
                'description' => 'Nettoyage, peinture et traitement de façade pour protéger et valoriser votre habitation.',
                'cta' => 'En savoir plus',
            ],
            [
                'num' => 9,
                'category' => 'autres',
                'image' => 'services/traitement-charpente.webp',
                'title' => 'Autres services',
                'description' => 'Adoucisseur d’eau, traitement de charpente, entretien des gouttières et solutions complémentaires pour une maison saine.',
                'cta' => 'En savoir plus',
            ],
        ],
    ],

    'realisations' => [
        'title_accent' => 'Avant',
        'title_rest' => ' / Apres',
        'intro' => 'Comparez plusieurs chantiers et voyez l\'impact concret de nos renovations.',
        'buttons' => [
            ['case' => 1, 'label' => 'Toiture'],
            ['case' => 2, 'label' => 'Façade'],
        ],
        'cases' => [
            ['before' => 'avantapres/toitureavant.png', 'after' => 'avantapres/toitureapres.png'],
            ['before' => 'avantapres/facadeavant.png', 'after' => 'avantapres/facadeapres.png'],
        ],
        'cta_title' => 'Vous avez un projet de rénovation ?',
        'cta_text' => 'Décrivez votre besoin : nous vous recontactons rapidement avec un accompagnement personnalisé, vos options d\'aides et une première base pour votre devis.',
        'cta_button' => 'Ouvrir le simulateur de devis',
        'cta_href' => '#devis',
        'promo_kicker' => 'Realisations',
        'promo_title' => 'Voir toutes nos realisations',
        'promo_text' => 'Decouvrez nos chantiers avant/apres et les transformations deja realisees pour nos clients.',
        'promo_button' => 'Explorer les realisations',
        'promo_bg' => 'avantapres/toitureapres.png',
    ],

    'about' => [
        'title' => 'À propos de Normes & Rénovation',
        'body' => 'Normes & Rénovation accompagne les particuliers et professionnels dans leurs projets de rénovation énergétique, thermique et électrique. Notre équipe combine expertise technique, suivi de chantier et conseils sur mesure pour des résultats fiables et durables. Nous sommes certifiés RGE, engagés dans le respect de l\'environnement et nous privilégions des matériaux de qualité pour des rénovations performantes et responsables.',
        'commitments_heading' => 'Nos engagements',
        'commitments' => [
            'Garantie sur les travaux réalisés',
            'Nous nous occupons de tout pour vous simplifier la vie',
            'Techniciens qualifiés et formés en continu',
            'Entreprise certifiée et orientée qualité',
            'Accompagnement complet de l\'étude à la livraison',
            'Solutions performantes pour valoriser votre bien',
        ],
        'cert_images' => [
            ['src' => '/nous/rge.png', 'alt' => 'Logo RGE Qualibat'],
            ['src' => '/nous/rge ventilation_.png', 'alt' => 'Logo RGE Ventilation'],
            ['src' => '/nous/ECO.png', 'alt' => 'Logo Eco Responsable'],
        ],
        'team_image' => '/nous/equipe.jpeg',
        'team_alt' => 'Équipe Normes & Rénovation',
    ],

    'agences' => [
        'title_accent' => 'Nos',
        'title_rest' => ' agences',
        'intro' => 'Retrouvez nos 2 agences principales et les départements mis en avant sur la carte.',
        'agencies' => [
            [
                'badge' => 'DÉPARTEMENT 71',
                'name' => 'Agence Chalon-sur-Saône',
                'address' => '6 rue Pierre de Coubertin, 71100 Chalon-sur-Saône',
                'phone' => '03 85 41 98 86',
                'phone_href' => '+33385419886',
            ],
            [
                'badge' => 'DÉPARTEMENT 22 — BRETAGNE',
                'name' => 'Agence Bretagne',
                'address' => 'ZA de Mikez — 22540 Pédernec',
                'phone' => '02 96 40 07 55',
                'phone_href' => '+33296400755',
            ],
        ],
        'franchise' => [
            'image' => 'https://images.unsplash.com/photo-1556155092-490a1ba16284?auto=format&fit=crop&w=1200&q=80',
            'kicker' => 'RÉSEAU NORMES',
            'title' => 'Devenir franchisé',
            'text' => 'Rejoignez notre réseau et développez votre agence avec un accompagnement complet — contactez-nous pour en discuter.',
            'button' => 'Demander une présentation / devenir franchisé',
            'href' => '#devis',
        ],
        'map_box' => [
            'title_accent' => 'Carte',
            'title_rest' => ' des implantations',
            'legend_1' => 'Région Bretagne',
            'legend_2' => 'Départements 71 & 21',
        ],
    ],

    'pourquoi' => [
        'title_accent' => 'Pourquoi',
        'title_rest' => ' nous ?',
        'intro' => 'Des engagements concrets, visibles en un coup d\'œil.',
        'cards' => [
            ['emoji' => '🛠️', 'title' => 'Expertise technique', 'text' => 'Des équipes qualifiées et des conseils adaptés à votre maison.', 'ring' => 'brand-blue/15'],
            ['emoji' => '✅', 'title' => 'Entreprise certifiée RGE', 'text' => 'Un accompagnement conforme aux normes et aux aides en vigueur.', 'ring' => 'brand-yellow/25'],
            ['emoji' => '🌿', 'title' => 'Solutions durables', 'text' => 'Des produits et matériaux sélectionnés pour leur performance, leur longévité et un impact environnemental maîtrisé.', 'ring' => 'emerald-500/20'],
            ['emoji' => '🤝', 'title' => 'Accompagnement complet', 'text' => 'Un interlocuteur unique du devis jusqu\'à la fin de chantier.', 'ring' => 'sky-400/25', 'wide' => true],
        ],
    ],

    'processus' => [
        'title_accent' => 'Processus',
        'title_rest' => ' de prise en charge',
        'intro' => 'Quatre étapes claires, de l\'estimation de vos aides au suivi de chantier.',
        'steps' => [
            [
                'num' => '1',
                'num_style' => 'brand-blue',
                'title' => 'Calcul de primes et devis précis',
                'text' => 'Nous nous occupons du calcul de vos primes, des CEE (certificats d\'économies d\'énergie) et des options de financement. Travaux couverts jusqu\'à 90 % sans avance de frais dans les cas éligibles.',
            ],
            [
                'num' => '2',
                'num_style' => 'brand-dark-yellow',
                'title' => 'Solutions de financement',
                'text' => 'Des solutions adaptées avec nos partenaires pour financer le coût des travaux de rénovation.',
            ],
            [
                'num' => '3',
                'num_style' => 'brand-dark-white',
                'title' => 'Analyse personnalisée',
                'text' => 'Un technicien qualifié se déplace gratuitement pour un diagnostic approfondi de vos besoins.',
            ],
            [
                'num' => '4',
                'num_style' => 'gradient',
                'title' => 'Suivi et assistance continus',
                'text' => 'De la première consultation à la fin des travaux : suivi régulier et assistance pour une exécution sereine.',
                'span' => true,
            ],
        ],
    ],

    'aides_renov' => [
        'logo' => '/nous/ma prime.png',
        'logo_alt' => 'Programme MaPrimeRénov\' — Mieux chez moi, mieux pour la planète',
        'logo_caption' => 'MaPrimeRénov\' · dispositif national',
        'logo_sub' => 'Accompagnement dossier & cumul avec les CEE',
        'kicker' => 'Aides à la rénovation',
        'title' => 'On vous accompagne pour vos aides MaPrimeRénov\' et CEE',
        'body' => 'Notre équipe vous aide à comprendre vos droits, à monter les dossiers MaPrimeRénov\' et à valoriser les certificats d\'économies d\'énergie (CEE) éligibles sur votre projet. Nous optimisons le cumul des dispositifs pour limiter votre reste à charge et sécuriser vos travaux.',
        'button' => 'Demander un accompagnement',
        'footnote' => 'RGE · Devis gratuit · Réponse rapide',
    ],

    'stats' => [
        'items' => [
            ['value' => '+5000', 'label' => 'Chantiers réalisés', 'icon' => 'building'],
            ['value' => '98%', 'label' => 'Satisfaction client', 'icon' => 'star'],
            ['value' => '48h', 'label' => 'Prise en charge rapide', 'icon' => 'clock'],
            ['value' => '100%', 'label' => 'Devis gratuit', 'icon' => 'doc'],
        ],
    ],

    'avis' => [
        'title_accent' => 'Avis',
        'title_rest' => ' clients',
        'intro' => 'Ils nous font confiance pour leurs travaux de rénovation. Découvrez tous les retours sur notre fiche Google.',
        'google_url' => 'https://share.google/14Nu70a8PfwWT4P4p',
        'google_button' => 'Voir la fiche',
        'testimonials' => [
            [
                'platform' => 'google',
                'review_count' => '+100 avis',
                'text' => 'Équipe sérieuse, chantier propre et très bon résultat.',
                'author' => 'Claire M.',
                'deco_class' => 'bg-brand-blue/5'
            ],
            [
                'platform' => 'google',
                'review_count' => '+100 avis',
                'text' => 'Accompagnement pro du début à la fin et très bons conseils.',
                'author' => 'Julien R.',
                'deco_class' => 'bg-brand-yellow/10'
            ],
            [
                'platform' => 'travaux.com',
                'review_count' => '+60 avis',
                'text' => 'Intervention soignée, délais respectés et communication claire à chaque étape.',
                'author' => 'Marion B.',
                'deco_class' => 'bg-brand-blue/5'
            ],
            [
                'platform' => 'travaux.com',
                'review_count' => '+60 avis',
                'text' => 'Devis précis, équipe ponctuelle et conseils adaptés à notre maison.',
                'author' => 'Nicolas D.',
                'deco_class' => 'bg-brand-yellow/10'
            ],
            [
                'platform' => 'trustpilot',
                'review_count' => '+45 avis',
                'text' => 'Travail de qualité, finitions propres et équipe très à l\'écoute.',
                'author' => 'Sophie L.',
                'deco_class' => 'bg-emerald-500/10'
            ],
            [
                'platform' => 'google',
                'review_count' => '+100 avis',
                'text' => 'Très bon suivi du devis jusqu\'à la fin de chantier. Résultat impeccable.',
                'author' => 'Thomas K.',
                'deco_class' => 'bg-brand-blue/5'
            ],
        ],
    ],

    'devis' => [
        'title_line1' => 'Vous avez',
        'title_line2' => 'un projet de rénovation ?',
        'subtitle' => 'Estimation personnalisée & rappel d\'un conseiller',
        'intro' => 'Visualisez les grandes lignes de votre projet (toiture, surfaces, état du bien) — un interlocuteur vous rappelle pour affiner chiffrage et aides.',
        'response_note' => 'Réponse sous 48h en général — sans engagement.',
        'mobile_form_cta' => 'Remplir le formulaire',
        'contact_heading' => 'Contact agences',
        'agencies_contact' => [
            [
                'name' => 'Agence Chalon-sur-Saône',
                'lines' => ['6 rue Pierre de Coubertin', '71100 Chalon-sur-Saône'],
                'phone' => '03 85 41 98 86',
                'phone_href' => '+33385419886',
            ],
            [
                'name' => 'Agence Bretagne',
                'lines' => ['ZA de Mikez', '22540 Pédernec'],
                'phone' => '02 96 40 07 55',
                'phone_href' => '+33296400755',
            ],
        ],
        'email' => 'bourgogne-agence@normesrenovation.fr',
        'hours' => 'Horaires : du lundi au vendredi, sur rendez-vous — réponse sous 48h en général.',
        'sim_block' => [
            'kicker' => 'Simulateur de devis',
            'title' => 'Estimez les grandes lignes avec votre adresse',
            'text' => 'Accédez au bandeau simulateur : saisissez votre adresse pour lancer une première analyse ; un conseiller peut ensuite affiner avec vous.',
            'primary' => 'Lancer le simulateur',
            'primary_href' => '#simulateur-devis',
            'secondary' => 'Passer au formulaire',
            'secondary_href' => '#formulaire-contact',
        ],
        'form' => [
            'title' => 'Formulaire de contact',
            'intro' => 'Indiquez vos coordonnées et votre projet pour être rappelé(e) et recevoir une base de devis.',
            'note' => 'Ces informations nous permettent de préparer un devis pertinent.',
            'submit' => 'Envoyer ma demande — devis gratuit',
            'footer_note' => 'Sans engagement. Un conseiller vous rappelle pour affiner votre projet.',
        ],
    ],

    'blog' => [
        'title_accent' => 'Astuces',
        'title_rest' => ' & blog',
        'intro' => 'Conseils pratiques pour preparer vos travaux, mieux comprendre les aides et entretenir votre logement durablement.',
        'posts' => [
            [
                'tag' => 'Isolation',
                'title' => 'Combles perdus ou amenages : par ou commencer ?',
                'excerpt' => 'Les bonnes questions sur l\'epaisseur, la ventilation et l\'humidite avant de signer un devis d\'isolation.',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'link_text' => 'Demander un avis technique →',
                'href' => '#devis',
            ],
            [
                'tag' => 'Aides',
                'title' => 'MaPrimeRénov\' & CEE : cumul et dossier sans prise de tete',
                'excerpt' => 'Ce qui change souvent, les pieces a anticiper et comment une entreprise RGE vous aide a securiser vos droits.',
                'image' => 'https://images.unsplash.com/photo-1521791055366-0d553872125f?auto=format&fit=crop&w=1200&q=80',
                'link_text' => 'Parler a un conseiller →',
                'href' => '#devis',
            ],
            [
                'tag' => 'Entretien',
                'title' => 'Toiture : signes qui doivent declencher un controle',
                'excerpt' => 'Tuiles, zinguerie, isolation — reperer tot les traces d\'infiltration limite les grosses reparations.',
                'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80',
                'link_text' => 'Voir nos chantiers →',
                'href' => '#realisations',
                'wide' => true,
            ],
        ],
    ],

    'partners' => [
        'heading' => 'Partenaires & certification',
        'logos' => [
            // Logos "partenaires" (dossier public/partenaire)
            '/partenaire/Calque 2.png',
            '/partenaire/Calque 3.png',
            '/partenaire/Calque 4.png',
            '/partenaire/Calque 5.png',
            '/partenaire/Calque 6.png',
            '/partenaire/Calque 7.png',
            '/partenaire/Calque 8.png',
            '/partenaire/Calque 9.png',
            // Logos de certification RGE (dossier public/nous)
            '/nous/rge.png',
            '/nous/rge ventilation_.png',
            '/nous/ECO.png',
        ],
    ],

    'footer' => [
        'logo' => '/logofooter.png',
        'logo_alt' => 'Normes & Rénovation',
        'siege_title' => 'Siège social',
        'company' => 'Normes et Rénovation',
        'address_lines' => ['6 rue Pierre de Coubertin', '71100 Chalon-sur-Saône'],
        'legal' => 'Représentant légal · Conformément aux statuts · RCS Chalon-sur-Saône — 900 571 696 00013 · SIREN 900 571 696 · SIRET (siège) 900 571 696 00013 · TVA FR96 900 571 696',
        'phone' => '03 85 41 98 86',
        'phone_href' => '+33385419886',
        'email' => 'bourgogne-agence@normesrenovation.fr',
        'networks_note' => 'Lundi au vendredi sur rendez-vous. En urgence, appelez l\'agence la plus proche.',
        'copyright_name' => 'Normes et Rénovation',
        'bottom_line' => 'Entreprise RGE — Rénovation énergétique —',
        'bottom_link' => 'Demander un devis',
        'bottom_href' => '#devis',
        'social' => [
            ['network' => 'facebook', 'url' => '#', 'label' => 'Facebook Normes & Rénovation'],
            ['network' => 'linkedin', 'url' => '#', 'label' => 'LinkedIn Normes & Rénovation'],
            ['network' => 'instagram', 'url' => '#', 'label' => 'Instagram Normes & Rénovation'],
        ],
    ],

    'map' => [
        'locations' => [
            ['name' => 'Agence 71 - Chalon-sur-Saone', 'coords' => [46.781, 4.853], 'tag' => '71'],
            ['name' => 'Agence Bretagne - Pedernec', 'coords' => [48.595, -3.286], 'tag' => '22'],
        ],
    ],
];
