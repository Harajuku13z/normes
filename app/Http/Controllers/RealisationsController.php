<?php

namespace App\Http\Controllers;

use App\Models\PortfolioProject;
use App\Services\HomePageService;
use Illuminate\View\View;

class RealisationsController extends Controller
{
    public function index(HomePageService $homePage): View
    {
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
}
