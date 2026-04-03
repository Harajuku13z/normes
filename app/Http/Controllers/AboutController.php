<?php

namespace App\Http\Controllers;

use App\Services\HomePageService;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        return view('about', [
            'home' => $homePage->merged(),
        ]);
    }
}
