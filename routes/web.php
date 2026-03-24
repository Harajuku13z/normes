<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response(
        '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>NORMES</title><style>body{margin:0;font-family:Arial,sans-serif;background:#f5f7fb;color:#1f2937}.wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}.card{background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;max-width:700px;width:100%;box-shadow:0 8px 24px rgba(0,0,0,.06)}h1{margin:0 0 8px}p{margin:0;line-height:1.6}</style></head><body><main class="wrap"><section class="card"><h1>Site entreprise en ligne</h1><p>Bienvenue sur NORMES. La page d\'accueil fonctionne.</p></section></main></body></html>'
    );
});
