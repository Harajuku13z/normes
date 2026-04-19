<?php

namespace App\Http\Controllers;

use App\Models\LegacyPage;
use App\Services\HomePageService;
use App\Services\Legacy\LegacyUrlContext;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegacyPageController extends Controller
{
    public function showByPath(Request $request, string $path): View
    {
        $normalized = LegacyPage::normalizePath($path);
        if ($normalized === '' || str_starts_with($normalized, 'admin/')) {
            abort(404);
        }

        $home    = app(HomePageService::class)->merged();
        $context = LegacyUrlContext::fromPath($normalized);

        $page = LegacyPage::query()
            ->active()
            ->where('old_path', $normalized)
            ->first();

        if ($page !== null) {
            // DB SEO fields override auto-generated context
            if (filled($page->meta_title)) {
                $context['metaTitle'] = $page->meta_title;
            }
            if (filled($page->meta_description)) {
                $context['metaDescription'] = $page->meta_description;
            }
            // Use page title/h1 if context didn't detect a service
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

        return view('legacy.landing', [
            'home'          => $home,
            'context'       => $context,
            'requestedPath' => $normalized,
        ]);
    }
}
