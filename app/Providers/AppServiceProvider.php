<?php

namespace App\Providers;

use App\Services\HomePageService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('welcome', function ($view) {
            $data = $view->getData();
            if (! array_key_exists('home', $data) || $data['home'] === null) {
                $view->with('home', app(HomePageService::class)->merged());
            }
        });
    }
}
