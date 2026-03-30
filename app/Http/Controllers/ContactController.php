<?php

namespace App\Http\Controllers;

use App\Services\HomePageService;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        return view('contact', [
            'home' => $homePage->merged(),
        ]);
    }
}

