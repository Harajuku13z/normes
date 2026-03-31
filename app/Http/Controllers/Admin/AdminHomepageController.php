<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminHomepageController extends Controller
{
    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $excludedKeys = ['header', 'footer', 'avis', 'contact_page'];
        $keys = array_values(array_filter(array_keys($defaults), fn ($key) => ! in_array($key, $excludedKeys, true)));

        $saved = HomeSection::query()
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');

        $merged = [];
        foreach ($keys as $key) {
            $row = $saved->get($key);
            $base = $defaults[$key];
            $payload = $row && is_array($row->payload) ? $row->payload : [];

            $merged[$key] = $payload
                ? array_replace_recursive($base, $payload)
                : $base;
        }

        return view('admin.homepage.index', [
            'merged' => $merged,
            'labels' => HomePageDefaults::labels(),
            'keys' => $keys,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $defaults = HomePageDefaults::all();
        $excludedKeys = ['header', 'footer', 'avis', 'contact_page'];
        $keys = array_values(array_filter(array_keys($defaults), fn ($key) => ! in_array($key, $excludedKeys, true)));

        $sections = $request->input('sections', []);
        if (! is_array($sections)) {
            $sections = [];
        }

        foreach ($keys as $key) {
            if (! array_key_exists($key, $sections)) {
                continue;
            }

            $value = $sections[$key];
            if (! is_array($value)) {
                // Si jamais on reçoit une valeur scalaire, on l’encapsule.
                $value = ['value' => $value];
            }

            HomeSection::query()->updateOrCreate(
                ['key' => $key],
                ['payload' => $value]
            );
        }

        return redirect()
            ->route('admin.homepage.edit')
            ->with('status', 'Homepage enregistrée.');
    }
}

