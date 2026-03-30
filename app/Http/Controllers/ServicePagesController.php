<?php

namespace App\Http\Controllers;

use App\Models\ServicePage;
use Illuminate\View\View;

class ServicePagesController extends Controller
{
    public function show(string $slug): View
    {
        $page = ServicePage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('services.page', [
            'page' => $page,
        ]);
    }
}

