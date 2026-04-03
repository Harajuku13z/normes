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
            'slug' => 'chantier-toiture-test-unique',
            'description' => 'Description du chantier.',
            'sort_order' => 0,
        ]);

        $response = $this->get('/realisations');

        $response->assertOk();
        $response->assertSee('Chantier toiture test unique', false);
        $response->assertSee('Description du chantier.', false);
        $response->assertSee('Voir plus', false);
    }

    public function test_realisation_detail_page_shows_full_content(): void
    {
        $project = PortfolioProject::factory()->create([
            'title' => 'Projet détail SEO',
            'slug' => 'projet-detail-seo',
            'description' => "Ligne une.\nLigne deux.",
            'sort_order' => 0,
        ]);

        $response = $this->get('/realisations/projet-detail-seo');

        $response->assertOk();
        $response->assertSee('Projet détail SEO', false);
        $response->assertSee('Ligne une.', false);
        $response->assertSee(route('realisations.page', [], false), false);
    }

    public function test_unknown_realisation_slug_returns_not_found(): void
    {
        $this->get('/realisations/n-existe-pas-xyz')->assertNotFound();
    }
}
