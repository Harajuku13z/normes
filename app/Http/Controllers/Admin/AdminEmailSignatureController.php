<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSignature;
use App\Support\EmailSignaturePresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEmailSignatureController extends Controller
{
    public function index(): View
    {
        return view('admin.email_signatures.index', [
            'signatures' => EmailSignature::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.email_signatures.form', [
            'signature' => new EmailSignature([
                'website_url' => 'https://normesrenovation.fr',
                'facebook_url' => 'https://www.facebook.com/NormesRenovation',
                'instagram_url' => 'https://www.instagram.com/normesrenovation/',
                'linkedin_url' => 'https://www.linkedin.com/company/normes-rénovation/',
                'cta_primary_label' => 'Demander un devis',
                'cta_primary_url' => 'https://normesrenovation.fr/contact#devis',
                'cta_secondary_label' => 'Voir nos réalisations',
                'cta_secondary_url' => 'https://normesrenovation.fr/realisations',
                'location' => 'Chalon-sur-Saône',
                'is_active' => true,
            ]),
            'isEdit' => false,
            'signatureHtml' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = trim((string) ($data['slug'] ?? '')) !== ''
            ? EmailSignature::makeUniqueSlug((string) $data['slug'])
            : EmailSignature::makeUniqueSlug((string) $data['full_name']);
        $data['photo_path'] = $this->normalizeStoredPath((string) ($data['photo_path'] ?? ''));

        $signature = EmailSignature::query()->create($data);

        return redirect()
            ->route('admin.email_signatures.edit', $signature)
            ->with('status', 'Signature mail créée.');
    }

    public function edit(EmailSignature $emailSignature): View
    {
        return view('admin.email_signatures.form', [
            'signature' => $emailSignature,
            'isEdit' => true,
            'signatureHtml' => EmailSignaturePresenter::renderHtml($emailSignature),
        ]);
    }

    public function update(Request $request, EmailSignature $emailSignature): RedirectResponse
    {
        $data = $this->validated($request, $emailSignature);
        $incomingSlug = trim((string) ($data['slug'] ?? ''));
        $data['slug'] = $incomingSlug !== ''
            ? EmailSignature::makeUniqueSlug($incomingSlug, $emailSignature->id)
            : EmailSignature::makeUniqueSlug((string) $data['full_name'], $emailSignature->id);
        $data['photo_path'] = $this->normalizeStoredPath((string) ($data['photo_path'] ?? ''));

        $emailSignature->update($data);

        return redirect()
            ->route('admin.email_signatures.edit', $emailSignature)
            ->with('status', 'Signature mail enregistrée.');
    }

    public function destroy(EmailSignature $emailSignature): RedirectResponse
    {
        $emailSignature->delete();

        return redirect()
            ->route('admin.email_signatures.index')
            ->with('status', 'Signature mail supprimée.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?EmailSignature $signature = null): array
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'role_title' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'cta_primary_label' => ['nullable', 'string', 'max:255'],
            'cta_primary_url' => ['nullable', 'url', 'max:255'],
            'cta_secondary_label' => ['nullable', 'string', 'max:255'],
            'cta_secondary_url' => ['nullable', 'url', 'max:255'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'full_name' => 'nom complet',
            'role_title' => 'poste',
            'website_url' => 'URL du site',
            'cta_primary_url' => 'URL du bouton principal',
            'cta_secondary_url' => 'URL du bouton secondaire',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function normalizeStoredPath(string $path): ?string
    {
        $path = trim(str_replace('\\', '/', $path));
        if ($path === '') {
            return null;
        }
        if (preg_match('#^https?://[^/]+/(.+)$#i', $path, $m)) {
            $path = (string) $m[1];
        }
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        return ltrim($path, '/');
    }
}
