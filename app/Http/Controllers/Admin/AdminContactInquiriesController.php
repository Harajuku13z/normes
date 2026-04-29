<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
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
}
