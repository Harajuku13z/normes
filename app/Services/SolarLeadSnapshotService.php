<?php

namespace App\Services;

use App\Models\SimulateurLead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SolarLeadSnapshotService
{
    public function storeLeadSnapshot(SimulateurLead $lead, array $payload): ?string
    {
        $zones = collect((array) data_get($payload, 'zones', []))
            ->filter(fn ($zone) => count((array) data_get($zone, 'originalPoints', [])) >= 3)
            ->values()
            ->all();
        $panels = collect((array) data_get($payload, 'panelPolygons', []))
            ->filter(fn ($panel) => count((array) $panel) >= 3)
            ->values()
            ->all();

        if ($zones === [] && $panels === []) {
            return null;
        }

        $allPoints = collect($zones)
            ->flatMap(fn ($zone) => array_merge(
                (array) data_get($zone, 'originalPoints', []),
                (array) data_get($zone, 'insetPoints', []),
                (array) data_get($zone, 'panelPlacementPoints', [])
            ))
            ->merge(collect($panels)->flatten(1))
            ->map(fn ($point) => $this->normalizePoint($point))
            ->filter()
            ->values();

        if ($allPoints->isEmpty()) {
            return null;
        }

        $bounds = $this->computeBounds($allPoints->all());
        $query = $this->buildStaticMapQuery($bounds, $zones, $panels);
        $apiKey = (string) config('services.google.solar_key', '');
        if ($apiKey === '') {
            return null;
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'Referer' => 'https://normesrenovation.fr/',
                    'Origin' => 'https://normesrenovation.fr',
                ])
                ->get('https://maps.googleapis.com/maps/api/staticmap?'.$query.'&key='.rawurlencode($apiKey));

            if (! $response->successful()) {
                return null;
            }

            $path = 'simulateur-captures/lead-'.$lead->id.'-'.now()->format('Ymd-His').'.png';
            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (\Throwable $e) {
            logger()->warning('Solar snapshot generation failed: '.$e->getMessage(), [
                'lead_id' => $lead->id,
            ]);

            return null;
        }
    }

    /**
     * @param  array<int, array{lat: float, lng: float}>  $points
     * @return array{minLat: float, maxLat: float, minLng: float, maxLng: float, centerLat: float, centerLng: float}
     */
    private function computeBounds(array $points): array
    {
        $lats = array_column($points, 'lat');
        $lngs = array_column($points, 'lng');

        return [
            'minLat' => min($lats),
            'maxLat' => max($lats),
            'minLng' => min($lngs),
            'maxLng' => max($lngs),
            'centerLat' => array_sum($lats) / count($lats),
            'centerLng' => array_sum($lngs) / count($lngs),
        ];
    }

    /**
     * @param  array{minLat: float, maxLat: float, minLng: float, maxLng: float, centerLat: float, centerLng: float}  $bounds
     * @param  array<int, array<string, mixed>>  $zones
     * @param  array<int, array<int, array<string, mixed>>>  $panels
     */
    private function buildStaticMapQuery(array $bounds, array $zones, array $panels): string
    {
        $width = 1200;
        $height = 900;
        $zoom = $this->estimateZoom($bounds, $width, $height);

        $parts = [
            'center='.rawurlencode($bounds['centerLat'].','.$bounds['centerLng']),
            'zoom='.$zoom,
            'size='.$width.'x'.$height,
            'scale=2',
            'maptype=satellite',
            'format=png',
            'markers='.rawurlencode('color:red|size:mid|'.$bounds['centerLat'].','.$bounds['centerLng']),
        ];

        foreach ($zones as $zone) {
            $original = $this->normalizePath((array) data_get($zone, 'originalPoints', []));
            $inset = $this->normalizePath((array) data_get($zone, 'insetPoints', []));
            $placement = $this->normalizePath((array) data_get($zone, 'panelPlacementPoints', []));

            if (count($original) >= 3) {
                $parts[] = 'path='.rawurlencode($this->pathString($original, '0xF5C400FF', 5, '0xF5C40022'));
            }
            if (count($inset) >= 3) {
                $parts[] = 'path='.rawurlencode($this->pathString($inset, '0xFF3B30FF', 4, '0xFF3B3012'));
            }
            if (count($placement) >= 3) {
                $parts[] = 'path='.rawurlencode($this->pathString($placement, '0x14A3E8FF', 3, '0x14A3E814'));
            }
        }

        foreach ($panels as $panel) {
            $panelPath = $this->normalizePath((array) $panel);
            if (count($panelPath) >= 3) {
                $parts[] = 'path='.rawurlencode($this->pathString($panelPath, '0x0D2B52FF', 2, '0x1A4F8CCC'));
            }
        }

        return implode('&', $parts);
    }

    /**
     * @param  array{minLat: float, maxLat: float, minLng: float, maxLng: float, centerLat: float, centerLng: float}  $bounds
     */
    private function estimateZoom(array $bounds, int $width, int $height): int
    {
        $latFraction = max(0.00001, abs($bounds['maxLat'] - $bounds['minLat']) / 170);
        $lngFraction = max(0.00001, abs($bounds['maxLng'] - $bounds['minLng']) / 360);

        $latZoom = log($height / 256 / $latFraction, 2);
        $lngZoom = log($width / 256 / $lngFraction, 2);

        return (int) max(17, min(21, floor(min($latZoom, $lngZoom)) - 1));
    }

    /**
     * @param  array<string, mixed>  $point
     * @return array{lat: float, lng: float}|null
     */
    private function normalizePoint(mixed $point): ?array
    {
        if (! is_array($point)) {
            return null;
        }

        $lat = data_get($point, 'lat');
        $lng = data_get($point, 'lng');

        if (! is_numeric($lat) || ! is_numeric($lng)) {
            return null;
        }

        return [
            'lat' => (float) $lat,
            'lng' => (float) $lng,
        ];
    }

    /**
     * @param  array<int, mixed>  $path
     * @return array<int, array{lat: float, lng: float}>
     */
    private function normalizePath(array $path): array
    {
        return collect($path)
            ->map(fn ($point) => $this->normalizePoint($point))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array{lat: float, lng: float}>  $points
     */
    private function pathString(array $points, string $color, int $weight, ?string $fillColor = null): string
    {
        $segments = [
            'color:'.$color,
            'weight:'.$weight,
        ];

        if ($fillColor) {
            $segments[] = 'fillcolor:'.$fillColor;
        }

        foreach ($points as $point) {
            $segments[] = $this->formatCoord($point['lat']).','.$this->formatCoord($point['lng']);
        }

        if (count($points) >= 3) {
            $segments[] = $this->formatCoord($points[0]['lat']).','.$this->formatCoord($points[0]['lng']);
        }

        return implode('|', $segments);
    }

    private function formatCoord(float $value): string
    {
        return number_format($value, 6, '.', '');
    }
}
