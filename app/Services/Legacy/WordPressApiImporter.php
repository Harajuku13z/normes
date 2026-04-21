<?php

namespace App\Services\Legacy;

use App\Models\BlogPost;
use App\Models\LegacyPage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Imports WordPress content (pages, ads, blog posts) via the live WP REST API.
 *
 * Source: https://nr.normesrenovation.fr/wp-json/wp/v2/
 *
 * No XML file required — works directly from the admin panel or CLI.
 */
class WordPressApiImporter
{
    private const BASE_URL = 'https://nr.normesrenovation.fr/wp-json/wp/v2';
    private const PER_PAGE = 100;
    private const TIMEOUT  = 30; // seconds per HTTP request

    // ────────────────────────────────────────────────────────────
    //  PUBLIC API
    // ────────────────────────────────────────────────────────────

    /**
     * Import everything:
     *  - WP pages + ads  → legacy_pages
     *  - WP posts        → blog_posts
     *
     * @return array{pages:array{created:int,updated:int,skipped:int,total:int}, posts:array{created:int,updated:int,skipped:int,total:int}}
     */
    public function importAll(bool $updateExisting = true): array
    {
        return [
            'pages' => $this->importLegacyPages($updateExisting),
            'posts' => $this->importBlogPosts($updateExisting),
        ];
    }

    /**
     * Import WP pages + WP ads → legacy_pages.
     *
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    public function importLegacyPages(bool $updateExisting = true): array
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $total   = 0;

        foreach (['pages', 'ad'] as $endpoint) {
            $items = $this->fetchAll($endpoint);
            foreach ($items as $item) {
                $result = $this->processLegacyItem($item, $updateExisting);
                $total++;
                match ($result) {
                    'created' => $created++,
                    'updated' => $updated++,
                    default   => $skipped++,
                };
            }
        }

        return compact('created', 'updated', 'skipped', 'total');
    }

    /**
     * Import WP posts → blog_posts.
     *
     * @return array{created:int,updated:int,skipped:int,total:int}
     */
    public function importBlogPosts(bool $updateExisting = true): array
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $total   = 0;

        $items = $this->fetchAll('posts');
        foreach ($items as $item) {
            $result = $this->processBlogPost($item, $updateExisting);
            $total++;
            match ($result) {
                'created' => $created++,
                'updated' => $updated++,
                default   => $skipped++,
            };
        }

