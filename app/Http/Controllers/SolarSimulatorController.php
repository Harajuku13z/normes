<?php

namespace App\Http\Controllers;

use App\Models\SimulateurLead;
use App\Services\HomePageService;
use App\Services\SolarLeadSnapshotService;
use App\Services\SimulateurMailer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SolarSimulatorController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        $settings = $this->simulatorSettings();

        return view('simulateur.solaire', [
            'home' => $homePage->merged(),
            'googleMapsKey' => config('services.google.maps_browser_key'),
            'pricingSettings' => (array) data_get($settings, 'pricing', []),
        ]);
    }

    public function confirmation(HomePageService $homePage): View
    {
        return view('simulateur.solaire-confirmation', [
            'home' => $homePage->merged(),
        ]);
    }

    public function success(HomePageService $homePage): View
    {
        return view('simulateur.solaire-success', [
            'home' => $homePage->merged(),
        ]);
    }

    public function publicConfig(Request $request): JsonResponse
    {
        return response()->json([
            'googleMapsKey' => (string) config('services.google.maps_browser_key', ''),
            'csrfToken' => csrf_token(),
            'endpoints' => [
                'autocomplete' => route('api.solar.autocomplete'),
                'geocode' => route('api.solar.geocode'),
                'estimate' => route('api.solar.estimate'),
                'lead' => route('api.solar.lead'),
            ],
            'defaults' => [
                'country' => 'fr',
                'language' => 'fr',
                'address' => (string) $request->query('address', ''),
            ],
        ]);
    }

    /** Image satellite (Google Static Maps) proxifiée pour le popup de démo */
    public function demoImage(Request $request): \Illuminate\Http\Response
    {
        $lat  = (float) $request->query('lat', 47.322);
        $lng  = (float) $request->query('lng', 5.042);
        $zoom = (int)   $request->query('zoom', 20);
        $zoom = max(18, min(21, $zoom));

        $apiKey = config('services.google.solar_key');

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->withHeaders([
                    'Referer' => 'https://normesrenovation.fr/',
                    'Origin'  => 'https://normesrenovation.fr',
                ])
                ->get('https://maps.googleapis.com/maps/api/staticmap', [
                    'center'  => "{$lat},{$lng}",
                    'zoom'    => $zoom,
                    'size'    => '720x400',
                    'scale'   => '2',
                    'maptype' => 'satellite',
                    'key'     => $apiKey,
                ]);

            if ($response->successful()) {
                return response($response->body(), 200, [
                    'Content-Type'  => 'image/png',
                    'Cache-Control' => 'public, max-age=3600',
                ]);
            }
        } catch (\Throwable) {}

        // Fallback : image placeholder SVG si Static Maps échoue
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="720" height="400"><rect width="720" height="400" fill="#1a2a35"/><text x="360" y="200" fill="#fff" font-family="Inter,sans-serif" font-size="16" text-anchor="middle">Vue satellite indisponible</text></svg>';

        return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
    }

    /** Nettoie une adresse : espace avant CP collé, trim */
    private function cleanAddress(string $addr): string
    {
        $addr = trim($addr);
        $addr = (string) preg_replace('/([A-Za-zÀ-ÿ\-])(\d{5})/', '$1 $2', $addr);
        return (string) preg_replace('/\s+/', ' ', $addr);
    }

    /**
     * Extrait le code postal 5 chiffres d'une chaîne et retourne
     * [q_sans_cp, postcode].
     */
    private function extractPostcode(string $addr): array
    {
        if (preg_match('/\b(\d{5})\b/', $addr, $m)) {
            $postcode = $m[1];
            // Supprimer le CP et la ville qui suit éventuellement
            $q = trim((string) preg_replace('/\s*,?\s*\d{5}\b[^,]*/', '', $addr));
            $q = trim((string) preg_replace('/\s+/', ' ', $q));
            return [$q, $postcode];
        }
        return [$addr, null];
    }

    /**
     * Requête BAN avec stratégie intelligente :
     * - Si CP détecté → q=numero+rue, postcode=CP (bien meilleur résultat)
     * - Sinon → q=adresse complète
     */
    private function banQuery(string $addr, int $limit = 8, bool $autocomplete = true): array
    {
        [$q, $postcode] = $this->extractPostcode($addr);

        $params = ['q' => $q, 'limit' => $limit, 'autocomplete' => $autocomplete ? 1 : 0];
        if ($postcode) {
            $params['postcode'] = $postcode;
        }

        try {
            $resp = Http::timeout(5)
                ->withHeaders(['User-Agent' => 'NormesRenovation/1.0'])
                ->get('https://api-adresse.data.gouv.fr/search/', $params);

            $features = $resp->json()['features'] ?? [];

            // Si le score est mauvais ET qu'on a un CP, essayer sans correction (requête brute)
            if (empty($features) || (isset($features[0]['properties']['score']) && $features[0]['properties']['score'] < 0.3)) {
                $resp2 = Http::timeout(5)
                    ->withHeaders(['User-Agent' => 'NormesRenovation/1.0'])
                    ->get('https://api-adresse.data.gouv.fr/search/', [
                        'q' => $addr, 'limit' => $limit, 'autocomplete' => $autocomplete ? 1 : 0,
                    ]);
                $features2 = $resp2->json()['features'] ?? [];
                // Garder le meilleur résultat
                $features = array_merge($features, $features2);
                usort($features, fn ($a, $b) => ($b['properties']['score'] ?? 0) <=> ($a['properties']['score'] ?? 0));
                $features = array_slice($features, 0, $limit);
            }

            return $features;
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Géocode via l'API Adresse officielle française (BAN).
     */
    private function banGeocode(string $addr): ?array
    {
        $features = $this->banQuery($addr, 1, false);

        if (empty($features)) {
            return null;
        }

        $f   = $features[0];
        $p   = $f['properties'] ?? [];
        $geo = $f['geometry']['coordinates'] ?? null;

        if (! $geo) {
            return null;
        }

        return [
            'lat'               => (float) $geo[1],
            'lng'               => (float) $geo[0],
            'formatted_address' => $p['label'] ?? $addr,
            'score'             => (float) ($p['score'] ?? 0),
        ];
    }

    /**
     * Autocomplétion BAN en temps réel.
     */
    private function banAutocomplete(string $q): array
    {
        $features = $this->banQuery($q, 8, true);

        return collect($features)
            ->map(function ($f) {
                $p   = $f['properties'] ?? [];
                $geo = $f['geometry']['coordinates'] ?? [0, 0];
                return [
                    'label'    => $p['label']    ?? '',
                    'full'     => $p['label']    ?? '',
                    'lat'      => (float) $geo[1],
                    'lng'      => (float) $geo[0],
                    'score'    => (float) ($p['score'] ?? 0),
                    'type'     => $p['type']     ?? 'housenumber',
                    'city'     => $p['city']     ?? '',
                    'postcode' => $p['postcode'] ?? '',
                ];
            })
            ->unique('label')
            ->values()
            ->all();
    }

    /** Fallback Nominatim si BAN échoue (DOM/TOM, hors France métro) */
    private function nominatimGeocode(string $addr): ?array
    {
        try {
            $resp = Http::timeout(6)
                ->withHeaders(['User-Agent' => 'NormesRenovation/1.0 contact@normesrenovation.fr'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $addr, 'format' => 'json', 'limit' => 1,
                    'countrycodes' => 'fr', 'accept-language' => 'fr',
                ]);
            $r = $resp->json() ?? [];
            if (! empty($r)) {
                return ['lat' => (float) $r[0]['lat'], 'lng' => (float) $r[0]['lon'],
                        'formatted_address' => $r[0]['display_name']];
            }
        } catch (\Throwable) {}
        return null;
    }

    /** Fallback Google Geocoding API côté serveur avec Referer header */
    private function googleGeocode(string $addr): ?array
    {
        $key = config('services.google.solar_key');
        if (! $key) {
            return null;
        }
        try {
            $resp = Http::timeout(8)
                ->withHeaders(['Referer' => 'https://normesrenovation.fr/', 'Origin' => 'https://normesrenovation.fr'])
                ->get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $addr, 'region' => 'fr', 'language' => 'fr', 'key' => $key,
                ]);
            $json = $resp->json();
            if (($json['status'] ?? '') === 'OK' && ! empty($json['results'])) {
                $loc = $json['results'][0]['geometry']['location'];
                return ['lat' => $loc['lat'], 'lng' => $loc['lng'],
                        'formatted_address' => $json['results'][0]['formatted_address']];
            }
        } catch (\Throwable) {}
        return null;
    }

    /**
     * Recherche fuzzy via Photon (Komoot / OpenStreetMap).
     * Gère les fautes de frappe et transpositions de lettres.
     */
    private function photonSearch(string $q, int $limit = 6): array
    {
        try {
            $resp = Http::timeout(5)
                ->withHeaders(['User-Agent' => 'NormesRenovation/1.0'])
                ->get('https://photon.komoot.io/api/', [
                    'q'     => $q,
                    'limit' => $limit,
                    'lang'  => 'fr',
                    'layer' => 'house,street',
                    'bbox'  => '-5.5,41.0,9.6,51.1', // France métropolitaine
                ]);

            return collect($resp->json()['features'] ?? [])
                ->filter(fn ($f) => ($f['properties']['country_code'] ?? '') === 'FR')
                ->map(function ($f) {
                    $p   = $f['properties'] ?? [];
                    $geo = $f['geometry']['coordinates'] ?? [0, 0];
                    $parts = array_filter([
                        $p['housenumber'] ?? '',
                        $p['name']        ?? '',
                        $p['postcode']    ?? '',
                        $p['city']        ?? $p['town'] ?? '',
                    ]);
                    $label = implode(' ', $parts) ?: ($p['name'] ?? '');
                    return [
                        'label' => $label,
                        'full'  => $label,
                        'lat'   => (float) $geo[1],
                        'lng'   => (float) $geo[0],
                        'score' => 0.5, // score neutre pour Photon
                    ];
                })
                ->filter(fn ($i) => $i['label'] !== '')
                ->values()
                ->all();
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Autocomplétion : BAN France (précise) + Photon (fuzzy pour les fautes).
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $data = $request->validate(['q' => ['required', 'string', 'min:2', 'max:200']]);
        $q    = $this->cleanAddress($data['q']);

        // 1. BAN avec stratégie code postal (très précise si orthographe OK)
        $banItems = $this->banAutocomplete($q);

        // 2. Photon en parallèle pour gérer les fautes (fuzzy)
        $photonItems = $this->photonSearch($q, 5);

        // 3. Fusionner : BAN en priorité, Photon complète (ou remplace si BAN vide)
        $all = collect(array_merge($banItems, $photonItems))
            ->unique(fn ($i) => strtolower(preg_replace('/\s+/', '', $i['label'] ?? '')))
            ->sortByDesc('score')
            ->take(8)
            ->values()
            ->all();

        return response()->json($all);
    }

    /**
     * Géocodage : BAN (France officiel) → Nominatim → Google.
     * La BAN est la plus précise pour les adresses françaises.
     */
    public function geocode(Request $request): JsonResponse
    {
        $data = $request->validate(['address' => ['required', 'string', 'max:255']]);
        $addr = $this->cleanAddress($data['address']);

        // 1. BAN officielle France (précise, avec stratégie CP)
        $result = $this->banGeocode($addr);
        if ($result && ($result['score'] ?? 0) >= 0.4) {
            unset($result['score']);
            return response()->json($result);
        }

        // 2. Photon (fuzzy — gère les fautes de frappe)
        $photon = $this->photonSearch($addr, 1);
        if (! empty($photon)) {
            return response()->json($photon[0]);
        }

        // 3. Nominatim (OpenStreetMap)
        $result = $this->nominatimGeocode($addr);
        if ($result) {
            return response()->json($result);
        }

        // 4. Google Geocoding API côté serveur (Referer header)
        $result = $this->googleGeocode($addr);
        if ($result) {
            return response()->json($result);
        }

        logger()->warning("Geocode failed for: {$addr}");
        return response()->json([
            'error' => 'Adresse introuvable. Vérifiez l\'orthographe ou sélectionnez une suggestion dans la liste.',
        ], 422);
    }

    public function estimate(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $apiKey = config('services.google.solar_key');

        // Le Referer header permet à la clé "Websites" de fonctionner côté serveur
        $solarHttp = Http::timeout(15)->withHeaders([
            'Referer' => 'https://normesrenovation.fr/',
            'Origin'  => 'https://normesrenovation.fr',
        ]);

        try {
            $response = $solarHttp->get('https://solar.googleapis.com/v1/buildingInsights:findClosest', [
                'location.latitude'  => $data['lat'],
                'location.longitude' => $data['lng'],
                'requiredQuality'    => 'HIGH',
                'key'                => $apiKey,
            ]);

            if ($response->serverError() || $response->status() === 404) {
                $response = $solarHttp->get('https://solar.googleapis.com/v1/buildingInsights:findClosest', [
                    'location.latitude'  => $data['lat'],
                    'location.longitude' => $data['lng'],
                    'requiredQuality'    => 'MEDIUM',
                    'key'                => $apiKey,
                ]);
            }

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Données solaires non disponibles pour cette adresse. Essayez une adresse voisine.',
                ], 422);
            }

            $solar     = $response->json();
            $potential = $solar['solarPotential'] ?? null;

            if (! $potential) {
                return response()->json([
                    'error' => 'Aucune donnée solaire disponible pour cette adresse.',
                ], 422);
            }

            $configs    = $potential['solarPanelConfigs'] ?? [];
            $bestConfig = ! empty($configs) ? end($configs) : null;

            $maxPanels = (int) ($potential['maxArrayPanelsCount'] ?? 0);
            $maxAreaM2 = (float) ($potential['maxArrayAreaMeters2'] ?? 0);
            $panelCount = $bestConfig ? (int) ($bestConfig['panelsCount'] ?? $maxPanels) : $maxPanels;
            $yearlyKwhDc = $bestConfig ? (float) ($bestConfig['yearlyEnergyDcKwh'] ?? 0) : 0;

            // DC → AC with ~85 % system efficiency
            $yearlyKwh = $yearlyKwhDc * 0.85;

            $panelWatt = 425; // Wc
            $kwc       = ($panelCount * $panelWatt) / 1000;

            if ($yearlyKwh <= 0) {
                $sunshineHours = (float) ($potential['maxSunshineHoursPerYear'] ?? 1180);
                $yearlyKwh     = $kwc * min($sunshineHours, 1400) * 0.85;
            }

            $electricityPrice    = 0.2276; // €/kWh France 2024 avg
            $selfConsumptionRate = 0.35;
            $resalePrice         = 0.1269; // EDF OA tarif S21 (small installation)

            $selfConsumed  = $yearlyKwh * $selfConsumptionRate;
            $injected      = $yearlyKwh * (1 - $selfConsumptionRate);
            $annualSavings = ($selfConsumed * $electricityPrice) + ($injected * $resalePrice);

            $budgetMin = $kwc * 2000;
            $budgetMax = $kwc * 2800;

            $monthlyWeights = [0.045, 0.060, 0.085, 0.100, 0.115, 0.125, 0.130, 0.120, 0.095, 0.070, 0.045, 0.035];
            $monthlyKwh     = array_map(fn ($w) => (int) round($yearlyKwh * $w), $monthlyWeights);

            // Sunshine hours & CO2
            $sunshineHoursPerYear = (float) ($potential['maxSunshineHoursPerYear'] ?? 1180);
            $co2SavingsMwh        = round($yearlyKwh * 0.4 / 1000, 1); // ~0.4 kg CO2/kWh FR

            // Meilleur segment de toiture : celui avec le plus d'ensoleillement
            $roofSegments = collect($potential['roofSegmentStats'] ?? [])
                ->map(fn ($s) => [
                    'pitchDeg'    => round((float) ($s['pitchDeg'] ?? 0)),
                    'azimuthDeg'  => round((float) ($s['azimuthDeg'] ?? 0)),
                    'areaM2'      => round((float) ($s['stats']['areaMeters2'] ?? 0), 1),
                    'sunshineAvg' => round((float) ($s['stats']['sunshineQuantiles'][5] ?? 0)),
                ])
                ->sortByDesc('sunshineAvg') // trier par ensoleillement, pas par surface
                ->values()
                ->take(4)
                ->all();

            // Dimensions des panneaux pour la visualisation sur la carte
            $panelH = (float) ($potential['panelHeightMeters'] ?? 1.65);
            $panelW = (float) ($potential['panelWidthMeters'] ?? 1.0);

            // Positions des panneaux solaires (max 50 pour la visu carte)
            $solarPanels = collect($potential['solarPanels'] ?? [])
                ->take($panelCount) // seulement les panneaux du config optimal
                ->map(fn ($p) => [
                    'lat'         => (float) ($p['center']['latitude'] ?? 0),
                    'lng'         => (float) ($p['center']['longitude'] ?? 0),
                    'orientation' => $p['orientation'] ?? 'LANDSCAPE',
                    'yearlyKwh'   => round((float) ($p['yearlyEnergyDcKwh'] ?? 0) * 0.85, 1),
                ])
                ->filter(fn ($p) => $p['lat'] !== 0.0 && $p['lng'] !== 0.0)
                ->values()
                ->all();

            // Configs pour le slider (panelsCount → yearlyKwh)
            $configSlider = collect($configs)
                ->map(fn ($c) => [
                    'count'      => (int) ($c['panelsCount'] ?? 0),
                    'yearlyKwh'  => (int) round((float) ($c['yearlyEnergyDcKwh'] ?? 0) * 0.85),
                ])
                ->values()
                ->all();

            return response()->json([
                'panelCount'          => $panelCount,
                'maxPanels'           => $maxPanels,
                'areaM2'              => round($maxAreaM2, 1),
                'kwc'                 => round($kwc, 2),
                'yearlyKwh'           => (int) round($yearlyKwh),
                'annualSavings'       => (int) round($annualSavings),
                'budgetMin'           => (int) round($budgetMin, -2),
                'budgetMax'           => (int) round($budgetMax, -2),
                'monthlyKwh'          => $monthlyKwh,
                'roofSegments'        => $roofSegments,
                'sunshineHoursPerYear'=> (int) $sunshineHoursPerYear,
                'co2SavingsMwh'       => $co2SavingsMwh,
                'solarPanels'         => $solarPanels,
                'panelHeightMeters'   => $panelH,
                'panelWidthMeters'    => $panelW,
                'configSlider'        => $configSlider,
            ]);
        } catch (\Throwable $e) {
            logger()->error('SolarEstimate error: ' . $e->getMessage());

            return response()->json(['error' => 'Une erreur est survenue. Veuillez réessayer.'], 500);
        }
    }

    public function storeConfirmation(Request $request, SimulateurMailer $mailer, SolarLeadSnapshotService $snapshotService): RedirectResponse
    {
        try {
            $this->completeLead($this->validateLeadPayload($request), $mailer, $snapshotService);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            logger()->error('SolarLead confirmation failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['form' => 'Impossible d\'envoyer votre demande pour le moment. Merci de réessayer.']);
        }

        return redirect()->route('simulateur.photovoltaique.success');
    }

    public function saveLead(Request $request, SimulateurMailer $mailer, SolarLeadSnapshotService $snapshotService): JsonResponse
    {
        try {
            $lead = $this->completeLead($this->validateLeadPayload($request), $mailer, $snapshotService);
        } catch (\Throwable $e) {
            logger()->error('SolarLead API save failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Impossible d\'envoyer votre demande pour le moment.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateLeadPayload(Request $request): array
    {
        return $request->validate([
            'prenom'         => ['required', 'string', 'max:100'],
            'nom'            => ['required', 'string', 'max:100'],
            'telephone'      => ['required', 'string', 'max:30'],
            'email'          => ['required', 'email', 'max:190'],
            'adresse'        => ['required', 'string', 'max:255'],
            'type_projet'    => ['required', 'string', 'in:autoconsommation,revente,batterie,je-ne-sais-pas'],
            'kwc'            => ['nullable', 'numeric'],
            'budget_min'     => ['nullable', 'numeric'],
            'budget_max'     => ['nullable', 'numeric'],
            'yearly_kwh'     => ['nullable', 'numeric'],
            'panel_count'    => ['nullable', 'integer'],
            'annual_savings' => ['nullable', 'numeric'],
            'surface_m2'     => ['nullable', 'numeric'],
            'orientation'    => ['nullable', 'string', 'max:50'],
            'inclination'    => ['nullable', 'numeric'],
            'consumption_kwh'=> ['nullable', 'numeric'],
            'bill_amount'    => ['nullable', 'numeric'],
            'bill_period'    => ['nullable', 'string', 'in:month,year'],
            'vehicle_count'  => ['nullable', 'integer', 'min:0', 'max:9'],
            'heating_mode'   => ['nullable', 'string', 'max:80'],
            'zone_type'      => ['nullable', 'string', 'in:roof,garden'],
            'wants_battery'  => ['nullable', 'boolean'],
            'wants_charger'  => ['nullable', 'boolean'],
            'consumption_source' => ['nullable', 'string', 'in:kwh,bill'],
            'action_type'        => ['nullable', 'string', 'in:cta,callback'],
            'snapshot_payload' => ['nullable', 'string', 'max:120000'],
        ]);
    }

    private function completeLead(array $data, SimulateurMailer $mailer, SolarLeadSnapshotService $snapshotService): SimulateurLead
    {
        $lead = SimulateurLead::create([
            'nom_prenom'            => trim($data['prenom'] . ' ' . $data['nom']),
            'code_postal'           => $this->extractLeadPostcode((string) $data['adresse']),
            'surface_m2'            => $data['surface_m2'] ?? null,
            'address'               => $data['adresse'],
            'source_page'           => '/simulateur-photovoltaique',
            'telephone'             => $data['telephone'],
            'email'                 => $data['email'],
            'service_slug'          => 'photovoltaique',
            'service_title'         => 'Panneaux Solaires Photovoltaïques',
            'selected_services'     => ['Panneaux solaires'],
            'selected_sub_services' => $this->buildLeadSubServices($data),
            'sub_service'           => $this->projectTypeLabel((string) $data['type_projet']),
            'message'               => $this->buildLeadMessage($data),
            'status'                => 'completed',
            'completed_at'          => now(),
        ]);

        $photos = [];
        $snapshotPayload = $this->decodeSnapshotPayload($data['snapshot_payload'] ?? null);
        if ($snapshotPayload !== null) {
            $snapshotPath = $snapshotService->storeLeadSnapshot($lead, $snapshotPayload);
            if ($snapshotPath !== null) {
                $photos[] = $snapshotPath;
                $lead->forceFill(['photos' => $photos])->save();
            }
        }

        $isCallback = ((string) ($data['action_type'] ?? 'cta')) === 'callback';

        try {
            if ($isCallback) {
                $mailer->sendCallback($lead);
            } else {
                $mailer->sendCompleted($lead);
            }

            $settings = $mailer->settings();
            $updates = [];
            if ((bool) data_get($settings, 'notifications.send_to_admin_on_completed', false)
                && (string) data_get($settings, 'notifications.admin_email', '') !== '') {
                $updates['admin_notified_completed_at'] = now();
            }
            if ((bool) data_get($settings, 'notifications.send_to_client', false)
                && trim((string) $lead->email) !== '') {
                $updates['client_notified_at'] = now();
            }
            if ($updates !== []) {
                $lead->forceFill($updates)->save();
            }
        } catch (\Throwable $e) {
            $lead->forceFill(['mail_error' => $e->getMessage()])->save();
            logger()->error('SolarLead mail failed: ' . $e->getMessage());
        }

        return $lead;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<int, string>
     */
    private function buildLeadSubServices(array $data): array
    {
        return array_values(array_filter([
            'Projet choisi : ' . $this->projectTypeLabel((string) $data['type_projet']),
            isset($data['panel_count']) ? 'Nombre de panneaux prévu : ' . ((int) $data['panel_count']) . ' panneaux' : null,
            isset($data['kwc']) ? 'Puissance estimée : ' . $this->formatLeadNumber((float) $data['kwc']) . ' kWc' : null,
            isset($data['yearly_kwh']) ? 'Production annuelle estimée : ' . $this->formatLeadNumber((float) $data['yearly_kwh'], 0) . ' kWh/an' : null,
            isset($data['annual_savings']) ? 'Économies annuelles estimées : ' . $this->formatLeadNumber((float) $data['annual_savings'], 0) . ' euros / an' : null,
            isset($data['orientation']) ? 'Orientation retenue : ' . (string) $data['orientation'] : null,
            isset($data['inclination']) ? 'Inclinaison retenue : ' . $this->formatLeadNumber((float) $data['inclination'], 0) . '°' : null,
            isset($data['consumption_kwh']) ? 'Consommation annuelle estimée : ' . $this->formatLeadNumber((float) $data['consumption_kwh'], 0) . ' kWh/an' : null,
            isset($data['bill_amount']) ? 'Montant de facture renseigné : ' . $this->formatLeadNumber((float) $data['bill_amount'], 0) . ' euros / ' . ((string) ($data['bill_period'] ?? 'year') === 'month' ? 'mois' : 'an') : null,
            isset($data['vehicle_count']) ? 'Véhicules électriques : ' . ((int) $data['vehicle_count']) : null,
            isset($data['heating_mode']) ? 'Chauffage du logement : ' . (string) $data['heating_mode'] : null,
            isset($data['zone_type']) ? 'Type d’installation : ' . ((string) $data['zone_type'] === 'garden' ? 'au sol / jardin' : 'sur toiture') : null,
            ! empty($data['wants_battery']) ? 'Option demandée : batterie de stockage' : null,
            ! empty($data['wants_charger']) ? 'Option demandée : borne de recharge' : null,
            (isset($data['budget_min']) || isset($data['budget_max']))
                ? 'Budget indicatif : '
                    . $this->formatLeadNumber((float) ($data['budget_min'] ?? 0), 0)
                    . ' à '
                    . $this->formatLeadNumber((float) ($data['budget_max'] ?? 0), 0)
                    . ' euros TTC'
                : null,
        ]));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function buildLeadMessage(array $data): string
    {
        return implode(' | ', array_filter([
            'Projet : ' . $this->projectTypeLabel((string) $data['type_projet']),
            isset($data['panel_count']) ? ((int) $data['panel_count']) . ' panneaux' : null,
            isset($data['kwc']) ? $this->formatLeadNumber((float) $data['kwc']) . ' kWc' : null,
            isset($data['yearly_kwh']) ? $this->formatLeadNumber((float) $data['yearly_kwh'], 0) . ' kWh/an' : null,
            isset($data['annual_savings']) ? $this->formatLeadNumber((float) $data['annual_savings'], 0) . ' €/an d\'économies' : null,
            isset($data['orientation']) ? 'Orientation : ' . (string) $data['orientation'] : null,
            isset($data['inclination']) ? 'Inclinaison : ' . $this->formatLeadNumber((float) $data['inclination'], 0) . '°' : null,
            isset($data['consumption_kwh']) ? 'Conso : ' . $this->formatLeadNumber((float) $data['consumption_kwh'], 0) . ' kWh/an' : null,
            isset($data['vehicle_count']) ? 'VE : ' . ((int) $data['vehicle_count']) : null,
            isset($data['heating_mode']) ? 'Chauffage : ' . (string) $data['heating_mode'] : null,
            isset($data['zone_type']) ? ((string) $data['zone_type'] === 'garden' ? 'Pose jardin' : 'Pose toiture') : null,
            ! empty($data['wants_battery']) ? 'Option batterie' : null,
            ! empty($data['wants_charger']) ? 'Option borne' : null,
            (isset($data['budget_min']) || isset($data['budget_max']))
                ? 'Budget estimé : '
                    . ($this->formatLeadNumber((float) ($data['budget_min'] ?? 0), 0) ?: '0')
                    . ' € à '
                    . ($this->formatLeadNumber((float) ($data['budget_max'] ?? 0), 0) ?: '0')
                    . ' €'
                : null,
            isset($data['surface_m2']) ? $this->formatLeadNumber((float) $data['surface_m2'], 0) . ' m² disponibles' : null,
        ]));
    }

    private function extractLeadPostcode(string $address): ?string
    {
        if (preg_match('/\b(\d{5})\b/', $address, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function projectTypeLabel(string $type): string
    {
        return match ($type) {
            'autoconsommation' => 'Autoconsommation',
            'revente' => 'Revente totale',
            'batterie' => 'Avec batterie',
            default => 'Projet à définir',
        };
    }

    private function formatLeadNumber(float $value, int $decimals = 2): string
    {
        return rtrim(rtrim(number_format($value, $decimals, '.', ''), '0'), '.');
    }

    /**
     * @return array<string, mixed>
     */
    private function simulatorSettings(): array
    {
        try {
            $saved = \App\Models\HomeSection::query()->where('key', 'simulateur_settings')->first();
        } catch (QueryException) {
            $saved = null;
        }
        $payload = is_array($saved?->payload) ? $saved->payload : [];

        return [
            'pricing' => [
                'roof_min_per_kwc' => (float) data_get($payload, 'pricing.roof_min_per_kwc', 2000),
                'roof_max_per_kwc' => (float) data_get($payload, 'pricing.roof_max_per_kwc', 2800),
                'garden_min_per_kwc' => (float) data_get($payload, 'pricing.garden_min_per_kwc', 1800),
                'garden_max_per_kwc' => (float) data_get($payload, 'pricing.garden_max_per_kwc', 2400),
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodeSnapshotPayload(mixed $payload): ?array
    {
        if (! is_string($payload) || trim($payload) === '') {
            return null;
        }

        $decoded = json_decode($payload, true);

        return is_array($decoded) ? $decoded : null;
    }
}
