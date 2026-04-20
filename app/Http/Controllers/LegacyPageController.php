<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\LegacyPage;
use App\Services\HomePageService;
use App\Services\Legacy\LegacyUrlContext;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegacyPageController extends Controller
{
    public function showByPath(Request $request, string $path): View
    {
        // Safety: strip accidental 'public/' prefix added by the Apache
        // .htaccess redirect chain on shared hosting (trailing-slash redirect
        // from public/.htaccess fires after internal rewrite to public/).
        $path = (string) preg_replace('#^public/#i', '', $path);

        $normalized = LegacyPage::normalizePath($path);
        if ($normalized === '' || str_starts_with($normalized, 'admin/')) {
            abort(404);
        }

        $home    = app(HomePageService::class)->merged();
        $context = LegacyUrlContext::fromPath($normalized);

        // ── 1. Lookup in legacy_pages ────────────────────────────────────
        $page = LegacyPage::query()
            ->active()
            ->where('old_path', $normalized)
            ->first();

        if ($page !== null) {
            if (filled($page->meta_title)) {
                $context['metaTitle'] = $page->meta_title;
            }
            if (filled($page->meta_description)) {
                $context['metaDescription'] = $page->meta_description;
            }
            if (! filled($context['serviceLabel']) && filled($page->title)) {
                $context['h1'] = filled($page->h1) ? $page->h1 : $page->title;
            }

            return view('legacy.show', [
                'home'          => $home,
                'page'          => $page,
                'context'       => $context,
                'requestedPath' => $normalized,
            ]);
        }

        // ── 2. Fallback: WordPress post type → blog_posts ────────────────
        // Blog posts were imported to blog_posts (not legacy_pages) so their
        // original WP URL  (e.g. /mon-article) must still work at 200 OK.
        $blogPost = BlogPost::query()
            ->published()
            ->where('slug', $normalized)
            ->first();

        if ($blogPost !== null) {
            // Synthesise a LegacyPage-like object so legacy.show works as-is
            $fakePage = new LegacyPage([
                'old_path'         => $normalized,
                'title'            => $blogPost->title,
                'h1'               => $blogPost->title,
                'excerpt'          => $blogPost->excerpt,
                'content_html'     => $blogPost->content_html,
                'meta_title'       => $blogPost->meta_title ?: $blogPost->title,
                'meta_description' => $blogPost->meta_description ?: $blogPost->excerpt,
                'canonical_url'    => $blogPost->canonical_url,
                'og_image'         => $blogPost->og_image ?: $blogPost->featured_image,
                'is_active'        => true,
            ]);

            $context['metaTitle']       = $fakePage->meta_title;
            $context['metaDescription'] = $fakePage->meta_description;
            $context['h1']              = $fakePage->h1;

            return view('legacy.show', [
                'home'          => $home,
                'page'          => $fakePage,
                'context'       => $context,
                'requestedPath' => $normalized,
            ]);
        }

        // ── 3. Generic conversion landing (no content found) ────────────
        return view('legacy.landing', [
            'home'          => $home,
            'context'       => $context,
            'requestedPath' => $normalized,
        ]);
    }
}