        return compact('created', 'updated', 'skipped', 'total');
    }

    // ────────────────────────────────────────────────────────────
    //  ITEM PROCESSORS
    // ────────────────────────────────────────────────────────────

    private function processLegacyItem(array $item, bool $updateExisting): string
    {
        $slug = $item['slug'] ?? '';
        $link = $item['link'] ?? '';

        $normalizedPath = $link !== '' ? $this->normalizePathFromUrl($link) : LegacyPage::normalizePath($slug);

        if (! $normalizedPath || $this->shouldSkipPath($normalizedPath)) {
            return 'skipped';
        }

        $title   = $this->decodeRendered($item['title']['rendered'] ?? $slug);
        $content = $this->cleanHtml($item['content']['rendered'] ?? '');
        $excerpt = $this->stripToText($item['excerpt']['rendered'] ?? '');
        $ogImage = $this->extractFeaturedImage($item);

        $safeTitle   = mb_substr($title, 0, 255) ?: Str::headline(str_replace('-', ' ', basename($normalizedPath)));
        $safeExcerpt = mb_substr($excerpt, 0, 500) ?: null;
        $safeContent = ($content !== '') ? $content : null;

        $existing = LegacyPage::query()->where('old_path', $normalizedPath)->first();

        // Never overwrite pages manually edited in admin
        if ($existing !== null && $existing->content_locked) {
            return 'skipped';
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

            return 'created';
        }

        if (! $updateExisting) {
            return 'skipped';
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

        return 'updated';
    }

    private function processBlogPost(array $item, bool $updateExisting): string
    {
        $slug = Str::slug($item['slug'] ?? '');
        if (! $slug) {
            return 'skipped';
        }

        $title   = $this->decodeRendered($item['title']['rendered'] ?? $slug);
        $content = $this->cleanHtml($item['content']['rendered'] ?? '');
        $excerpt = $this->stripToText($item['excerpt']['rendered'] ?? '');
        $ogImage = $this->extractFeaturedImage($item);
        $date    = $item['date'] ?? null;

        $safeTitle   = mb_substr($title, 0, 255) ?: Str::headline(str_replace('-', ' ', $slug));
        $safeExcerpt = mb_substr($excerpt, 0, 500) ?: null;
        $safeContent = ($content !== '') ? $content : null;

        $publishedAt = null;
        if ($date) {
            try {
                $publishedAt = Carbon::parse($date);
            } catch (\Throwable) {
                $publishedAt = null;
            }
        }

        $existing = BlogPost::query()->where('slug', $slug)->first();

        if ($existing === null) {
            BlogPost::query()->create([
                'title'            => $safeTitle,
                'slug'             => $slug,
                'excerpt'          => $safeExcerpt,
                'content_html'     => $safeContent,
                'featured_image'   => $ogImage,
                'og_image'         => $ogImage,
                'meta_title'       => $safeTitle,
                'meta_description' => $safeExcerpt,
                'published_at'     => $publishedAt,
            ]);

            return 'created';
        }

        if (! $updateExisting) {
            return 'skipped';
        }

        $existing->update([
            'title'            => $safeTitle,
            'excerpt'          => $safeExcerpt ?: $existing->excerpt,
            'content_html'     => $safeContent ?: $existing->content_html,
            'featured_image'   => $ogImage ?: $existing->featured_image,
            'og_image'         => $ogImage ?: $existing->og_image,
            'meta_title'       => $safeTitle,
            'meta_description' => $safeExcerpt ?: $existing->meta_description,
            'published_at'     => $publishedAt ?? $existing->published_at,
        ]);

        return 'updated';
    }

    // ────────────────────────────────────────────────────────────
    //  HTTP FETCHER
    // ────────────────────────────────────────────────────────────

    /**
     * Fetch ALL items from a paginated WP REST API endpoint.
     *
     * Includes featured media embedding so images are available without a
     * second request.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchAll(string $endpoint): array
    {
        $all  = [];
        $page = 1;

        do {
            $response = Http::timeout(self::TIMEOUT)
                ->get(self::BASE_URL . '/' . $endpoint, [
                    'per_page' => self::PER_PAGE,
                    'page'     => $page,
                    'status'   => 'publish',
                    '_embed'   => 'wp:featuredmedia',
                ]);

            if (! $response->successful()) {
                // 400 on page > totalPages is normal — just stop
                break;
            }

            $items = $response->json();
            if (! is_array($items) || empty($items)) {
                break;
            }

            $all        = array_merge($all, $items);
            $totalPages = (int) ($response->header('X-WP-TotalPages') ?? 1);
            $page++;
        } while ($page <= $totalPages);

        return $all;
    }

    // ────────────────────────────────────────────────────────────
    //  HELPERS
    // ────────────────────────────────────────────────────────────

    private function extractFeaturedImage(array $item): ?string
    {
        $media = $item['_embedded']['wp:featuredmedia'][0] ?? null;
        if (is_array($media) && isset($media['source_url'])) {
            return (string) $media['source_url'];
        }

        return null;
    }

    /**
     * Decode an HTML-rendered WP field (e.g. title.rendered) to plain text.
     */
    private function decodeRendered(string $html): string
    {
        return html_entity_decode(trim(strip_tags($html)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Strip HTML tags and decode entities → plain text (for excerpt / meta_description).
     */
    private function stripToText(string $html): string
    {
        return trim(strip_tags(html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    /**
     * Light HTML cleanup for content_html — removes WP-specific markup but
     * keeps the rendered HTML intact (the REST API already renders Gutenberg blocks).
     */
    private function cleanHtml(string $html): string
    {
        if ($html === '') {
            return '';
        }

        // Remove residual Gutenberg block comments (REST API usually strips these already)
        $html = preg_replace('/<!--\s*\/?wp:[^\-]*?-->/s', '', $html) ?? $html;

        // Remove WP block class attributes (cosmetic, prevents style leakage)
        $html = preg_replace('/\s*class="[^"]*wp-block[^"]*"/i', '', $html) ?? $html;

        // Neutralise any PHP tags that could slip through
        $html = str_replace(['<?php', '<?=', '<?', '?>'], ['&lt;?php', '&lt;?=', '&lt;?', '?&gt;'], $html);

        // Collapse excessive blank lines
        $html = preg_replace('/(\n\s*){3,}/', "\n\n", $html) ?? $html;

        return trim($html);
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

    private function shouldSkipPath(string $path): bool
    {
        if (str_starts_with($path, 'wp-') || in_array($path, ['wp-json', 'xmlrpc.php'], true)) {
            return true;
        }

        // These paths are handled by dedicated Laravel routes
        return in_array($path, [
            'a-propos', 'contact', 'services', 'blog',
            'franchise', 'realisations', 'simulateur',
        ], true);
    }
}
