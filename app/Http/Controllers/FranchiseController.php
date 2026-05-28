<?php

namespace App\Http\Controllers;

use App\Http\Requests\FranchiseInquiryRequest;
use App\Models\FranchiseInquiry;
use App\Services\HomePageService;
use App\Services\SimulateurMailer;
use App\Support\FormSpamGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewResponse;

class FranchiseController extends Controller
{
    public function __construct(private readonly SimulateurMailer $mailer) {}

    public function index(HomePageService $homePage): ViewResponse
    {
        return view('franchise', [
            'home' => $homePage->merged(),
        ]);
    }

    public function store(FranchiseInquiryRequest $request, HomePageService $homePage): RedirectResponse
    {
        app(FormSpamGuard::class)->ensureValid($request, 'franchise', [
            'name',
            'phone',
            'email',
            'postal_code',
            'geographic_sector',
            'personal_contribution',
            'message',
        ]);

        $payload = $request->inquiryPayload();
        $payload['ip_address'] = $request->ip();

        $inquiry = FranchiseInquiry::query()->create($payload);

        // Determine recipient: settings DB → footer email → from address
        $settings  = $this->mailer->settings();
        $adminEmail = (string) data_get($settings, 'notifications.admin_email', '');
        if ($adminEmail === '') {
            $adminEmail = trim((string) data_get($homePage->merged(), 'footer.email', ''));
        }
        if ($adminEmail === '') {
            $adminEmail = (string) config('mail.from.address', '');
        }

        if ($adminEmail !== '') {
            try {
                $html = View::make('emails.franchise-inquiry-html', ['inquiry' => $inquiry])->render();
                $this->mailer->sendRaw(
                    $settings,
                    $adminEmail,
                    'Nouvelle candidature franchise — ' . ($inquiry->name ?? 'inconnu'),
                    $html
                );
            } catch (\Throwable $e) {
                \Log::error('Franchise inquiry mail failed', [
                    'exception'  => $e->getMessage(),
                    'inquiry_id' => $inquiry->id,
                ]);
            }
        }

        return redirect()->route('franchise.success');
    }

    public function success(HomePageService $homePage): ViewResponse
    {
        return view('franchise.success', [
            'home' => $homePage->merged(),
        ]);
    }
}
