<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminServicePagesController extends Controller
{
    public function index(): View
    {
        $pages = ServicePage::query()
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('admin.services_pages.index', [
            'pages' => $pages,
        ]);
    }

    public function create(): View
    {
        return view('admin.services_pages.form', [
            'page' => new ServicePage(),
        ]);
    }

    public function edit(ServicePage $servicePage): View
    {
        return view('admin.services_pages.form', [
            'page' => $servicePage,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_num' => ['nullable', 'integer'],
            'slug' => ['required', 'string', 'max:190', 'unique:service_pages,slug'],
            'title' => ['required', 'string', 'max:190'],
            'subtitle' => ['nullable', 'string', 'max:190'],
            'intro' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'cta_text' => ['nullable', 'string', 'max:190'],
            'cta_href' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ServicePage::query()->create([
            'service_num' => $data['service_num'] ?? null,
            ...$data,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('admin.services_pages.index')->with('status', 'Page service créée.');
    }

    public function update(Request $request, ServicePage $servicePage): RedirectResponse
    {
        $data = $request->validate([
            'service_num' => ['nullable', 'integer'],
            'slug' => ['required', 'string', 'max:190', 'unique:service_pages,slug,'.$servicePage->id],
            'title' => ['required', 'string', 'max:190'],
            'subtitle' => ['nullable', 'string', 'max:190'],
            'intro' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'cta_text' => ['nullable', 'string', 'max:190'],
            'cta_href' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $servicePage->update([
            'service_num' => $data['service_num'] ?? null,
            ...$data,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('admin.services_pages.edit', $servicePage)->with('status', 'Page service enregistrée.');
    }
}

