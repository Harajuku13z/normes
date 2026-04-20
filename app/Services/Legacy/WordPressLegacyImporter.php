<?php

namespace App\Services\Legacy;

use App\Models\BlogPost;
use App\Models\LegacyPage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class WordPressLegacyImporter
{
    // ────────────────────────────────────────────────────────────
    //  PUBLIC API
    // ────────────────────────────────────────────────────────────

    /**
     * Main entry point: imports pages + ads → legacy_pages AND posts → blog_posts.
     *
     * @return array{pages:array{created:int,updated:int,skipped:int,total:int}, posts:array{created:int,updated:int,skipped:int,total:int}}
     */
    public function importAllFromXml(string $xmlPath, bool $updateExisting = true): array
    {
        $items = $this->parseXml($xmlPath);
        $attachMap = $this->buildAttachmentMap($items);

        return [
            'pages' => $this->importPages($items, $attachMap, $updateExisting),
            'posts' => $this->importPosts($items, $attachMap, $updateExisting),
        ];
    }

    /**
     * Legacy compat: only imports pages + ads → legacy_pages.
     *
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    public function importFromXml(string $xmlPath, bool $updateExisting = true): array
    {
        $items = $this->parseXml($xmlPath);
        $attachMap = $this->buildAttachmentMap($items);

        return $this->importPages($items, $attachMap, $updateExisting);
    }

    /**
     * Only imports WordPress posts → blog_posts.
     *
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    public function importBlogPostsFromXml(string $xmlPath, bool $updateExisting = true): array
    {
        $items = $this->parseXml($xmlPath);
        $attachMap = $this->buildAttachmentMap($items);

        return $this->importPosts($items, $attachMap, $updateExisting);
    }

    // ────────────────────────────────────────────────────────────
    //  PAGES + ADS → legacy_pages
    // ────────────────────────────────────────────────────────────

    /**
     * @param  string[]  $items
     * @param  array<int,string>  $attachMap
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    protected function importPages(array $items, array $attachMap, bool $updateExisting): array
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $total   = 0;

        foreach ($items as $item) {
            $type   = $this->extractCdata($item, 'wp:post_type') ?? $this->extractPlain($item, 'wp:post_type');
            $status = $this->extractCdata($item, 'wp:status')    ?? $this->extractPlain($item, 'wp:status');

            // Only handle page + ad post types
            if (! in_array($type, ['page', 'ad'], true) || $status !== 'publish') {
                continue;
            }
            $total++;

            $slug = $this->extractCdata($item, 'wp:post_name') ?? $this->extractPlain($item, 'wp:post_name');
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

            $meta = $this->extractMeta($item);

            $rawTitle   = $this->extractPlain($item, 'title') ?? $slug;
            $rawExcerpt = $this->extractCdata($item, 'excerpt:encoded') ?? '';
            $rawContent = $this->extractCdata($item, 'content:encoded') ?? '';

            // AIOSEO overrides (ignore template tokens like #post_title)
            $aioseoTitle = $this->cleanAioseoToken((string) ($meta['_aioseo_title'] ?? ''));
            $aioseoDesc  = $this->cleanAioseoToken((string) ($meta['_aioseo_description'] ?? ''));

            $safeTitle   = mb_substr($this->decodeHtml($aioseoTitle ?: $rawTitle), 0, 255);
            $safeExcerpt = mb_substr(trim(strip_tags($this->decodeHtml($aioseoDesc ?: $rawExcerpt))), 0, 500) ?: null;
            $safeContent = $rawContent !== '' ? $this->cleanHtml($rawContent) : null;

            if ($safeTitle === '') {
                $safeTitle = Str::headline(str_replace('-', ' ', basename($normalizedPath)));
            }

            // Featured image from thumbnail
            $thumbId  = (int) ($meta['_thumbnail_id'] ?? 0);
            $ogImage  = $thumbId > 0 && isset($attachMap[$thumbId])
                ? $this->normalizeImageUrl($attachMap[$thumbId])
                : null;

            $existing = LegacyPage::query()->where('old_path', $normalizedPath)->first();

            // Never overwrite pages manually edited in admin
            if ($existing !== null && $existing->content_locked) {
                $skipped++;
                continue;
            }

            if ($existing === null) {
                LegacyPage::query()->create([
                    'old_path'         => $normalizedPath,
                    'title'            => $safeTitle,
                    'h1'               => $safeTitle,
                    'excerpt'          => $safeExcerpt,
                    'content_html'     => $safeContent,
                    'meta_title'       => $safeTitle,
                    'meta_description' => $safeExcerpt,
                    'og_image'         => $ogImage,
                    'is_active'        => true,
                ]);
                $created++;
                continue;
            }

            if (! $updateExisting) {
                $skipped++;
                continue;
            }

            $existing->update([
                'title'            => $safeTitle,
                'h1'               => $existing->h1 ?: $safeTitle,
                'excerpt'          => $safeExcerpt ?: $existing->excerpt,
                'content_html'     => $safeContent ?: $existing->content_html,
                'meta_title'       => $safeTitle,
                'meta_description' => $safeExcerpt ?: $existing->meta_description,
                'og_image'         => $ogImage ?: $existing->og_image,
            ]);
            $updated++;
        }

        return compact('created', 'updated', 'skipped', 'total');
    }

    // ────────────────────────────────────────────────────────────
    //  POSTS → blog_posts
    // ────────────────────────────────────────────────────────────

    /**
     * @param  string[]  $items
     * @param  array<int,string>  $attachMap
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    protected function importPosts(array $items, array $attachMap, bool $updateExisting): array
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $total   = 0;

        foreach ($items as $item) {
            $type   = $this->extractCdata($item, 'wp:post_type') ?? $this->extractPlain($item, 'wp:post_type');
            $status = $this->extractCdata($item, 'wp:status')    ?? $this->extractPlain($item, 'wp:status');

            if ($type !== 'post' || $status !== 'publish') {
                continue;
            }
            $total++;

            $slug = $this->extractCdata($item, 'wp:post_name') ?? $this->extractPlain($item, 'wp:post_name');
            if (! $slug || str_contains($slug, '%')) {
                $skipped++;
                continue;
            }
            $slug = Str::slug($slug);

            $rawTitle   = $this->extractPlain($item, 'title') ?? $slug;
            $rawExcerpt = $this->extractCdata($item, 'excerpt:encoded') ?? '';
            $rawContent = $this->extractCdata($item, 'content:encoded') ?? '';
            $rawDate    = $this->extractCdata($item, 'wp:post_date') ?? null;

            $meta = $this->extractMeta($item);

            $aioseoTitle    = $this->cleanAioseoToken((string) ($meta['_aioseo_title'] ?? ''));
            $aioseoDesc     = $this->cleanAioseoToken((string) ($meta['_aioseo_description'] ?? ''));
            $aioseoKeywords = $this->cleanAioseoKeywords((string) ($meta['_aioseo_keywords'] ?? ''));

            $safeTitle   = mb_substr($this->decodeHtml($aioseoTitle ?: $rawTitle), 0, 255);
            $safeExcerpt = mb_substr(trim(strip_tags($this->decodeHtml($aioseoDesc ?: $rawExcerpt))), 0, 500) ?: null;
            $safeContent = $rawContent !== '' ? $this->cleanHtml($rawContent) : null;

            if ($safeTitle === '') {
                $safeTitle = Str::headline(str_replace('-', ' ', $slug));
            }

            $publishedAt = null;
            if ($rawDate && $rawDate !== '0000-00-00 00:00:00') {
                try {
                    $publishedAt = Carbon::parse($rawDate);
                } catch (\Throwable) {
                    $publishedAt = null;
                }
            }

            $thumbId       = (int) ($meta['_thumbnail_id'] ?? 0);
            $featuredImage = $thumbId > 0 && isset($attachMap[$thumbId])
                ? $this->normalizeImageUrl($attachMap[$thumbId])
                : null;

            $existing = BlogPost::query()->where('slug', $slug)->first();

            if ($existing === null) {
                BlogPost::query()->create([
                    'title'            => $safeTitle,
                    'slug'             => $slug,
                    'excerpt'          => $safeExcerpt,
                    'content_html'     => $safeContent,
                    'featured_image'   => $featuredImage,
                    'og_image'         => $featuredImage,
                    'meta_title'       => $safeTitle,
                    'meta_description' => $safeExcerpt,
                    'meta_keywords'    => $aioseoKeywords ?: null,
                    'published_at'     => $publishedAt,
                ]);
                $created++;
                continue;
            }

            if (! $updateExisting) {
                $skipped++;
                continue;
            }

            $existing->update([
                'title'            => $safeTitle,
                'excerpt'          => $safeExcerpt ?: $existing->excerpt,
                'content_html'     => $safeContent ?: $existing->content_html,
                'featured_image'   => $featuredImage ?: $existing->featured_image,
                'og_image'         => $featuredImage ?: $existing->og_image,
                'meta_title'       => $safeTitle,
                'meta_description' => $safeExcerpt ?: $existing->meta_description,
                'meta_keywords'    => $aioseoKeywords ?: $existing->meta_keywords,
                'published_at'     => $publishedAt ?? $existing->published_at,
            ]);
            $updated++;
        }

        return compact('created', 'updated', 'skipped', 'total');
    }

    // ────────────────────────────────────────────────────────────
    //  XML HELPERS
    // ────────────────────────────────────────────────────────────

    /**
     * Load and split XML into raw <item> strings.
     *
     * @return string[]
     */
    protected function parseXml(string $xmlPath): array
    {
        $content = file_get_contents($xmlPath);
        if ($content === false) {
            throw new \RuntimeException('Impossible de lire le fichier XML : ' . $xmlPath);
        }

        preg_match_all('/<item>(.*?)<\/item>/s', $content, $matches);

        return $matches[1] ?? [];
    }

    /**
     * Build a map of attachment post_id → absolute URL for all <item type=attachment>.
     * URLs are normalised to nr.normesrenovation.fr.
     *
     * @param  string[]  $items
     * @return array<int,string>
     */
    protected function buildAttachmentMap(array $items): array
    {
        $map = [];
        foreach ($items as $item) {
            $type = $this->extractCdata($item, 'wp:post_type') ?? $this->extractPlain($item, 'wp:post_type');
            if ($type !== 'attachment') {
                continue;
            }
            if (preg_match('#<wp:post_id>(\d+)</wp:post_id>#s', $item, $m)) {
                $id = (int) $m[1];
                if (preg_match('#<guid[^>]*>(.*?)</guid>#s', $item, $g)) {
                    $url = trim($g[1]);
                    if ($url !== '') {
                        $map[$id] = $this->normalizeImageUrl($url);
                    }
                }
            }
        }

        return $map;
    }

    /**
     * Extract all <wp:postmeta> key→value pairs from an <item> string.
     *
     * @return array<string,string>
     */
    protected function extractMeta(string $item): array
    {
        $meta = [];
        preg_match_all(
            '#<wp:postmeta>\s*<wp:meta_key><!\[CDATA\[(.*?)\]\]></wp:meta_key>\s*<wp:meta_value><!\[CDATA\[(.*?)\]\]></wp:meta_value>\s*</wp:postmeta>#s',
            $item,
            $m
        );
        if (! empty($m[1])) {
            foreach ($m[1] as $i => $key) {
                $meta[(string) $key] = (string) ($m[2][$i] ?? '');
            }
        }

        return $meta;
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

    // ────────────────────────────────────────────────────────────
    //  STRING CLEANERS
    // ────────────────────────────────────────────────────────────

    private function decodeHtml(string $s): string
    {
        $s = str_replace(['<![CDATA[', ']]>'], '', $s);

        return html_entity_decode(trim($s), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Normalise all WP upload URLs to the canonical nr.normesrenovation.fr domain.
     */
    private function normalizeImageUrl(string $url): string
    {
        return (string) preg_replace(
            '#https?://(?:(?:www|nr)\.)?normesrenovation\.fr(/wp-content/uploads/)#i',
            'https://nr.normesrenovation.fr$1',
            $url
        );
    }

    /**
     * Strip AIOSEO template tokens (e.g. "#post_title #separator_sa").
     * Returns empty string if the value looks like a token template.
     */
    private function cleanAioseoToken(string $value): string
    {
        $value = trim(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        // If it contains template variables like #post_title, discard
        if (str_contains($value, '#post_') || str_contains($value, '#separator')) {
            return '';
        }

        return $value;
    }

    /**
     * Convert AIOSEO serialised keywords (a:0:{} / a:2:{i:0;s:3:"seo";...}) to plain string.
     */
    private function cleanAioseoKeywords(string $value): string
    {
        $value = trim($value);
        if ($value === '' || $value === 'a:0:{}') {
            return '';
        }
        // Try PHP unserialize for the serialised array format
        if (str_starts_with($value, 'a:')) {
            $arr = @unserialize($value);
            if (is_array($arr)) {
                return implode(', ', array_filter(array_map('trim', $arr)));
            }
        }

        return $value;
    }

    protected function cleanHtml(string $html): string
    {
        // Remove Gutenberg block markup
        $html = preg_replace('/<!--\s*\/?wp:[^\-].*?-->/s', '', $html) ?? $html;
        // Remove Elementor / Divi / Visual Composer shortcodes
        $html = preg_replace('/\[et_pb[^\]]*\].*?\[\/et_pb[^\]]*\]/si', '', $html) ?? $html;
        $html = preg_replace('/\[vc_[^\]]*\]/si', '', $html) ?? $html;
        $html = preg_replace('/\[\/vc_[^\]]*\]/si', '', $html) ?? $html;
        // Remove inline styles and WP block classes
        $html = preg_replace('/\s*style="[^"]*"/i', '', $html) ?? $html;
        $html = preg_replace('/\s*class="[^"]*wp-block[^"]*"/i', '', $html) ?? $html;

        // Neutralise PHP open/close tags
        $html = str_replace(['<?php', '<?=', '<?', '?>'], ['&lt;?php', '&lt;?=', '&lt;?', '?&gt;'], $html);

        // Rewrite ALL WP upload image URLs → nr.normesrenovation.fr
        $html = (string) preg_replace(
            '#https?://(?:(?:www|nr)\.)?normesrenovation\.fr(/wp-content/uploads/)#i',
            'https://nr.normesrenovation.fr$1',
            $html
        );

        // Collapse excessive blank lines
        $html = preg_replace('/(\n\s*){3,}/', "\n\n", $html) ?? $html;

        return trim($html);
    }

    // ────────────────────────────────────────────────────────────
    //  PATH FILTERS
    // ────────────────────────────────────────────────────────────

    private function normalizePathFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }
        // Skip query-only city pages (?city=...)
        if (parse_url($url, PHP_URL_QUERY) !== null && $path === '/') {
            return null;
        }
        $normalized = LegacyPage::normalizePath($path);

        return $normalized !== '' ? $normalized : null;
    }

    protected function shouldSkipPath(string $path): bool
    {
        if (str_starts_with($path, 'wp-') || in_array($path, ['wp-json', 'xmlrpc.php'], true)) {
            return true;
        }

        // These paths exist as real Laravel routes
        return in_array($path, [
            'a-propos', 'contact', 'services', 'blog',
            'franchise', 'realisations', 'simulateur',
        ], true);
    }
}
