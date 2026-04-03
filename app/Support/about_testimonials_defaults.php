<?php

/**
 * Avis affichés sur la page À propos (max. 3 visibles côté site ; modifiable via admin `about_page` > testimonials).
 *
 * @return list<array{author:string, time_ago?:string, text:string}>
 */
return [
    [
        'author' => 'Fabienne Commeau',
        'time_ago' => 'Il y a 1 an',
        'text' => 'Bravo à toute l\'équipe : efficacité, intervention rapide et sérieux de A à Z. Travail propre. Merci à Christophe, Thomas, Alexandre, Salvatore, Anthony, David et Ramzy, sans oublier les filles du bureau. Équipe remarquable, bravo à vous !',
    ],
    [
        'author' => 'Léo Caposiena',
        'time_ago' => 'Il y a 1 an',
        'text' => 'Je viens de faire le traitement de ma toiture avec Normes et Rénovation. Je remercie Christophe, Anthony, David et Thomas pour leur professionnalisme et la qualité du travail. Merci aussi au personnel des bureaux pour leur accompagnement. Je recommande vivement cette entreprise. M. Maréchal de Crissey.',
    ],
    [
        'author' => 'Roseline Genet',
        'time_ago' => 'Il y a 1 an',
        'text' => 'Merci à Salvator, Thomas, Christophe, David et Anthony, et le personnel administratif. Tous ensemble, une très bonne équipe.',
    ],
];
