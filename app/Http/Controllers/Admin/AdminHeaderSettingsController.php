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
            ['value' => 'services.index', 'label' => 'Services (/services)'],
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
            'menuItems' => $this->normalizeMenuItems((array) data_get($header, 'menu_items', [])),
            'routeOptions' => $this->menuRouteOptions(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $header = $request->input('header', []);
        if (! is_array($header)) {
            $header = [];
        }

        $menuItems = $this->normalizeMenuItems((array) data_get($header, 'menu_items', []));

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

    /**
     * @param  array<int|string, mixed>  $items
     * @return array<int, array<string, mixed>>
     */
    private function normalizeMenuItems(array $items): array
    {
        return collect($items)
            ->filter(fn ($item) => is_array($item))
            ->map(function (array $item): array {
                $normalized = [
                    'label' => trim((string) data_get($item, 'label', '')),
                    'route' => trim((string) data_get($item, 'route', '')),
                    'anchor' => ltrim(trim((string) data_get($item, 'anchor', '')), '#'),
                    'custom_url' => trim((string) data_get($item, 'custom_url', '')),
                    'style' => trim((string) data_get($item, 'style', '')),
                ];

                $children = data_get($item, 'children', []);
                if (is_array($children)) {
                    $normalized['children'] = collect($children)
                        ->filter(fn ($child) => is_array($child))
                        ->map(function (array $child): array {
                            return [
                                'label' => trim((string) data_get($child, 'label', '')),
                                'route' => trim((string) data_get($child, 'route', '')),
                                'anchor' => ltrim(trim((string) data_get($child, 'anchor', '')), '#'),
                                'custom_url' => trim((string) data_get($child, 'custom_url', '')),
                            ];
                        })
                        ->filter(fn (array $child) => $child['label'] !== '' && ($child['route'] !== '' || $child['custom_url'] !== ''))
                        ->values()
                        ->all();
                } else {
                    $normalized['children'] = [];
                }

                return $normalized;
            })
            ->filter(fn (array $item) => $item['label'] !== '' && ($item['route'] !== '' || $item['custom_url'] !== ''))
            ->values()
            ->all();
    }
}

