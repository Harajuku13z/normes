<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminFranchiseSettingsController extends Controller
{
    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $base = $defaults['franchise_page'] ?? [];
        $row = HomeSection::query()->where('key', 'franchise_page')->first();
        $payload = $row && is_array($row->payload) ? $row->payload : [];
        $merged = $payload ? array_replace_recursive($base, $payload) : $base;

        return view('admin.franchise_settings.edit', [
            'fp' => $merged,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $sections = $request->input('sections', []);
        $data = is_array($sections['franchise_page'] ?? null) ? $sections['franchise_page'] : [];

        $data['pillars'] = $this->cleanArray(data_get($data, 'pillars', []), ['icon', 'title', 'text']);
        $data['stats'] = $this->cleanArray(data_get($data, 'stats', []), ['value', 'label', 'text']);
        $data['network_items'] = $this->cleanArray(data_get($data, 'network_items', []), ['title', 'text']);
        $data['steps'] = $this->cleanArray(data_get($data, 'steps', []), ['title', 'text']);
        $data['faq'] = $this->cleanArray(data_get($data, 'faq', []), ['q', 'a']);

        HomeSection::query()->updateOrCreate(
            ['key' => 'franchise_page'],
            ['payload' => $data]
        );

        return redirect()
            ->route('admin.franchise_settings.edit')
            ->with('status', 'Page franchise enregistrée.');
    }

    /**
     * @param  mixed  $items
     * @param  string[]  $fields
     * @return array<int, array<string, string>>
     */
    private function cleanArray(mixed $items, array $fields): array
    {
        if (! is_array($items)) {
            return [];
        }

        return collect($items)
            ->filter(fn ($item) => is_array($item))
            ->map(function (array $item) use ($fields): array {
                $row = [];
                foreach ($fields as $field) {
                    $row[$field] = trim((string) ($item[$field] ?? ''));
                }

                return $row;
            })
            ->filter(function (array $row): bool {
                return collect($row)->contains(fn ($v) => $v !== '');
            })
            ->values()
            ->all();
    }
}
