<?php

namespace App\Services\Legacy;

use App\Models\LegacyPage;
use Illuminate\Support\Str;
use XMLReader;

class WordPressLegacyImporter
{
    /**
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    public function importFromXml(string $xmlPath, bool $updateExisting = true): array
    {
        $reader = new XMLReader();
        if (! $reader->open($xmlPath)) {
            throw new \RuntimeException('Impossible d’ouvrir le fichier XML: '.$xmlPath);
        }

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $total = 0;

        while ($reader->read()) {
            if ($reader->nodeType !== XMLReader::ELEMENT || $reader->name !== 'item') {
                continue;
            }

            $total++;
            $xml = $reader->readOuterXML();
            if (! is_string($xml) || trim($xml) === '') {
                $skipped++;
                continue;
            }

            $item = @simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($item === false) {
                $skipped++;
                continue;
            }

            $link = trim((string) ($item->link ?? ''));
            $title = trim((string) ($item->title ?? ''));
            $content = trim((string) ($item->children('content', true)->encoded ?? ''));
            $excerpt = trim((string) ($item->children('excerpt', true)->encoded ?? ''));

            $normalizedPath = $this->normalizePathFromUrl($link);
            if ($normalizedPath === null || $this->shouldSkipPath($normalizedPath)) {
                $skipped++;
                continue;
            }

            $safeTitle = $title !== '' ? html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8') : Str::headline(str_replace('-', ' ', basename($normalizedPath)));
            $safeExcerpt = $excerpt !== '' ? html_entity_decode(strip_tags($excerpt), ENT_QUOTES | ENT_HTML5, 'UTF-8') : null;
            $safeContent = $content !== '' ? $content : '<p>Contenu en cours de migration.</p>';

            $existing = LegacyPage::query()->where('old_path', $normalizedPath)->first();
            if ($existing === null) {
                LegacyPage::query()->create([
                    'old_path' => $normalizedPath,
                    'title' => $safeTitle,
                    'h1' => $safeTitle,
                    'excerpt' => $safeExcerpt,
                    'content_html' => $safeContent,
                    'meta_title' => $safeTitle,
                    'meta_description' => $safeExcerpt,
                    'is_active' => true,
                ]);
                $created++;
                continue;
            }

            if (! $updateExisting) {
                $skipped++;
                continue;
            }

            $existing->update([
                'title' => $safeTitle,
                'h1' => $existing->h1 ?: $safeTitle,
                'excerpt' => $safeExcerpt ?: $existing->excerpt,
                'content_html' => $safeContent ?: $existing->content_html,
                'meta_title' => $safeTitle,
                'meta_description' => $safeExcerpt ?: $existing->meta_description,
            ]);
            $updated++;
        }

        $reader->close();

        return [
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
            'total' => $total,
        ];
    }

    protected function normalizePathFromUrl(string $url): ?string
    {
        if ($url === '') {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }

        $normalized = LegacyPage::normalizePath($path);

        return $normalized !== '' ? $normalized : null;
    }

    protected function shouldSkipPath(string $path): bool
    {
        if (in_array($path, ['wp-json', 'xmlrpc.php'], true)) {
            return true;
        }

        if (str_starts_with($path, 'wp-')) {
            return true;
        }

        return in_array($path, [
            'a-propos',
            'contact',
            'services',
            'blog',
            'franchise',
            'realisations',
            'simulateur',
        ], true);
    }
}

