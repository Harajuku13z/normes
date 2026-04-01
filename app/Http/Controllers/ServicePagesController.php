<?php

namespace App\Http\Controllers;

use App\Models\ServicePage;
use App\Services\HomePageService;
use Illuminate\View\View;

class ServicePagesController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        $home = $homePage->merged();

        $pages = ServicePage::query()
            ->where('is_active', true)
            ->orderBy('service_num')
            ->orderBy('id')
            ->get();

        return view('services.index', [
            'home' => $home,
            'pages' => $pages,
        ]);
    }

    public function show(string $slug, HomePageService $homePage): View
    {
        $page = ServicePage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $home = $homePage->merged();

        return view('services.page', [
            'page' => $page,
            'home' => $home,
        ]);
    }
}

