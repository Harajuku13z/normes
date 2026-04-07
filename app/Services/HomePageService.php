<?php

namespace App\Services;

use App\Models\HomeSection;
use App\Models\ServicePage;
use App\Support\HomePageDefaults;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;

class HomePageService
{
    public function merged(): array
    {
        $defaults = HomePageDefaults::all();
        $overrides = HomeSection::query()->pluck('payload', 'key')->all();

        $out = [];
        foreach ($defaults as $key => $default) {
            $override = $overrides[$key] ?? null;
            $out[$key] = is_array($override)
                ? array_replace_recursive($default, $override)
                : $default;

            // For menu collections, we must replace defaults entirely instead of
            // index-based recursive merge, otherwise deleted default entries remain.
            if ($key === 'header' && is_array($override) && array_key_exists('menu_items', $override) && is_array($override['menu_items'])) {
                $out[$key]['menu_items'] = $override['menu_items'];
            }
        }

        foreach ($overrides as $key => $payload) {
            if (! array_key_exists($key, $out) && is_array($payload)) {
                $out[$key] = $payload;
            }
        }

        return $this->withDerived($this->ensureBlogInHeaderMenu($this->ensureFranchiseInHeaderMenu($out)));
    }

    /**
     * If the header menu was saved in DB before the franchise route existed, menu_items
     * replace defaults entirely and "Franchise" is missing. Inject it once if absent.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function ensureFranchiseInHeaderMenu(array $data): array
    {
        if (! Route::has('franchise.page')) {
            return $data;
        }

        $items = data_get($data, 'header.menu_items');
        if (! is_array($items)) {
            return $data;
        }

        $hasFranchise = collect($items)->contains(function ($item) {
            return is_array($item) && trim((string) data_get($item, 'route', '')) === 'franchise.page';
        });

        if ($hasFranchise) {
            return $data;
        }

        $franchiseItem = [
            'label' => 'Franchise',
            'route' => 'franchise.page',
            'anchor' => '',
            'custom_url' => '',
            'style' => '',
        ];

        $newItems = [];
        $inserted = false;
        foreach ($items as $item) {
            $newItems[] = $item;
            if (is_array($item) && trim((string) data_get($item, 'route', '')) === 'realisations.page') {
                $newItems[] = $franchiseItem;
                $inserted = true;
            }
        }

        if (! $inserted) {
            $newItems[] = $franchiseItem;
        }

        data_set($data, 'header.menu_items', $newItems);

        return $data;
    }

    /**
     * If the header menu was saved in DB, menu_items replace defaults entirely.
     * Inject "Blog" once if absent.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function ensureBlogInHeaderMenu(array $data): array
    {
        if (! Route::has('blog.index')) {
            return $data;
        }

        $items = data_get($data, 'header.menu_items');
        if (! is_array($items)) {
            return $data;
        }

        $hasBlog = collect($items)->contains(function ($item) {
            return is_array($item) && trim((string) data_get($item, 'route', '')) === 'blog.index';
        });

        if ($hasBlog) {
            return $data;
        }

        $blogItem = [
            'label' => 'Blog',
            'route' => 'blog.index',
            'anchor' => '',
            'custom_url' => '',
            'style' => '',
        ];

        // Insert near "Conseils" if present, else append.
        $newItems = [];
        $inserted = false;
        foreach ($items as $item) {
            if (! $inserted && is_array($item) && trim((string) data_get($item, 'route', '')) === 'home' && trim((string) data_get($item, 'anchor', '')) === 'conseils') {
                $newItems[] = $blogItem;
                $inserted = true;
            }
            $newItems[] = $item;
        }
        if (! $inserted) {
            $newItems[] = $blogItem;
        }

        data_set($data, 'header.menu_items', $newItems);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function withDerived(array $data): array
    {
        $activeServicePages = [];
        try {
            $activeServicePages = ServicePage::query()
                ->where('is_active', true)
                ->orderBy('service_num')
                ->orderBy('id')
                ->get(['service_num', 'slug', 'title', 'intro', 'meta_title', 'meta_description', 'featured_image', 'image', 'cta_text'])
                ->all();
        } catch (QueryException) {
            $activeServicePages = [];
        }

        $serviceOptions = [];
        $serviceOptions = collect($activeServicePages)
            ->map(fn ($page) => trim((string) data_get($page, 'title', '')))
            ->filter(fn ($title) => $title !== '')
            ->unique()
            ->values()
            ->all();
        if ($serviceOptions === []) {
            $serviceOptions = collect((array) data_get($data, 'services.items', []))
                ->map(fn ($item) => trim((string) data_get($item, 'title', '')))
                ->filter(fn ($title) => $title !== '')
                ->unique()
                ->values()
                ->all();
        }
        data_set($data, 'service_options', $serviceOptions);

        $fallbackItems = collect((array) data_get($data, 'services.items', []))
            ->filter(fn ($item) => is_array($item))
            ->values();

        $serviceCards = collect($activeServicePages)
            ->map(function ($page) use ($fallbackItems): array {
                $pageData = is_array($page) ? $page : (method_exists($page, 'toArray') ? $page->toArray() : []);
                $serviceNum = (int) data_get($pageData, 'service_num', 0);
                $fallback = $fallbackItems->first(fn ($item) => (int) data_get($item, 'num', 0) === $serviceNum);

                $title = trim((string) data_get($pageData, 'title', ''));
                $displayTitle = trim((string) data_get($pageData, 'meta_title', ''));
                if ($displayTitle === '') {
                    $displayTitle = $title;
                }
                $description = trim((string) data_get($pageData, 'meta_description', ''));
                if ($description === '') {
                    $description = trim((string) data_get($pageData, 'intro', ''));
                }
                if ($description === '') {
                    $description = trim((string) data_get($fallback, 'description', ''));
                }

                $image = trim((string) data_get($pageData, 'featured_image', ''));
                if ($image === '') {
                    $image = trim((string) data_get($pageData, 'image', ''));
                }
                if ($image === '') {
                    $image = trim((string) data_get($fallback, 'image', ''));
                }

                $slug = trim((string) data_get($pageData, 'slug', ''));
                $href = $slug !== '' ? route('service.page', $slug, false) : '#devis';

                return [
                    'num' => $serviceNum,
                    'title' => $displayTitle,
                    'description' => $description,
                    'image' => $image,
                    'href' => $href,
                    'cta' => trim((string) data_get($pageData, 'cta_text', '')) ?: 'En savoir plus',
                ];
            })
            ->filter(fn ($item) => trim((string) data_get($item, 'title', '')) !== '')
            ->values()
            ->all();

        if ($serviceCards === []) {
            $serviceCards = $fallbackItems
                ->map(function ($item): array {
                    return [
                        'num' => (int) data_get($item, 'num', 0),
                        'title' => trim((string) data_get($item, 'title', '')),
                        'description' => trim((string) data_get($item, 'description', '')),
                        'image' => trim((string) data_get($item, 'image', '')),
                        'href' => '#devis',
                        'cta' => trim((string) data_get($item, 'cta', '')) ?: 'En savoir plus',
                    ];
                })
                ->filter(fn ($item) => trim((string) data_get($item, 'title', '')) !== '')
                ->values()
                ->all();
        }
        data_set($data, 'services.cards', $serviceCards);

        $slides = data_get($data, 'hero.slides');
        if (is_array($slides) && $slides !== []) {
            $slidesJs = [];
            foreach (array_values($slides) as $i => $slide) {
                if (! is_array($slide)) {
                    continue;
                }
                $n = $i + 1;
                $img = (string) ($slide['image'] ?? '');
                $url = $this->publicUrl($img);
                $slidesJs[$n] = [
                    'bg' => "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('{$url}')",
                    'title' => (string) ($slide['title'] ?? ''),
                    'subtitle' => (string) ($slide['subtitle'] ?? ''),
                    'primaryText' => (string) ($slide['primary_text'] ?? ''),
                    'primaryHref' => (string) ($slide['primary_href'] ?? '#devis'),
                    'secondaryText' => (string) ($slide['secondary_text'] ?? ''),
                    'secondaryHref' => (string) ($slide['secondary_href'] ?? '#devis'),
                ];
            }
            data_set($data, 'hero.slides_js', $slidesJs);
        }

        $cases = data_get($data, 'realisations.cases');
        if (is_array($cases) && $cases !== []) {
            $casesJs = [];
            foreach (array_values($cases) as $i => $case) {
                if (! is_array($case)) {
                    continue;
                }
                $n = $i + 1;
                $b = (string) ($case['before'] ?? '');
                $a = (string) ($case['after'] ?? '');
                $casesJs[$n] = [
                    'before' => "url('".$this->publicUrl($b)."')",
                    'after' => "url('".$this->publicUrl($a)."')",
                ];
            }
            data_set($data, 'realisations.cases_js', $casesJs);
        }

        return $data;
    }

    protected function publicUrl(string $path): string
    {
        $path = trim($path);

        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : asset(ltrim($path, '/'));
    }
}
