<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRealisationsPageController extends Controller
{
    public function edit(): View
    {
        $key = 'realisations_page';
        $defaults = HomePageDefaults::all();
        abort_unless(isset($defaults[$key]) && is_array($defaults[$key]), 404);

        $base = $defaults[$key];
        $row = HomeSection::query()->where('key', $key)->first();
        $payload = $row && is_array($row->payload) ? $row->payload : [];
        $merged = $payload !== [] ? array_replace_recursive($base, $payload) : $base;

        return view('admin.realisations.page_settings', [
            'merged' => $merged,
            'label' => HomePageDefaults::label($key),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $key = 'realisations_page';
        $defaults = HomePageDefaults::all();
        abort_unless(isset($defaults[$key]), 404);

        $sections = $request->input('sections', []);
        if (! is_array($sections) || ! isset($sections[$key]) || ! is_array($sections[$key])) {
            return redirect()
                ->route('admin.realisations.page.edit')
                ->withErrors(['sections' => 'Données de formulaire invalides.']);
        }

        HomeSection::query()->updateOrCreate(
            ['key' => $key],
            ['payload' => $sections[$key]]
        );

        return redirect()
            ->route('admin.realisations.page.edit')
            ->with('status', 'Page Réalisations (contenu) enregistrée.');
    }
}
