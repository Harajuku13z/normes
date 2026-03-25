<?php

namespace App\Http\Controllers;

use App\Services\HomePageService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        return view('welcome', [
            'home' => $homePage->merged(),
        ]);
    }
}
