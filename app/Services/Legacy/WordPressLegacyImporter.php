<?php

namespace App\Services\Legacy;

use App\Models\LegacyPage;
use Illuminate\Support\Str;

class WordPressLegacyImporter
{
    /**
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    public function importFromXml(string $xmlPath, bool $updateExisting = true): array
    {
        $content = file_get_contents($xmlPath);
        if ($content === false) {
            throw new \RuntimeException('Impossible de lire le fichier XML : ' . $xmlPath);
        }

        // Extract <item>…</item> blocks with regex (évite les erreurs XMLReader sur entités HTML)
        preg_match_all('/<item>(.*?)<\/item>/s', $content, $matches);
        $items = $matches[1] ?? [];

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $total   = count($items);

        foreach ($items as $item) {
            $type   = $this->extractCdata($item, 'wp:post_type') ?? $this->extractPlain($item, 'wp:post_type');
            $slug   = $this->extractCdata($item, 'wp:post_name') ?? $this->extractPlain($item, 'wp:post_name');
            $status = $this->extractCdata($item, 'wp:status')    ?? $this->extractPlain($item, 'wp:status');

            if (! in_array($type, ['page', 'post'], true) || $status !== 'publish') {
                $skipped++;
                continue;
            }
            if (! $slug || str_contains($slug, '%') || str_starts_with($slug, 'elementor')) {
                $skipped++;
                continue;
            }

            $link = $this->extractPlain($item, 'link') ?? '';
            $normalizedPath = $link !== '' ? $this->normalizePathFromUrl($link) : $slug;
            if ($normalizedPath === null || $this->shouldSkipPath($normalizedPath)) {
                $skipped++;
                continue;
            }

            $rawTitle   = $this->extractPlain($item, 'title') ?? $slug;
            $rawExcerpt = $this->extractCdata($item, 'excerpt:encoded') ?? '';
            $rawContent = $this->extractCdata($item, 'content:encoded') ?? '';

            $safeTitle   = mb_substr($this->decodeHtml($rawTitle), 0, 255);
            $safeExcerpt = mb_substr(trim(strip_tags($this->decodeHtml($rawExcerpt))), 0, 500) ?: null;
            $safeContent = $rawContent !== '' ? $this->cleanHtml($rawContent) : null;

            if ($safeTitle === '') {
                $safeTitle = Str::headline(str_replace('-', ' ', basename($normalizedPath)));
            }

            $existing = LegacyPage::query()->where('old_path', $normalizedPath)->first();

            if ($existing === null) {
                LegacyPage::query()->create([
                    'old_path'     => $normalizedPath,
                    'title'        => $safeTitle,
                    'h1'           => $safeTitle,
                    'excerpt'      => $safeExcerpt,
                    'content_html' => $safeContent,
                    'meta_title'   => $safeTitle,
                    'meta_description' => $safeExcerpt,
                    'is_active'    => true,
                ]);
                $created++;
                continue;
            }

            if (! $updateExisting) {
                $skipped++;
                continue;
            }

            $existing->update([
                'title'        => $safeTitle,
                'h1'           => $existing->h1 ?: $safeTitle,
                'excerpt'      => $safeExcerpt ?: $existing->excerpt,
                'content_html' => $safeContent ?: $existing->content_html,
                'meta_title'   => $safeTitle,
                'meta_description' => $safeExcerpt ?: $existing->meta_description,
            ]);
            $updated++;
        }

        return compact('created', 'updated', 'skipped', 'total');
    }

    private function extractCdata(string $xml, string $tag): ?string
    {
        if (preg_match('#<' . preg_quote($tag, '#') . '><!\[CDATA\[(.*?)\]\]></' . preg_quote($tag, '#') . '>#s', $xml, $m)) {
            return $m[1];
        }

        return null;
    }

    private function extractPlain(string $xml, string $tag): ?string
    {
        if (preg_match('#<' . preg_quote($tag, '#') . '>(.*?)</' . preg_quote($tag, '#') . '>#s', $xml, $m)) {
            return trim($m[1]);
        }

        return null;
    }

    private function decodeHtml(string $s): string
    {
        $s = str_replace(['<![CDATA[', ']]>'], '', $s);

        return html_entity_decode(trim($s), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function normalizePathFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }
        $normalized = LegacyPage::normalizePath($path);

        return $normalized !== '' ? $normalized : null;
    }

    protected function cleanHtml(string $html): string
    {
        $html = preg_replace('/<!--\s*\/?wp:[^\-].*?-->/s', '', $html) ?? $html;
        $html = preg_replace('/\[et_pb[^\]]*\].*?\[\/et_pb[^\]]*\]/si', '', $html) ?? $html;
        $html = preg_replace('/\s*style="[^"]*"/i', '', $html) ?? $html;
        $html = preg_replace('/\s*class="[^"]*wp-block[^"]*"/i', '', $html) ?? $html;
        $html = preg_replace('/(\n\s*){3,}/', "\n\n", $html) ?? $html;

        return trim($html);
    }

    protected function shouldSkipPath(string $path): bool
    {
        if (str_starts_with($path, 'wp-') || in_array($path, ['wp-json', 'xmlrpc.php'], true)) {
            return true;
        }

        return in_array($path, [
            'a-propos', 'contact', 'services', 'blog',
            'franchise', 'realisations', 'simulateur',
        ], true);
    }
}
