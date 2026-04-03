<?php

namespace Tests\Feature;

use App\Mail\FranchiseInquiryMail;
use App\Models\FranchiseInquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FranchisePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_franchise_page_returns_ok(): void
    {
        $response = $this->get('/franchise');

        $response->assertOk();
        $response->assertSee('Devenez franchisé', false);
        $response->assertSee('id="candidature"', false);
        $response->assertSee('Commencer mon dossier', false);
    }

    public function test_franchise_route_name(): void
    {
        $this->assertSame('/franchise', route('franchise.page', [], false));
    }

    public function test_franchise_form_creates_inquiry_and_sends_mail(): void
    {
        Mail::fake();

        $response = $this->post('/franchise', [
            'name' => 'Jean Test',
            'phone' => '0612345678',
            'email' => 'jean@example.com',
            'postal_code' => '71100',
            'has_independent_activity' => '1',
            'geographic_sector' => 'Bretagne',
            'personal_contribution' => '25000',
            'message' => 'Projet d’ouverture sous douze mois.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('franchise_status');

        $this->assertDatabaseHas('franchise_inquiries', [
            'email' => 'jean@example.com',
            'geographic_sector' => 'Bretagne',
        ]);

        $inquiry = FranchiseInquiry::query()->firstOrFail();
        $this->assertTrue($inquiry->has_independent_activity);
        Mail::assertSent(FranchiseInquiryMail::class, fn (FranchiseInquiryMail $mail) => $mail->inquiry->is($inquiry));
    }

    public function test_franchise_form_validation_requires_fields(): void
    {
        Mail::fake();

        $response = $this->post('/franchise', [
            'name' => '',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['name', 'phone', 'email', 'postal_code', 'has_independent_activity', 'geographic_sector']);
        $this->assertDatabaseCount('franchise_inquiries', 0);
        Mail::assertNothingSent();
    }
}
