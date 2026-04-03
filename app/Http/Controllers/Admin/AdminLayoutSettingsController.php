<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLayoutSettingsController extends Controller
{
    /**
     * @return array<int, array{value:string,label:string}>
     */
    private function menuRouteOptions(): array
    {
        return [
            ['value' => 'home', 'label' => 'Accueil (/)'],
            ['value' => 'services.index', 'label' => 'Services (/services)'],
            ['value' => 'about.page', 'label' => 'À propos (/a-propos)'],
            ['value' => 'realisations.page', 'label' => 'Réalisations (/realisations)'],
            ['value' => 'contact.page', 'label' => 'Contact (/contact)'],
            ['value' => 'simulateur.start', 'label' => 'Simulateur (/simulateur)'],
        ];
    }

    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $keys = ['header', 'footer'];

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

        return view('admin.layout_settings.edit', [
            'merged' => $merged,
            'routeOptions' => $this->menuRouteOptions(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $sections = $request->input('sections', []);
        if (! is_array($sections)) {
            $sections = [];
        }

        foreach (['header', 'footer'] as $key) {
            if (! array_key_exists($key, $sections) || ! is_array($sections[$key])) {
                continue;
            }
            if ($key === 'header') {
                $menuItems = data_get($sections[$key], 'menu_items', []);
                if (! is_array($menuItems)) {
                    $menuItems = [];
                }
                $menuItems = collect($menuItems)
                    ->filter(fn ($item) => is_array($item))
                    ->map(function (array $item): array {
                        $normalized = [
                            'label' => trim((string) data_get($item, 'label', '')),
                            'route' => trim((string) data_get($item, 'route', '')),
                            'anchor' => ltrim(trim((string) data_get($item, 'anchor', '')), '#'),
                            'custom_url' => trim((string) data_get($item, 'custom_url', '')),
                            'style' => trim((string) data_get($item, 'style', '')),
                        ];
                        if (in_array($normalized['route'], ['services.index', 'realisations.page'], true)) {
                            $normalized['anchor'] = '';
                        }

                        return $normalized;
                    })
                    ->filter(fn (array $item) => $item['label'] !== '' && ($item['route'] !== '' || $item['custom_url'] !== ''))
                    ->values()
                    ->all();
                data_set($sections[$key], 'menu_items', $menuItems);
            }

            HomeSection::query()->updateOrCreate(
                ['key' => $key],
                ['payload' => $sections[$key]]
            );
        }

        return redirect()
            ->route('admin.layout_settings.edit')
            ->with('status', 'Header & Footer enregistrés.');
    }
}
