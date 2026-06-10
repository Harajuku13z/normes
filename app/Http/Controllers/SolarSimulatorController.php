<?php

namespace App\Http\Controllers;

use App\Models\SimulateurLead;
use App\Services\HomePageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SolarSimulatorController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        return view('simulateur.solaire', [
            'home' => $homePage->merged(),
            'googleMapsKey' => config('services.google.maps_browser_key'),
        ]);
    }

    public function geocode(Request $request): JsonResponse
    {
        $data = $request->validate([
            'address' => ['required', 'string', 'max:255'],
        ]);

        $apiKey = config('services.google.solar_key');

        try {
            $response = Http::timeout(8)->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address'  => $data['address'],
                'region'   => 'fr',
                'language' => 'fr',
                'key'      => $apiKey,
            ]);

            $json = $response->json();

            if (($json['status'] ?? '') !== 'OK' || empty($json['results'])) {
                return response()->json(['error' => 'Adresse introuvable. Essayez d\'être plus précis.'], 422);
            }

            $result   = $json['results'][0];
            $location = $result['geometry']['location'];

            return response()->json([
                'lat'               => $location['lat'],
                'lng'               => $location['lng'],
                'formatted_address' => $result['formatted_address'],
            ]);
        } catch (\Throwable $e) {
            logger()->error('Geocode error: ' . $e->getMessage());

            return response()->json(['error' => 'Erreur de géocodage. Veuillez réessayer.'], 500);
        }
    }

    public function estimate(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $apiKey = config('services.google.solar_key');

        try {
            $response = Http::timeout(15)->get('https://solar.googleapis.com/v1/buildingInsights:findClosest', [
                'location.latitude'  => $data['lat'],
                'location.longitude' => $data['lng'],
                'requiredQuality'    => 'HIGH',
                'key'                => $apiKey,
            ]);

            if ($response->serverError() || $response->status() === 404) {
                $response = Http::timeout(15)->get('https://solar.googleapis.com/v1/buildingInsights:findClosest', [
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

            // Roof segments for info
            $roofSegments = collect($potential['roofSegmentStats'] ?? [])
                ->map(fn ($s) => [
                    'pitchDeg'         => round((float) ($s['pitchDeg'] ?? 0)),
                    'azimuthDeg'       => round((float) ($s['azimuthDeg'] ?? 0)),
                    'areaM2'           => round((float) ($s['stats']['areaMeters2'] ?? 0), 1),
                    'sunshineHoursAvg' => round((float) ($s['stats']['sunshineQuantiles'][5] ?? 0)),
                ])
                ->sortByDesc('areaM2')
                ->values()
                ->take(3)
                ->all();

            return response()->json([
                'panelCount'   => $panelCount,
                'maxPanels'    => $maxPanels,
                'areaM2'       => round($maxAreaM2, 1),
                'kwc'          => round($kwc, 2),
                'yearlyKwh'    => (int) round($yearlyKwh),
                'annualSavings' => (int) round($annualSavings),
                'budgetMin'    => (int) round($budgetMin, -2),
                'budgetMax'    => (int) round($budgetMax, -2),
                'monthlyKwh'   => $monthlyKwh,
                'roofSegments' => $roofSegments,
            ]);
        } catch (\Throwable $e) {
            logger()->error('SolarEstimate error: ' . $e->getMessage());

            return response()->json(['error' => 'Une erreur est survenue. Veuillez réessayer.'], 500);
        }
    }

    public function saveLead(Request $request): JsonResponse
    {
        $data = $request->validate([
            'prenom'       => ['required', 'string', 'max:100'],
            'nom'          => ['required', 'string', 'max:100'],
            'telephone'    => ['required', 'string', 'max:30'],
            'email'        => ['required', 'email', 'max:190'],
            'adresse'      => ['required', 'string', 'max:255'],
            'type_projet'  => ['required', 'string', 'in:autoconsommation,revente,batterie,je-ne-sais-pas'],
            'kwc'          => ['nullable', 'numeric'],
            'budget_min'   => ['nullable', 'numeric'],
            'budget_max'   => ['nullable', 'numeric'],
            'yearly_kwh'   => ['nullable', 'numeric'],
            'panel_count'  => ['nullable', 'integer'],
            'annual_savings' => ['nullable', 'numeric'],
        ]);

        $nomPrenom = trim($data['prenom'] . ' ' . $data['nom']);
        $message   = sprintf(
            'Simulation solaire — Type: %s | %s kWc | %s kWh/an | Économies: %s €/an | Budget: %s € – %s € | %s panneaux',
            $data['type_projet'],
            $data['kwc'] ?? '?',
            $data['yearly_kwh'] ?? '?',
            $data['annual_savings'] ?? '?',
            $data['budget_min'] ?? '?',
            $data['budget_max'] ?? '?',
            $data['panel_count'] ?? '?'
        );

        try {
            SimulateurLead::create([
                'nom_prenom'    => $nomPrenom,
                'telephone'     => $data['telephone'],
                'email'         => $data['email'],
                'address'       => $data['adresse'],
                'source_page'   => '/simulateur-solaire',
                'service_slug'  => 'photovoltaique',
                'service_title' => 'Panneaux Solaires Photovoltaïques',
                'message'       => $message,
                'status'        => 'completed',
                'completed_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            logger()->error('SolarLead save failed: ' . $e->getMessage());
        }

        try {
            $adminMail = config('mail.from.address', 'contact@normesrenovationbretagne.fr');
            Mail::raw(
                implode("\n", [
                    '🌞 NOUVEAU LEAD SIMULATEUR SOLAIRE',
                    str_repeat('─', 50),
                    "Nom : {$nomPrenom}",
                    "Téléphone : {$data['telephone']}",
                    "Email : {$data['email']}",
                    "Adresse : {$data['adresse']}",
                    "Type de projet : {$data['type_projet']}",
                    '',
                    '📊 RÉSULTATS DE LA SIMULATION',
                    str_repeat('─', 50),
                    "Puissance installée : " . ($data['kwc'] ?? '?') . " kWc",
                    "Production annuelle : " . ($data['yearly_kwh'] ?? '?') . " kWh/an",
                    "Économies annuelles : " . ($data['annual_savings'] ?? '?') . " €/an",
                    "Budget estimé : " . ($data['budget_min'] ?? '?') . " € – " . ($data['budget_max'] ?? '?') . " €",
                    "Nombre de panneaux : " . ($data['panel_count'] ?? '?') . " panneaux",
                    '',
                    'Généré via normesrenovation.fr/simulateur-solaire',
                ]),
                fn ($msg) => $msg
                    ->to($adminMail)
                    ->subject('🌞 Lead solaire — ' . $nomPrenom . ' — ' . ($data['kwc'] ?? '?') . ' kWc')
            );
        } catch (\Throwable $e) {
            logger()->error('SolarLead mail failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }
}
