<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AdminAvisSettingsController extends Controller
{
    public function edit(): View
    {
        $defaults = HomePageDefaults::all();
        $base = $defaults['avis'] ?? [];
        $row = HomeSection::query()->where('key', 'avis')->first();
        $payload = $row && is_array($row->payload) ? $row->payload : [];
        $merged = $payload ? array_replace_recursive($base, $payload) : $base;

        return view('admin.avis_settings.edit', [
            'avis' => $merged,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'avis' => ['nullable', 'array'],
            'avis.kicker' => ['nullable', 'string', 'max:120'],
            'avis.title_accent' => ['nullable', 'string', 'max:120'],
            'avis.title_rest' => ['nullable', 'string', 'max:190'],
            'avis.intro' => ['nullable', 'string', 'max:800'],
            'avis.google_url' => ['nullable', 'string', 'max:800'],
            'avis.google_button' => ['nullable', 'string', 'max:120'],
            'avis.platform_info' => ['nullable', 'string', 'max:300'],
            'avis.serapi' => ['nullable', 'array'],
            'avis.serapi.api_key' => ['nullable', 'string', 'max:255'],
            'avis.serapi.place_id' => ['nullable', 'string', 'max:255'],
            'avis.serapi.engine' => ['nullable', 'string', 'max:120'],
            'avis.testimonials' => ['nullable', 'array'],
            'avis.testimonials.*.platform' => ['nullable', 'string', 'max:120'],
            'avis.testimonials.*.review_count' => ['nullable', 'string', 'max:120'],
            'avis.testimonials.*.text' => ['nullable', 'string', 'max:1200'],
            'avis.testimonials.*.author' => ['nullable', 'string', 'max:190'],
        ]);

        $avis = is_array($data['avis'] ?? null) ? $data['avis'] : [];
        $avis['testimonials'] = collect((array) ($avis['testimonials'] ?? []))
            ->map(function ($item) {
                if (! is_array($item)) {
                    return null;
                }
                $platform = trim((string) ($item['platform'] ?? ''));
                $reviewCount = trim((string) ($item['review_count'] ?? ''));
                $text = trim((string) ($item['text'] ?? ''));
                $author = trim((string) ($item['author'] ?? ''));
                if ($platform === '' && $text === '' && $author === '') {
                    return null;
                }
                return [
                    'platform' => $platform,
                    'review_count' => $reviewCount,
                    'text' => $text,
                    'author' => $author,
                ];
            })
            ->filter()
            ->values()
            ->all();

        HomeSection::query()->updateOrCreate(
            ['key' => 'avis'],
            ['payload' => $avis]
        );

        return redirect()
            ->route('admin.avis_settings.edit')
            ->with('status', 'Paramètres des avis enregistrés.');
    }

    public function fetchGoogle(Request $request): RedirectResponse
    {
        $request->validate([
            'max_reviews' => ['nullable', 'integer', 'min:1', 'max:200'],
        ]);

        $defaults = HomePageDefaults::all();
        $base = $defaults['avis'] ?? [];
        $row = HomeSection::query()->where('key', 'avis')->first();
        $payload = $row && is_array($row->payload) ? $row->payload : [];
        $avis = $payload ? array_replace_recursive($base, $payload) : $base;

        $apiKey = trim((string) data_get($avis, 'serapi.api_key', ''));
        $placeId = trim((string) data_get($avis, 'serapi.place_id', ''));
        $engine = trim((string) data_get($avis, 'serapi.engine', 'google_maps_reviews'));
        $max = (int) $request->input('max_reviews', 200);
        if ($max <= 0) {
            $max = 200;
        }

        if ($apiKey === '' || $placeId === '') {
            return redirect()
                ->route('admin.avis_settings.edit')
                ->withErrors(['avis' => 'Renseignez serapi.api_key et serapi.place_id avant de télécharger les avis Google.']);
        }

        try {
            $existingTestimonials = collect((array) data_get($avis, 'testimonials', []))
                ->filter(fn ($it) => is_array($it))
                ->values();

            $existingGoogleHashes = $existingTestimonials
                ->filter(fn ($it) => strtolower(trim((string) data_get($it, 'platform', ''))) === 'google')
                ->map(function ($it) {
                    $author = mb_strtolower(trim((string) data_get($it, 'author', '')), 'UTF-8');
                    $text = mb_strtolower(trim((string) data_get($it, 'text', '')), 'UTF-8');
                    return sha1($author.'|'.$text);
                })
                ->filter()
                ->values()
                ->all();
            $existingGoogleHashSet = array_fill_keys($existingGoogleHashes, true);

            $fetchedRaw = [];
            $nextToken = null;
            $safetyPageCount = 0;
            do {
                $params = [
                    'engine' => $engine,
                    'place_id' => $placeId,
                    'api_key' => $apiKey,
                    'hl' => 'fr',
                ];
                if (is_string($nextToken) && $nextToken !== '') {
                    $params['next_page_token'] = $nextToken;
                }

                $response = Http::timeout(25)->get('https://serpapi.com/search.json', $params);
                if (! $response->ok()) {
                    throw new \RuntimeException('Erreur SerAPI HTTP '.$response->status());
                }
                $json = $response->json();

                $rawReviews = data_get($json, 'reviews');
                if (! is_array($rawReviews)) {
                    $rawReviews = data_get($json, 'google_reviews');
                }
                if (! is_array($rawReviews)) {
                    $rawReviews = data_get($json, 'local_results.reviews');
                }
                if (! is_array($rawReviews)) {
                    $rawReviews = [];
                }
                if ($rawReviews !== []) {
                    $fetchedRaw = array_merge($fetchedRaw, $rawReviews);
                }

                $nextToken = data_get($json, 'serpapi_pagination.next_page_token');
                if (! is_string($nextToken) || trim($nextToken) === '') {
                    $nextToken = data_get($json, 'next_page_token');
                }
                if (! is_string($nextToken) || trim($nextToken) === '') {
                    $nextToken = null;
                }

                $safetyPageCount++;
            } while ($nextToken !== null && $safetyPageCount < 10 && count($fetchedRaw) < ($max * 2));

            $mapped = collect($fetchedRaw)
                ->map(function ($r) {
                    if (! is_array($r)) {
                        return null;
                    }
                    $text = trim((string) data_get($r, 'snippet', data_get($r, 'text', data_get($r, 'review_text', ''))));
                    $author = trim((string) data_get($r, 'user.name', data_get($r, 'author', data_get($r, 'user', 'Anonyme'))));
                    $rating = data_get($r, 'rating', data_get($r, 'stars', null));
                    $stars = is_numeric($rating) ? number_format((float) $rating, 1, '.', '').'/5' : '';
                    if ($text === '') {
                        return null;
                    }
                    return [
                        'platform' => 'google',
                        'review_count' => $stars !== '' ? $stars : '+ avis',
                        'text' => $text,
                        'author' => $author !== '' ? $author : 'Anonyme',
                    ];
                })
                ->filter()
                ->values()
                ->all();

            if ($mapped === []) {
                return redirect()
                    ->route('admin.avis_settings.edit')
                    ->withErrors(['avis' => 'Aucun avis Google exploitable trouvé via SerAPI.']);
            }

            $newGoogle = collect($mapped)
                ->map(function ($it) {
                    $author = mb_strtolower(trim((string) data_get($it, 'author', '')), 'UTF-8');
                    $text = mb_strtolower(trim((string) data_get($it, 'text', '')), 'UTF-8');
                    $hash = sha1($author.'|'.$text);
                    return ['hash' => $hash, 'item' => $it];
                })
                ->filter(function ($row) use (&$existingGoogleHashSet) {
                    $hash = (string) ($row['hash'] ?? '');
                    if ($hash === '' || isset($existingGoogleHashSet[$hash])) {
                        return false;
                    }
                    $existingGoogleHashSet[$hash] = true;
                    return true;
                })
                ->map(fn ($row) => $row['item'])
                ->take($max)
                ->values()
                ->all();

            if ($newGoogle === []) {
                return redirect()
                    ->route('admin.avis_settings.edit')
                    ->with('status', 'Aucun nouvel avis Google à importer (déjà synchronisés).');
            }

            $avis['testimonials'] = array_values(array_merge(
                $newGoogle,
                $existingTestimonials->all()
            ));
            $avis['serapi']['last_sync'] = now()->toDateTimeString();

            HomeSection::query()->updateOrCreate(
                ['key' => 'avis'],
                ['payload' => $avis]
            );

            return redirect()
                ->route('admin.avis_settings.edit')
                ->with('status', count($newGoogle).' nouvel(s) avis Google importé(s).');
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.avis_settings.edit')
                ->withErrors(['avis' => 'Téléchargement SerAPI impossible : '.$e->getMessage()]);
        }
    }
}
