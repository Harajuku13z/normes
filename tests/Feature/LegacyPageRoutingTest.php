<?php

namespace Tests\Feature;

use App\Models\LegacyPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacyPageRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_serves_legacy_page_on_exact_old_path_without_redirect(): void
    {
        LegacyPage::query()->create([
            'old_path' => 'couvreur-autun',
            'title' => 'Couvreur Autun',
            'h1' => 'Couvreur Autun',
            'content_html' => '<p>Contenu legacy.</p>',
            'is_active' => true,
        ]);

        $response = $this->get('/couvreur-autun');

        $response->assertOk();
        $response->assertSee('Couvreur Autun');
        $response->assertSee('Contenu legacy.', false);
    }

    public function test_returns_404_when_legacy_page_is_missing(): void
    {
        $this->get('/ancienne-page-inexistante')->assertNotFound();
    }
}

