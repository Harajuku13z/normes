<?php

return [
    /*
    | Mot de passe d'accès à l'interface /admin (à définir dans .env en production).
    */
    'password' => env('ADMIN_PASSWORD', 'changeme'),

    /*
    | Mot de passe du gate pour créer des users admin via /admin/adminuser.
    */
    'elizo_adminuser_password' => env('ELIZO_ADMINUSER_PASSWORD', 'elizo'),
];
