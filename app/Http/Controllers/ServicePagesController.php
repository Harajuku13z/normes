<?php

namespace App\Http\Controllers;

use App\Models\ServicePage;
use App\Services\HomePageService;
use App\Support\HomeView;
use Illuminate\View\View;

class ServicePagesController extends Controller
{
    public function show(string $slug, HomePageService $homePage): View
    {
        $page = ServicePage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $home = $homePage->merged();

        // Injecte les "cases avant/après" du service dans home.scripts,
        // pour réutiliser la logique d’interaction existante (baRange / ba-case-btn).
        $cases = $page->realisations ?? [];
        if (is_array($cases) && $cases !== []) {
            $normalized = collect($cases)
                ->filter(fn ($c) => is_array($c) && !empty($c['before']) && !empty($c['after']))
                ->values()
                ->all();

            $casesJs = [];
            foreach (array_values($normalized) as $i => $case) {
                $n = $i + 1;
                $before = (string) ($case['before'] ?? '');
                $after = (string) ($case['after'] ?? '');
                $casesJs[$n] = [
                    'before' => "url('".HomeView::url($before)."')",
                    'after' => "url('".HomeView::url($after)."')",
                ];
            }

            data_set($home, 'realisations.cases_js', $casesJs);
        }

        return view('services.page', [
            'page' => $page,
            'home' => $home,
        ]);
    }
}

