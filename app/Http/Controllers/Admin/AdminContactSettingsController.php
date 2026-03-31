<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactSettingsController extends Controller
{
    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $keys = ['devis', 'footer'];

        $saved = HomeSection::query()
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');

        $merged = [];
        foreach ($keys as $key) {
            $base = $defaults[$key] ?? [];
            $row = $saved->get($key);
            $payload = $row && is_array($row->payload) ? $row->payload : [];
            $merged[$key] = $payload
                ? array_replace_recursive($base, $payload)
                : $base;
        }

        return view('admin.contact_settings.edit', [
            'merged' => $merged,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $sections = $request->input('sections', []);
        if (! is_array($sections)) {
            $sections = [];
        }

        foreach (['devis', 'footer'] as $key) {
            if (! array_key_exists($key, $sections) || ! is_array($sections[$key])) {
                continue;
            }

            HomeSection::query()->updateOrCreate(
                ['key' => $key],
                ['payload' => $sections[$key]]
            );
        }

        return redirect()
            ->route('admin.contact_settings.edit')
            ->with('status', 'Paramètres de la page contact enregistrés.');
    }
}
