<?php

namespace Tests\Feature;

use App\Models\HomeSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFranchiseSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function adminHeaders(): array
    {
        return [];
    }

    public function test_admin_franchise_settings_edit_loads(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\AdminAuth::class);
        $response = $this->get(route('admin.franchise_settings.edit'));
        $response->assertOk();
        $response->assertSee('Page Franchise', false);
    }

    public function test_admin_franchise_settings_update_saves_to_db(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\AdminAuth::class);

        $response = $this->post(route('admin.franchise_settings.update'), [
            'sections' => [
                'franchise_page' => [
                    'meta_title' => 'Franchise Test',
                    'hero_kicker' => 'Mon kicker',
                    'pillars' => [
                        ['icon' => 'shield-check', 'title' => 'Pilier A', 'text' => 'Description A'],
                    ],
                    'faq' => [
                        ['q' => 'Question ?', 'a' => 'Réponse.'],
                    ],
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.franchise_settings.edit'));
        $response->assertSessionHas('status');

        $row = HomeSection::query()->where('key', 'franchise_page')->first();
        $this->assertNotNull($row);
        $this->assertSame('Franchise Test', data_get($row->payload, 'meta_title'));
        $this->assertSame('Mon kicker', data_get($row->payload, 'hero_kicker'));
        $this->assertCount(1, data_get($row->payload, 'pillars'));
        $this->assertCount(1, data_get($row->payload, 'faq'));
    }
}
