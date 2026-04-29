<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Services\ContactMailer;
use App\Services\HomePageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\View\View as ViewResponse;

class ContactController extends Controller
{
    public function index(HomePageService $homePage): View
    {
        return view('contact', [
            'home' => $homePage->merged(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom_complet'  => ['nullable', 'string', 'max:150'],
            'email'        => ['nullable', 'email', 'max:150'],
            'telephone'    => ['nullable', 'string', 'max:30'],
            'code_postal'  => ['nullable', 'string', 'max:10'],
            'service'      => ['nullable', 'string', 'max:150'],
            'message'      => ['nullable', 'string', 'max:5000'],
            'autres_infos' => ['nullable', 'string', 'max:3000'],
            'photos.*'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,heic,pdf,doc,docx', 'max:10240'],
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if (! $file->isValid()) {
                    continue;
                }

                $ext = strtolower($file->getClientOriginalExtension());

                // Convert HEIC/HEIF → JPEG so browsers can display them
                if (in_array($ext, ['heic', 'heif'], true) && extension_loaded('imagick')) {
                    try {
                        $imagick = new \Imagick();
                        $imagick->readImageBlob($file->get());
                        $imagick->setImageFormat('jpeg');
                        $imagick->setImageCompressionQuality(88);

                        $filename  = 'contact-uploads/' . \Illuminate\Support\Str::random(40) . '.jpg';
                        $fullPath  = storage_path('app/public/' . $filename);
                        $imagick->writeImage($fullPath);
                        $imagick->clear();
                        $photoPaths[] = $filename;
                        continue;
                    } catch (\Throwable) {
                        // Fall through to normal store if conversion fails
                    }
                }

                $photoPaths[] = $file->store('contact-uploads', 'public');
            }
        }

        $inquiry = ContactInquiry::query()->create([
            'nom_complet'  => $validated['nom_complet'] ?? null,
            'email'        => $validated['email'] ?? null,
            'telephone'    => $validated['telephone'] ?? null,
            'code_postal'  => $validated['code_postal'] ?? null,
            'service'      => $validated['service'] ?? null,
            'message'      => $validated['message'] ?? null,
            'autres_infos' => $validated['autres_infos'] ?? null,
            'photos'       => $photoPaths ?: null,
            'ip_address'   => $request->ip(),
        ]);

        $mailer = app(ContactMailer::class);

        try {
            $mailer->sendAdminNotification($inquiry);
            $inquiry->update(['admin_mail_sent' => true]);
        } catch (\Throwable $e) {
            logger()->error('Contact admin mail failed: ' . $e->getMessage());
        }

        try {
            $mailer->sendClientConfirmation($inquiry);
            $inquiry->update(['client_mail_sent' => true]);
        } catch (\Throwable $e) {
            logger()->error('Contact client mail failed: ' . $e->getMessage());
        }

        return redirect()->route('contact.success');
    }

    public function success(HomePageService $homePage): ViewResponse
    {
        return view('contact-success', [
            'home' => $homePage->merged(),
        ]);
    }
}
