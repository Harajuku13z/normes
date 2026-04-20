<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\Legacy\WordPressLegacyImporter;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('legacy:import-wordpress {xmlPath?} {--no-update} {--fresh}', function (?string $xmlPath = null) {
    ini_set('memory_limit', '512M');

    $default = base_path('BD WORDPRESS/normesampreacutenovation.WordPress.2026-04-15.xml');
    $path = $xmlPath ?: $default;

    if (! is_file($path)) {
        $this->error('Fichier XML introuvable: ' . $path);
        return 1;
    }

    /** @var WordPressLegacyImporter $importer */
    $importer = app(WordPressLegacyImporter::class);
    $updateExisting = ! $this->option('no-update');

    // --fresh : supprime toutes les pages legacy non verrouillées avant import
    if ($this->option('fresh')) {
        $deleted = \App\Models\LegacyPage::query()->where('content_locked', false)->delete();
        $this->warn("Mode --fresh : $deleted pages legacy supprimées (non verrouillées).");
    }

    $this->info('Lecture du XML…');
    $result = $importer->importAllFromXml($path, $updateExisting);

    $p = $result['pages'];
    $b = $result['posts'];

    $this->info('');
    $this->info('─── Pages legacy (ad + page → legacy_pages) ───');
    $this->line('  Total lus    : ' . $p['total']);
    $this->line('  Créées       : ' . $p['created']);
    $this->line('  Mises à jour : ' . $p['updated']);
    $this->line('  Ignorées     : ' . $p['skipped']);

    $this->info('');
    $this->info('─── Articles (post → blog_posts) ───────────────');
    $this->line('  Total lus    : ' . $b['total']);
    $this->line('  Créés        : ' . $b['created']);
    $this->line('  Mis à jour   : ' . $b['updated']);
    $this->line('  Ignorés      : ' . $b['skipped']);

    return 0;
})->purpose('Importe les pages et articles WordPress (legacy_pages + blog_posts)');
