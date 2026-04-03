<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_returns_ok_with_title(): void
    {
        $response = $this->get('/a-propos');

        $response->assertOk();
        $response->assertSee('CONSTRUISEZ AVEC NOUS', false);
        $response->assertSee('<h1', false);
        $response->assertSee('VOS AVIS', false);
        $response->assertSee('Mentions légales', false);
        $response->assertSee('Fabienne Commeau', false);
        $response->assertSee('900 571 696', false);
    }

    public function test_canonical_about_route_registered(): void
    {
        $this->assertSame('/a-propos', route('about.page', [], false));
    }
}
