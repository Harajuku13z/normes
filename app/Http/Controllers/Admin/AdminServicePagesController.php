<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

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
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'title' => ['required', 'string', 'max:190'],
            'subtitle' => ['nullable', 'string', 'max:190'],
            'intro' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'sub_services_section_title' => ['nullable', 'string', 'max:190'],
            'sub_services_section_intro' => ['nullable', 'string'],
            'sub_services' => ['nullable', 'array'],
            'sub_services.*.title' => ['nullable', 'string', 'max:190'],
            'sub_services.*.subtitle' => ['nullable', 'string', 'max:300'],
            'sub_services.*.image' => ['nullable', 'string', 'max:800'],
            'realisations' => ['nullable', 'array'],
            'realisations.*.label' => ['nullable', 'string', 'max:190'],
            'realisations.*.before' => ['nullable', 'string', 'max:800'],
            'realisations.*.after' => ['nullable', 'string', 'max:800'],
            'cta_text' => ['nullable', 'string', 'max:190'],
            'cta_href' => ['nullable', 'string', 'max:500'],
            'cta_card_background' => ['nullable', 'string', 'max:800'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'service_num' => $data['service_num'] ?? null,
            ...$data,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ];

        // Compatibilité : si la migration n'est pas encore faite, on évite une erreur DB.
        if (! Schema::hasColumn('service_pages', 'meta_title')) {
            unset($payload['meta_title']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_description')) {
            unset($payload['meta_description']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_keywords')) {
            unset($payload['meta_keywords']);
        }
        if (! Schema::hasColumn('service_pages', 'cta_card_background')) {
            unset($payload['cta_card_background']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services')) {
            unset($payload['sub_services']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_title')) {
            unset($payload['sub_services_section_title']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_intro')) {
            unset($payload['sub_services_section_intro']);
        }
        if (! Schema::hasColumn('service_pages', 'realisations')) {
            unset($payload['realisations']);
        }

        ServicePage::query()->create($payload);

        return redirect()->route('admin.services_pages.index')->with('status', 'Page service créée.');
    }

    public function update(Request $request, ServicePage $servicePage): RedirectResponse
    {
        $data = $request->validate([
            'service_num' => ['nullable', 'integer'],
            'slug' => ['required', 'string', 'max:190', 'unique:service_pages,slug,'.$servicePage->id],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'title' => ['required', 'string', 'max:190'],
            'subtitle' => ['nullable', 'string', 'max:190'],
            'intro' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'sub_services_section_title' => ['nullable', 'string', 'max:190'],
            'sub_services_section_intro' => ['nullable', 'string'],
            'sub_services' => ['nullable', 'array'],
            'sub_services.*.title' => ['nullable', 'string', 'max:190'],
            'sub_services.*.subtitle' => ['nullable', 'string', 'max:300'],
            'sub_services.*.image' => ['nullable', 'string', 'max:800'],
            'realisations' => ['nullable', 'array'],
            'realisations.*.label' => ['nullable', 'string', 'max:190'],
            'realisations.*.before' => ['nullable', 'string', 'max:800'],
            'realisations.*.after' => ['nullable', 'string', 'max:800'],
            'cta_text' => ['nullable', 'string', 'max:190'],
            'cta_href' => ['nullable', 'string', 'max:500'],
            'cta_card_background' => ['nullable', 'string', 'max:800'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'service_num' => $data['service_num'] ?? null,
            ...$data,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ];

        if (! Schema::hasColumn('service_pages', 'meta_title')) {
            unset($payload['meta_title']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_description')) {
            unset($payload['meta_description']);
        }
        if (! Schema::hasColumn('service_pages', 'meta_keywords')) {
            unset($payload['meta_keywords']);
        }
        if (! Schema::hasColumn('service_pages', 'cta_card_background')) {
            unset($payload['cta_card_background']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services')) {
            unset($payload['sub_services']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_title')) {
            unset($payload['sub_services_section_title']);
        }
        if (! Schema::hasColumn('service_pages', 'sub_services_section_intro')) {
            unset($payload['sub_services_section_intro']);
        }
        if (! Schema::hasColumn('service_pages', 'realisations')) {
            unset($payload['realisations']);
        }

        $servicePage->update($payload);

        return redirect()->route('admin.services_pages.edit', $servicePage)->with('status', 'Page service enregistrée.');
    }
}

