<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\Legacy\WordPressLegacyImporter;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('legacy:import-wordpress {xmlPath?} {--no-update}', function (?string $xmlPath = null) {
    $default = base_path('BD WORDPRESS/normesampreacutenovation.WordPress.2026-04-15.xml');
    $path = $xmlPath ?: $default;

    if (! is_file($path)) {
        $this->error('Fichier XML introuvable: '.$path);

        return 1;
    }

    /** @var WordPressLegacyImporter $importer */
    $importer = app(WordPressLegacyImporter::class);
    $stats = $importer->importFromXml($path, ! $this->option('no-update'));

    $this->info('Import terminé.');
    $this->line('Total items lus: '.$stats['total']);
    $this->line('Créées: '.$stats['created']);
    $this->line('Mises à jour: '.$stats['updated']);
    $this->line('Ignorées: '.$stats['skipped']);

    return 0;
})->purpose('Importe les anciennes URLs WordPress dans legacy_pages');
