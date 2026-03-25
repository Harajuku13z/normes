<?php

namespace App\Services;

use App\Models\HomeSection;
use App\Support\HomePageDefaults;

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
        }

        foreach ($overrides as $key => $payload) {
            if (! array_key_exists($key, $out) && is_array($payload)) {
                $out[$key] = $payload;
            }
        }

        return $this->withDerived($out);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function withDerived(array $data): array
    {
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
