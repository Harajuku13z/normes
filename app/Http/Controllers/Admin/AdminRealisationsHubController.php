<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use Illuminate\View\View;

class AdminRealisationsHubController extends Controller
{
    public function index(): View
    {
        return view('admin.realisations.index', [
            'projectCount' => PortfolioProject::query()->count(),
        ]);
    }
}
