<?php

namespace App\Http\Controllers;

use App\Models\ServicePage;
use App\Services\HomePageService;
use Illuminate\View\View;

class ServicePagesController extends Controller
{
    public function show(string $slug, HomePageService $homePage): View
    {
        $page = ServicePage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('services.page', [
            'page' => $page,
            'home' => $homePage->merged(),
        ]);
    }
}

