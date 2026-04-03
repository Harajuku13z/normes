<?php

namespace Tests\Feature;

use App\Models\HomeSection;
use App\Services\HomePageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageServiceFranchiseMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_injects_franchise_after_realisations_when_saved_header_omits_it(): void
    {
        HomeSection::query()->create([
            'key' => 'header',
            'payload' => [
                'menu_items' => [
                    ['label' => 'Accueil', 'route' => 'home', 'anchor' => '', 'custom_url' => '', 'style' => ''],
                    ['label' => 'Réalisations', 'route' => 'realisations.page', 'anchor' => '', 'custom_url' => '', 'style' => ''],
                    ['label' => 'Contact', 'route' => 'contact.page', 'anchor' => '', 'custom_url' => '', 'style' => ''],
                ],
            ],
        ]);

        $data = app(HomePageService::class)->merged();

        $routes = collect(data_get($data, 'header.menu_items', []))
            ->map(fn ($item) => is_array($item) ? trim((string) ($item['route'] ?? '')) : '')
            ->values()
            ->all();

        $this->assertContains('franchise.page', $routes);
        $idxReal = array_search('realisations.page', $routes, true);
        $idxFranchise = array_search('franchise.page', $routes, true);
        $this->assertNotFalse($idxReal);
        $this->assertNotFalse($idxFranchise);
        $this->assertGreaterThan($idxReal, $idxFranchise);
    }

    public function test_does_not_duplicate_franchise_when_already_present(): void
    {
        HomeSection::query()->create([
            'key' => 'header',
            'payload' => [
                'menu_items' => [
                    ['label' => 'Franchise', 'route' => 'franchise.page', 'anchor' => '', 'custom_url' => '', 'style' => ''],
                ],
            ],
        ]);

        $data = app(HomePageService::class)->merged();
        $count = collect(data_get($data, 'header.menu_items', []))
            ->filter(fn ($item) => is_array($item) && trim((string) ($item['route'] ?? '')) === 'franchise.page')
            ->count();

        $this->assertSame(1, $count);
    }
}
