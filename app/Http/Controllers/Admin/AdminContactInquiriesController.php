<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminContactInquiriesController extends Controller
{
    public function index(): View
    {
        $inquiries = ContactInquiry::query()
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.contact_inquiries.index', compact('inquiries'));
    }

    public function show(ContactInquiry $contactInquiry): View
    {
        return view('admin.contact_inquiries.show', compact('contactInquiry'));
    }

    public function destroy(ContactInquiry $contactInquiry): RedirectResponse
    {
        $label = trim((string) ($contactInquiry->nom_complet ?: $contactInquiry->email ?: 'Demande #'.$contactInquiry->id));

        $contactInquiry->delete();

        return redirect()
            ->route('admin.contact_inquiries.index')
            ->with('status', 'Demande supprimée : '.$label.'.');
    }
}
