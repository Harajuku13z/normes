<?php

namespace App\Http\Controllers;

use App\Models\PortfolioProject;
use App\Services\HomePageService;
use Illuminate\View\View;

class RealisationsController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        PortfolioProject::ensureMissingSlugsPersisted();

        $projects = PortfolioProject::query()
            ->with(['images'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('realisations', [
            'home' => $homePage->merged(),
            'projects' => $projects,
        ]);
    }

    public function show(HomePageService $homePage, PortfolioProject $portfolio_project): View
    {
        $portfolio_project->load(['images']);

        return view('realisations.show', [
            'home' => $homePage->merged(),
            'project' => $portfolio_project,
        ]);
    }
}
