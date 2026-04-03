<?php

namespace App\Http\Controllers;

use App\Http\Requests\FranchiseInquiryRequest;
use App\Mail\FranchiseInquiryMail;
use App\Models\FranchiseInquiry;
use App\Services\HomePageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class FranchiseController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        return view('franchise', [
            'home' => $homePage->merged(),
        ]);
    }

    public function store(FranchiseInquiryRequest $request, HomePageService $homePage): RedirectResponse
    {
        $payload = $request->inquiryPayload();
        $payload['ip_address'] = $request->ip();

        $inquiry = FranchiseInquiry::query()->create($payload);

        $to = (string) config('services.franchise_notify_email', '');
        if (trim($to) === '') {
            $to = trim((string) data_get($homePage->merged(), 'footer.email', ''));
        }
        if ($to === '') {
            $to = (string) config('mail.from.address', '');
        }

        if ($to !== '') {
            try {
                Mail::to($to)->send(new FranchiseInquiryMail($inquiry));
            } catch (\Throwable $e) {
                \Log::error('Franchise inquiry mail failed', [
                    'exception' => $e->getMessage(),
                    'inquiry_id' => $inquiry->id,
                ]);
            }
        }

        return redirect()
            ->to(route('franchise.page', [], false).'#candidature')
            ->with('franchise_status', 'Merci ! Votre dossier a bien été transmis. Un expert Normes Rénovation vous recontacte sous peu.');
    }
}
