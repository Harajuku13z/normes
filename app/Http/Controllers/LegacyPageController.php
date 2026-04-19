<?php

namespace App\Http\Controllers;

use App\Models\LegacyPage;
use App\Services\HomePageService;
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

        $home = app(HomePageService::class)->merged();

        $page = LegacyPage::query()
            ->active()
            ->where('old_path', $normalized)
            ->first();

        if ($page !== null) {
            return view('legacy.show', [
                'home' => $home,
                'page' => $page,
                'requestedPath' => $normalized,
            ]);
        }

        // Unknown legacy URL: serve the conversion landing page at this URL (200)
        return view('legacy.landing', [
            'home' => $home,
            'requestedPath' => $normalized,
        ]);
    }
}

