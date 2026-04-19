<?php

namespace Database\Seeders;

use App\Models\LegacyPage;
use Illuminate\Database\Seeder;

class LegacyPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'old_path' => 'votre-expert-en-solution-de-renovation-electrique-thermique-et-hygrometrique-pour-la-maison',
                'title' => 'Votre Expert en solution de rénovation électrique thermique et hygrométrique pour la maison',
                'excerpt' => 'Nous transformons votre maison pour un confort optimal et des économies d’énergie durables.',
                'is_active' => true,
            ],
            [
                'old_path' => 'expert-en-couverture-entretenez-et-protegez-votre-toiture-2',
                'title' => 'Expert en Couverture : Entretenez et Protégez Votre Toiture',
                'excerpt' => 'Optimisez le confort de votre maison et réduisez vos factures d\'énergie grâce à nos solutions d\'isolation sur mesure, adaptées pour améliorer l\'efficacité énergétique et le bien-être de votre intérieur.',
                'is_active' => true,
            ],
            [
                'old_path' => 'experts-en-solutions-efficaces-pour-traiter-lhumidite-et-preserver-votre-maison',
                'title' => 'Experts en Solutions Efficaces pour Traiter l’Humidité et Préserver Votre Maison',
                'excerpt' => 'Traitez l’humidité efficacement avec nos solutions spécialisées, telles que l\'inverseur de polarité et les traitements hydrofuges, pour améliorer la qualité de l\'air et protéger votre maison des dommages à long terme.',
                'is_active' => true,
            ],
            [
                'old_path' => 'expert-en-production-delectricite-kits-photovoltaiques-renouvelables',
                'title' => 'Expert en Production d’Électricité : Kits Photovoltaïques Renouvelables',
                'excerpt' => 'Devenez autonome en énergie avec nos kits photovoltaïques. Installez un système 3 kWc pour produire votre propre électricité et réduire vos factures tout en respectant l’environnement.',
                'is_active' => true,
            ],
            [
                'old_path' => 'experts-en-solutions-de-climatisation-restez-au-frais-pendant-lete',
                'title' => 'Experts en Solutions de Climatisation : Restez au Frais Pendant l’Été',
                'excerpt' => 'Restez au frais cet été grâce à nos solutions de climatisation. Profitez d’un confort optimal, même en période de canicule, avec l\'expertise de Normes.',
                'is_active' => true,
            ],
            [
                'old_path' => 'expert-en-renovation-de-facade-transformez-et-protegez-votre-maison',
                'title' => 'Expert en Rénovation de Façade : Transformez et Protégez Votre Maison',
                'excerpt' => 'Redonnez vie à votre façade avec nos services de rénovation : nettoyage, peinture, isolation et imperméabilisation. Améliorez l\'apparence et la durabilité de votre maison.',
                'is_active' => true,
            ],
            [
                'old_path' => 'expert-en-couverture-entretenez-et-protegez-votre-toiture',
                'title' => 'Expert en Couverture : Entretenez et Protégez Votre Toiture',
                'excerpt' => 'Prolongez la vie de votre toiture grâce à nos services : traitements hydrofuges, remplacement de faîtage, réparations de fuites et nettoyage professionnel.',
                'is_active' => true,
            ],
            [
                'old_path' => 'expert-en-ventilation-solutions-pour-un-interieur-sain-et-efficace',
                'title' => 'Expert en Ventilation : Solutions pour un Intérieur Sain et Efficace',
                'excerpt' => 'Améliorez la circulation de l\'air dans votre maison avec nos systèmes de ventilation, comme VMI Urban, VMI Cave, et VMI Lofty, pour un intérieur sain et confortable.',
                'is_active' => true,
            ],
            [
                'old_path' => 'expert-en-securisation-de-votre-installation-electrique-protegez-votre-maison-et-votre-famille',
                'title' => 'Expert en Sécurisation de Votre Installation Électrique : Protégez Votre Maison et Votre Famille',
                'excerpt' => 'Assurez la sécurité de votre maison et de votre famille avec une installation électrique fiable, conforme aux normes, pour une protection optimale au quotidien.',
                'is_active' => true,
            ],
            [
                'old_path' => 'experts-en-services-complementaires-pour-une-maison-saine-et-entretenue',
                'title' => 'Experts en Services Complémentaires pour une Maison Saine et Entretenue',
                'excerpt' => 'Profitez de nos services pour une maison en parfait état : adoucisseurs d\'eau, traitement de charpente, nettoyage de gouttières, et installation de systèmes de filtration.',
                'is_active' => true,
            ],
            [
                'old_path' => 'contactez-nous-pour-vos-projets-de-renovation-et-damelioration',
                'title' => 'Contactez-Nous pour Vos Projets de Rénovation et d\'Amélioration',
                'excerpt' => 'Discutez avec nos experts en rénovation pour des conseils personnalisés. Remplissez le formulaire, et nous vous répondrons rapidement pour concrétiser vos projets.',
                'is_active' => true,
            ],
            [
                'old_path' => 'a-propos-de-normes-et-renovation-expertise-et-engagement',
                'title' => 'À Propos de Normes et Rénovation : Expertise et Engagement',
                'excerpt' => 'Découvrez Normes et Rénovation : experts en rénovation, hydrométrie et plus. Votre partenaire pour des solutions fiables et innovantes.',
                'is_active' => true,
            ],
            [
                'old_path' => 'decouvrez-nos-projets-realisations-et-innovations',
                'title' => 'Découvrez Nos Projets : Réalisations et Innovations',
                'excerpt' => 'Explorez nos projets récents en rénovation, construction et gestion de l\'énergie. Découvrez comment nous transformons vos idées en réussites concrètes.',
                'is_active' => true,
            ],
            [
                'old_path' => 'astuces-conseils-ameliorez-votre-maison',
                'title' => 'Astuces & Conseils : Améliorez Votre Maison',
                'excerpt' => 'Découvrez nos astuces et conseils experts pour optimiser votre maison. Apprenez à améliorer l’efficacité énergétique, la durabilité, et le confort de votre habitat.',
                'is_active' => true,
            ],
            [
                'old_path' => 'astuces-conseils-dun-expert-pour-ameliorez-votre-maison',
                'title' => 'Astuces & Conseils d\'un expert pour améliorez votre maison',
                'is_active' => true,
            ],
            [
                'old_path' => '30-remise-pour-vos-travaux',
                'title' => '30% Remise pour vos travaux',
                'excerpt' => '5/5 avis sur Google grâce à notre expertise et notre engagement pour des rénovations de qualité.',
                'is_active' => true,
            ],
            [
                'old_path' => 'comment-financer-sa-renovation-guide-des-aides-et-solutions',
                'title' => 'Comment Financer sa Rénovation : Guide des Aides et Solutions',
                'is_active' => true,
            ],
            [
                'old_path' => 'installation-de-panneaux-solaires-en-bourgogne-franche-comte-un-guide-pratique',
                'title' => 'Installation de Panneaux Solaires en Bourgogne-Franche-Comté : Un Guide Pratique',
                'is_active' => true,
            ],
            [
                'old_path' => 'hydrofuge-incolore-realise-a-labergement-sainte-colombe-protection-durable-de-toiture',
                'title' => 'Hydrofuge Incolore Réalisé à L’Abergement-Sainte-Colombe : Protection Durable de Toiture',
                'is_active' => true,
            ],
            [
                'old_path' => 'enduit-rpe-avec-armature-a-blanzy',
                'title' => 'Enduit RPE avec Armature à Blanzy',
                'is_active' => true,
            ],
            [
                'old_path' => 'traitement-hydrofuge-incolore-a-cluny',
                'title' => 'Traitement Hydrofuge Incolore à Cluny',
                'is_active' => true,
            ],
            [
                'old_path' => 'ravalement-et-peinture-a-liernais',
                'title' => 'Ravalement et Peinture à Liernais',
                'is_active' => true,
            ],
            [
                'old_path' => 'hydrofuge-incolore-et-ravalement-de-facade-a-tronchy',
                'title' => 'Hydrofuge Incolore et Ravalement de Façade à Tronchy',
                'is_active' => true,
            ],
            [
                'old_path' => 'isolation-soufflee-avec-encadrement-bois-a-chalon-sur-saone',
                'title' => 'Isolation Soufflée avec Encadrement Bois à Chalon-sur-Saône',
                'is_active' => true,
            ],
            [
                'old_path' => 'maison-pilote-comment-renover-votre-habitation-en-bourgogne-franche-comte-avec-25-et-0e-dacompte',
                'title' => 'Maison Pilote : Comment rénover votre habitation en Bourgogne-Franche-Comté avec -25% et 0€ d’acompte !',
                'excerpt' => 'Bénéficiez de -25% sur vos travaux de couverture, isolation et façade avec l’offre Maison Pilote, valable à Chalon-sur-Saône et en Bourgogne-Franche-Comté, sans acompte.',
                'is_active' => true,
            ],
            [
                'old_path' => 'gagnez-jusqua-600e-grace-a-notre-programme-de-parrainage-exclusif',
                'title' => 'Gagnez jusqu’à 600€ grâce à notre programme de parrainage exclusif !',
                'is_active' => true,
            ],
            [
                'old_path' => 'renovation-a-dijon-et-en-cote-dor',
                'title' => 'Entreprise de rénovation à Dijon et en Côte-d’Or – Normes Rénovation',
                'excerpt' => 'Travaux de toiture, isolation, électricité  ou façade à Dijon et en Côte-d’Or. Devis gratuit en ligne, expert local en rénovation énergétique.',
                'is_active' => true,
            ],
            [
                'old_path' => 'renovation-a-auxerre-et-dans-lyonne-89-normes-renovation',
                'title' => 'Rénovation à Auxerre et dans l’Yonne (89) – Normes Rénovation',
                'excerpt' => 'Travaux de toiture, isolation, façade à Auxerre et alentours. Normes Rénovation, votre expert local en performance énergétique. Devis gratuit.',
                'is_active' => true,
            ],
            [
                'old_path' => 'renovation-a-chalon-sur-saone-et-en-saone-et-loire-71',
                'title' => 'Rénovation à Chalon-sur-Saône et en Saône-et-Loire (71)',
                'excerpt' => 'Travaux de toiture, isolation, façade à Chalon, Mâcon et en Saône-et-Loire. Normes Rénovation, votre expert local. Devis rapide et gratuit.',
                'is_active' => true,
            ],
            [
                'old_path' => 'devenez-franchise-normes-renovation',
                'title' => 'Devenez Franchisé Normes Rénovation et Lancez Votre Entreprise avec Succès',
                'excerpt' => 'Découvrez comment devenir franchisé Normes et bénéficiez de notre expertise en rénovation énergétique. Rejoignez un réseau en croissance et lancez votre entreprise avec succès.',
                'is_active' => true,
            ],
            [
                'old_path' => 'nos-realisations',
                'title' => 'Nos réalisations',
                'excerpt' => 'Avant / Après, détails techniques, photos du chantier, témoignages… parcourez notre galerie pour vous inspirer et imaginer ce que nous pourrions accomplir chez vous.',
                'is_active' => true,
            ],
            [
                'old_path' => 'franchise',
                'title' => 'Devenez franchisé Normes Rénovation !',
                'excerpt' => 'Devenez franchisé Normes Rénovation avec seulement 10.000 € d’apport. Bénéficiez de 60 RDV clients qualifiés dès le lancement et visez jusqu’à 1.800.000 € de chiffre d’affaires en 2 ans. Rejoignez un réseau certifié RGE et démarrez votre activité dans la rénovation énergétique !',
                'is_active' => true,
            ],
            [
                'old_path' => 'simulateur-devis',
                'title' => 'Simulateur de Devis',
                'is_active' => true,
            ],
            [
                'old_path' => 'protegez-votre-maison-avec-lhydrofuge',
                'title' => 'Protégez votre maison avec l’hydrofuge',
                'is_active' => true,
            ],
            [
                'old_path' => 'vos-travaux-de-renovation-a-macon-et-alentours-isolation-toiture-facades-electricite-et-plus',
                'title' => 'Vos Travaux de Rénovation à Mâcon et Alentours : Isolation, Toiture, Façades, Électricité et Plus',
                'excerpt' => 'Spécialiste de la rénovation à Mâcon et ses alentours, Normes et Rénovation propose une expertise complète en isolation, toiture, façades, électricité et traitement de l’humidité.',
                'is_active' => true,
            ],
            [
                'old_path' => 'ce-qui-change-en-2025-pour-la-transition-energetique-en-bourgogne-franche-comte',
                'title' => 'Ce qui change en 2025 pour la transition énergétique en Bourgogne-Franche-Comté',
                'excerpt' => 'Découvrez les principales évolutions de la transition énergétique en 2025 en Bourgogne-Franche-Comté, avec des mesures clés et des opportunités pour la région.',
                'is_active' => true,
            ],
            [
                'old_path' => 'cest-quoi-un-ravalement-de-facade',
                'title' => 'C’est quoi un ravalement de façade ?',
                'excerpt' => 'Redonnez éclat et durabilité à votre bâtiment avec un ravalement de façade alliant esthétique et performance énergétique.',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-hydrofuger-sa-toiture',
                'title' => 'Pourquoi hydrofuger sa toiture ?',
                'excerpt' => 'L’hydrofugation protège votre toit des infiltrations, améliore son étanchéité, prolonge sa durée de vie et redonne de l’éclat avec des options comme les hydrofuges colorés.',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-ventiler-sa-maison-tout-savoir-sur-la-vmc',
                'title' => 'Pourquoi ventiler sa maison ? tout savoir sur la VMC',
                'excerpt' => 'Découvrez tout sur la Ventilation Mécanique Contrôlée (VMC) : ses avantages, son fonctionnement et nos solutions sur-mesure certifiées RGE chez Normes Rénovation. Respirez un air sain tout en économisant de l’énergie !',
                'is_active' => true,
            ],
            [
                'old_path' => 'quel-budget-prevoir-pour-hydrofuger-sa-toiture-en-2025',
                'title' => 'Quel budget prévoir pour hydrofuger sa toiture en 2025 ?',
                'excerpt' => 'Protégez votre toiture avec un traitement hydrofuge : prix, types de produits, avantages, et conseils pour optimiser votre budget en 2025. Découvrez tout ici !',
                'is_active' => true,
            ],
            [
                'old_path' => 'cest-quoi-lisolation-des-combles-perdus',
                'title' => 'C’est quoi l’isolation des combles perdus ?',
                'excerpt' => 'L’isolation des combles perdus est une solution essentielle pour améliorer le confort thermique et réduire les dépenses énergétiques dans une habitation.',
                'is_active' => true,
            ],
            [
                'old_path' => 'comment-eliminer-lhumidite-durablement-les-bonnes-pratiques',
                'title' => 'Comment Éliminer l’Humidité Durablement ?  Les Bonnes Pratiques',
                'excerpt' => 'L’humidité peut causer des dommages structurels et impacter la santé des occupants d’un logement. Ce guide pratique vous explique comment identifier les causes de l’humidité (ventilation insuffisante, infiltrations, remontées capillaires) et adopter les meilleures solutions pour l’éliminer durablement. Découvrez les techniques conformes aux normes en vigueur, les traitements adaptés (VMC, hydrofuges, résines d’étanchéité) et les conseils d’entretien pour garantir un environnement sain et confort',
                'is_active' => true,
            ],
            [
                'old_path' => 'ai-je-droit-aux-aides-ce-quil-faut-savoir-en-2025',
                'title' => 'Ai-je droit aux aides ? Ce qu\'il faut savoir en 2025',
                'excerpt' => 'Ai-je droit aux aides ? Découvrez les dispositifs de rénovation énergétique en 2025, leurs conditions d’éligibilité et comment maximiser vos financements.',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-est-il-important-de-faire-un-traitement-preventif-de-votre-charpente',
                'title' => 'Pourquoi est-il important de faire un traitement préventif de votre charpente ?',
                'excerpt' => 'Protégez votre charpente avec un traitement préventif contre insectes et champignons. Assurez sa durabilité et évitez des réparations coûteuses.',
                'is_active' => true,
            ],
            [
                'old_path' => 'climatiseur-ventilation-isolation-le-guide-complet-pour-un-ete-au-frais',
                'title' => 'Climatiseur, ventilation, isolation : le guide complet pour un été au frais',
                'is_active' => true,
            ],
            [
                'old_path' => 'lete-la-saison-ideale-pour-booster-le-confort-de-votre-maison-et-reduire-vos-factures',
                'title' => 'L\'Été : La Saison Idéale pour Booster le Confort de Votre Maison et Réduire Vos Factures !',
                'excerpt' => 'L\'été, c\'est le moment idéal pour vos travaux de climatisation et d\'isolation ! Normes Rénovation vous aide à booster votre confort et réduire vos factures, avec des aides de l\'État jusqu\'à 90%. Projets en Bourgogne Franche-Comté et Bretagne.',
                'is_active' => true,
            ],
            [
                'old_path' => 'limportance-des-normes-en-renovation',
                'title' => 'L\'Importance des Normes en Rénovation',
                'excerpt' => 'Rénover, oui… mais dans les règles de l’art ! Avant de signer un devis ou de casser une cloison, pensez NORMES : sécurité, conformité, performance énergétique, valorisation de votre bien…',
                'is_active' => true,
            ],
            [
                'old_path' => 'maprimerenov-fait-une-pause-pas-de-panique-on-vous-explique-toutes-les-alternatives-pour-vos-travaux',
                'title' => 'MaPrimeRénov\' fait une pause : Pas de panique, on vous explique toutes les alternatives pour vos travaux !',
                'excerpt' => 'MaPrimeRénov\', l\'aide phare à la rénovation énergétique, est sur le point d\'être suspendue temporairement à partir de juillet 2025, potentiellement jusqu\'à la fin de l\'année',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-faire-verifier-sa-toiture-apres-une-tempete-ou-de-fortes-pluies',
                'title' => 'Pourquoi faire vérifier sa toiture après une tempête ou de fortes pluies ?',
                'excerpt' => 'aites inspecter votre toiture après une tempête pour éviter les infiltrations, moisissures et gros travaux. Intervention rapide et gratuite.',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-faire-un-demoussage-de-toiture-avantages-risques-et-solutions-durables',
                'title' => 'Pourquoi faire un démoussage de toiture ? Avantages, risques et solutions durables',
                'excerpt' => 'La toiture est le premier rempart de votre maison contre les intempéries. Soumise au vent, à la pluie, à la pollution et à l’humidité, elle devient un terrain fertile pour le développement de mousses, algues et lichens.',
                'is_active' => true,
            ],
            [
                'old_path' => 'quel-budget-prevoir-pour-un-demoussage-de-toiture',
                'title' => 'Quel budget prévoir pour un démoussage de toiture ?',
                'excerpt' => 'Démoussage toiture : quel budget ? Découvrez les prix moyens au m² (9-40€), facteurs clés, et méthodes (drone, hydrofuge). Optez pour un pro pour un toit protégé et durable.',
                'is_active' => true,
            ],
            [
                'old_path' => 'lhiver-se-prepare-des-aujourdhui-optimisez-lisolation-de-votre-toiture',
                'title' => 'L’hiver se prépare dès aujourd’hui : Optimisez l’isolation de votre toiture',
                'excerpt' => 'Préparez votre maison pour l’hiver dès septembre avec Normes Rénovation. Découvrez nos solutions d’isolation des combles, toiture, rampants et planchers pour réduire vos factures d’énergie, améliorer votre confort thermique et profiter des aides financières disponibles.',
                'is_active' => true,
            ],
            [
                'old_path' => 'quel-budget-prevoir-pour-votre-isolation',
                'title' => 'Quel budget prévoir pour votre isolation ?',
                'excerpt' => 'Préparez votre budget isolation maison et découvrez nos conseils, prix, matériaux et aides financières pour réduire vos factures et améliorer votre confort.',
                'is_active' => true,
            ],
            [
                'old_path' => 'comment-proteger-votre-toiture-des-premieres-pluies-dautomne-et-des-intemperies',
                'title' => 'Comment protéger votre toiture des premières pluies d’automne et des intempéries',
                'excerpt' => 'L\'automne met votre toiture à rude épreuve ! Protégez votre maison des pluies, du vent et du gel. Découvrez nos conseils d\'entretien et l\'importance d\'un professionnel RGE. Demandez votre diagnostic gratuit !',
                'is_active' => true,
            ],
            [
                'old_path' => 'couvreur-a-chalon-sur-saone-votre-expert-en-toiture-pour-la-saone-et-loire',
                'title' => 'Couvreur à Chalon-sur-Saône : votre expert en toiture pour la Saône-et-Loire',
                'is_active' => true,
            ],
            [
                'old_path' => 'entreprise-de-couverture-a-chalon-sur-saone',
                'title' => 'Entreprise de couverture à Chalon-sur-Saône',
                'is_active' => true,
            ],
            [
                'old_path' => 'couvreur-en-saone-et-loire-71-travaux-de-toiture-zinguerie',
                'title' => 'Couvreur en Saône-et-Loire (71) : travaux de toiture, zinguerie',
                'is_active' => true,
            ],
            [
                'old_path' => 'top-5-des-meilleurs-couvreurs-a-chalon-sur-saone-et-ses-environs',
                'title' => 'Top 5 des meilleurs couvreurs à Chalon-sur-Saône et ses environs',
                'is_active' => true,
            ],
            [
                'old_path' => 'couvreur-a-chalon-sur-saone-reparation-et-renovation-de-toiture',
                'title' => 'Couvreur à Chalon-sur-Saône : réparation et rénovation de toiture',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-faire-appel-a-un-couvreur-professionnel-a-chalon-sur-saone',
                'title' => 'Pourquoi faire appel à un couvreur professionnel à Chalon-sur-Saône ?',
                'is_active' => true,
            ],
            [
                'old_path' => 'couvreur-a-chalon-sur-saone-pose-et-renovation-de-toiture',
                'title' => 'Couvreur à Chalon-sur-Saône – Pose et rénovation de toiture',
                'excerpt' => 'Vous recherchez un couvreur expérimenté à Chalon-sur-Saône pour la pose, la réparation ou la rénovation complète de votre toiture ? Un savoir-faire artisanal pour tous vos travaux de toiture    Fort de plusieurs années d’expérience, notre entreprise de couverture à Chalon-sur-Saône intervient sur tous types de toits : tuiles en terre cuite, ardoises naturelles, zinc, bac acier ou encore toitures plates modernes.',
                'is_active' => true,
            ],
            [
                'old_path' => 'couverture-et-toiture-a-buxy-71-comment-choisir-un-expert-fiable',
                'title' => 'Couverture et toiture à Buxy (71) : comment choisir un expert fiable ?',
                'is_active' => true,
            ],
            [
                'old_path' => 'isolation-thermique-a-buxy-reduisez-vos-factures-denergie-des-maintenant',
                'title' => 'Isolation thermique à Buxy : réduisez vos factures d’énergie dès maintenant',
                'is_active' => true,
            ],
            [
                'old_path' => 'renovation-de-facade-a-buxy-conseils-pour-un-resultat-durable-et-esthetique',
                'title' => 'Rénovation de façade à Buxy : conseils pour un résultat durable et esthétique',
                'is_active' => true,
            ],
            [
                'old_path' => 'top-10-des-couvreurs-a-buxy-71top-10-des-couvreurs-a-buxy-71-guide-pour-choisir-le-meilleur-experttop-10-des-couvreurs-a-buxy-71',
                'title' => 'Top 10 des couvreurs à Buxy (71)Top 10 des couvreurs à Buxy (71) : guide pour choisir le meilleur expertTop 10 des couvreurs à Buxy (71)',
                'is_active' => true,
            ],
            [
                'old_path' => 'normes-renovation-a-buxy-votre-specialiste-en-renovation-de-maison',
                'title' => 'Normes Rénovation à Buxy : votre spécialiste en rénovation de maison',
                'is_active' => true,
            ],
            [
                'old_path' => 'isolation-des-combles-a-buxy-ameliorer-votre-confort-et-economiser-lenergie',
                'title' => 'Isolation des combles à Buxy : améliorer votre confort et économiser l’énergie',
                'is_active' => true,
            ],
            [
                'old_path' => 'top-10-des-meilleurs-artisans-couvreurs-en-bretagne-le-guide-ultime-pour-votre-toiture',
                'title' => 'Top 10 des Meilleurs Artisans Couvreurs en Bretagne : Le Guide Ultime pour Votre Toiture',
                'is_active' => true,
            ],
            [
                'old_path' => 'comment-bien-choisir-son-artisan-couvreur-en-bretagne-5-criteres-essentiels',
                'title' => 'Comment Bien Choisir son Artisan Couvreur en Bretagne : 5 Critères Essentiels',
                'is_active' => true,
            ],
            [
                'old_path' => 'renovation-toiture-bretagne-7-signes-incontournables-quil-est-temps-de-renover-votre-toit',
                'title' => 'Rénovation Toiture Bretagne : 7 Signes Incontournables qu\'il est Temps de Rénover Votre Toit',
                'excerpt' => 'Comment choisir votre couvreur en Bretagne ? Suivez nos 5 conseils essentiels pour trouver un artisan fiable et certifié RGE pour la rénovation et l\'entretien de votre toiture.',
                'is_active' => true,
            ],
            [
                'old_path' => 'aides-renovation-toiture-bretagne-comment-financer-vos-travaux-en-2025',
                'title' => 'Aides Rénovation Toiture Bretagne : Comment Financer vos Travaux en 2025 ?',
                'is_active' => true,
            ],
            [
                'old_path' => 'hydrofuge-toiture-bretagne-le-traitement-ultime-pour-impermeabiliser-et-proteger-votre-toit',
                'title' => 'Hydrofuge Toiture Bretagne : Le Traitement Ultime pour Imperméabiliser et Protéger Votre Toit',
                'is_active' => true,
            ],
            [
                'old_path' => 'urgence-fuite-toiture-bretagne-qui-appeler-et-les-premiers-gestes-qui-sauvent',
                'title' => 'Urgence Fuite Toiture Bretagne : Qui Appeler et les Premiers Gestes qui Sauvent',
                'is_active' => true,
            ],
            [
                'old_path' => 'classement-des-meilleurs-artisans-couvreurs-en-bretagne-notre-selection-2025',
                'title' => 'Classement des Meilleurs Artisans Couvreurs en Bretagne : Notre Sélection 2025',
                'is_active' => true,
            ],
            [
                'old_path' => 'preparer-sa-toiture-pour-lhiver-en-bretagne-le-guide-complet-de-lentretien-dautomne-2025',
                'title' => 'Préparer sa Toiture pour l\'Hiver en Bretagne : Le Guide Complet de l\'Entretien d\'Automne 2025',
                'is_active' => true,
            ],
            [
                'old_path' => 'toiture-ardoise-bretagne-le-guide-complet-pour-la-renovation-et-lentretien',
                'title' => 'Toiture Ardoise Bretagne : Le Guide Complet pour la Rénovation et l\'Entretien',
                'is_active' => true,
            ],
            [
                'old_path' => 'zinguerie-bretagne-le-role-cle-des-gouttieres-et-cheneaux-pour-proteger-votre-maison',
                'title' => 'Zinguerie Bretagne : Le Rôle Clé des Gouttières et Chéneaux pour Protéger Votre Maison',
                'is_active' => true,
            ],
            [
                'old_path' => 'isolation-de-la-toiture-le-guide-complet-pour-preparer-votre-maison-et-optimiser-vos-economies-avant-lhiver',
                'title' => 'Isolation de la Toiture : Le Guide Complet pour Préparer Votre Maison et Optimiser vos Économies Avant l\'Hiver',
                'is_active' => true,
            ],
            [
                'old_path' => 'pourquoi-faire-appel-a-un-couvreur-professionnel-a-macon',
                'title' => 'Pourquoi faire appel à un couvreur professionnel à Mâcon ?',
                'is_active' => true,
            ],
            [
                'old_path' => 'travaux-de-toiture-a-macon-et-alentours-guide-complet-pour-bien-renover',
                'title' => 'Travaux de toiture à Mâcon et alentours : guide complet pour bien rénover',
                'is_active' => true,
            ],
            [
                'old_path' => 'isolation-et-etancheite-de-toiture-lexpertise-des-couvreurs-a-macon',
                'title' => 'Isolation et étanchéité de toiture : l’expertise des couvreurs à Mâcon',
                'is_active' => true,
            ],
            [
                'old_path' => 'couvreur-a-macon-tarifs-devis-et-conseils-pour-vos-projets-toiture',
                'title' => 'Couvreur à Mâcon : tarifs, devis et conseils pour vos projets toiture',
                'is_active' => true,
            ],
            [
                'old_path' => 'couvreur-a-macon-tarifs-devis-et-conseils-pour-vos-projets-toiture-normes-renovation',
                'title' => 'Couvreur à Mâcon : tarifs, devis et conseils pour vos projets toiture | Normes Rénovation',
                'is_active' => true,
            ],
            [
                'old_path' => 'comment-savoir-si-votre-isolation-doit-etre-refaite-7-controles-simples',
                'title' => 'Comment savoir si votre isolation doit être refaite : 7 contrôles simples',
                'is_active' => true,
            ],
            [
                'old_path' => 'renover-sa-toiture-avec-normes-renovation-guide-complet-conseils-pratiques',
                'title' => 'Rénover sa toiture avec Normes Rénovation — Guide complet & conseils pratiques',
                'is_active' => true,
            ],
            [
                'old_path' => 'guide-complet-sur-lhydrofuge-a-chalon-sur-saone',
                'title' => 'Guide complet sur l\'hydrofuge à Chalon-sur-Saône',
                'excerpt' => 'Découvrez tout ce qu\'il faut savoir sur Hydrofuge à Chalon-sur-Saône. Normes &amp; R&eacute;novation vous propose des solutions professionnelles et adaptées ...',
                'is_active' => true,
            ],
            [
                'old_path' => 'aides-renovation-2026-guide-des-aides-nouvelles-normes',
                'title' => 'Aides Rénovation 2026 : Guide des Aides & Nouvelles Normes',
                'is_active' => true,
            ],
            [
                'old_path' => 'choisir-le-bon-type-de-toiture-materiaux-couleurs-et-criteres-de-decision',
                'title' => 'Choisir le bon type de toiture : matériaux, couleurs et critères de décision',
                'is_active' => true,
            ],
            [
                'old_path' => 'preparez-votre-maison-pour-lete-les-solutions-durables-contre-la-chaleur',
                'title' => 'Préparez votre maison pour l’été : les solutions durables contre la chaleur',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $data) {
            LegacyPage::firstOrCreate(['old_path' => $data['old_path']], $data);
        }
    }
}
