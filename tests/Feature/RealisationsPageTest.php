<?php

namespace Tests\Feature;

use App\Models\PortfolioProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RealisationsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_realisations_page_returns_ok_with_defaults(): void
    {
        $response = $this->get('/realisations');

        $response->assertOk();
        $response->assertSee('Nos réalisations', false);
        $response->assertSee('<h1', false);
        $response->assertSee('id="projets"', false);
        $response->assertSee('id="devis"', false);
    }

    public function test_realisations_route_name(): void
    {
        $this->assertSame('/realisations', route('realisations.page', [], false));
    }

    public function test_displays_portfolio_project_from_database(): void
    {
        PortfolioProject::factory()->create([
            'title' => 'Chantier toiture test unique',
            'description' => 'Description du chantier.',
            'sort_order' => 0,
        ]);

        $response = $this->get('/realisations');

        $response->assertOk();
        $response->assertSee('Chantier toiture test unique', false);
        $response->assertSee('Description du chantier.', false);
    }
}
