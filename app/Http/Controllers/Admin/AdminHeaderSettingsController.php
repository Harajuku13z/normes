<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminHeaderSettingsController extends Controller
{
    /**
     * @return array<int, array{value:string,label:string}>
     */
    private function menuRouteOptions(): array
    {
        return [
            ['value' => 'home', 'label' => 'Accueil (/)'],
            ['value' => 'contact.page', 'label' => 'Contact (/contact)'],
            ['value' => 'simulateur.start', 'label' => 'Simulateur (/simulateur)'],
        ];
    }

    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $base = is_array($defaults['header'] ?? null) ? $defaults['header'] : [];
        $saved = HomeSection::query()->where('key', 'header')->first();
        $payload = is_array($saved?->payload) ? $saved->payload : [];
        $header = $payload ? array_replace_recursive($base, $payload) : $base;

        return view('admin.header_settings.edit', [
            'header' => $header,
            'routeOptions' => $this->menuRouteOptions(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $header = $request->input('header', []);
        if (! is_array($header)) {
            $header = [];
        }

        $menuItems = data_get($header, 'menu_items', []);
        if (! is_array($menuItems)) {
            $menuItems = [];
        }

        $menuItems = collect($menuItems)
            ->filter(fn ($item) => is_array($item))
            ->map(function (array $item): array {
                return [
                    'label' => trim((string) data_get($item, 'label', '')),
                    'route' => trim((string) data_get($item, 'route', '')),
                    'anchor' => ltrim(trim((string) data_get($item, 'anchor', '')), '#'),
                    'custom_url' => trim((string) data_get($item, 'custom_url', '')),
                    'style' => trim((string) data_get($item, 'style', '')),
                ];
            })
            ->filter(fn (array $item) => $item['label'] !== '' && ($item['route'] !== '' || $item['custom_url'] !== ''))
            ->values()
            ->all();

        data_set($header, 'logo', trim((string) data_get($header, 'logo', '')));
        data_set($header, 'logo_alt', trim((string) data_get($header, 'logo_alt', '')));
        data_set($header, 'menu_items', $menuItems);

        HomeSection::query()->updateOrCreate(
            ['key' => 'header'],
            ['payload' => $header]
        );

        return redirect()
            ->route('admin.header_settings.edit')
            ->with('status', 'Header enregistré.');
    }
}

