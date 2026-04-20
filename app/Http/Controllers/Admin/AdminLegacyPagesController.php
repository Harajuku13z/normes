<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegacyPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminLegacyPagesController extends Controller
{
    public function index(): View
    {
        $pages = LegacyPage::query()
            ->orderBy('old_path')
            ->paginate(50);

        return view('admin.legacy_pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.legacy_pages.form', [
            'legacyPage' => new LegacyPage(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        LegacyPage::query()->create($data);

        return redirect()
            ->route('admin.legacy_pages.index')
            ->with('status', 'Page legacy créée.');
    }

    public function edit(LegacyPage $legacyPage): View
    {
        return view('admin.legacy_pages.form', [
            'legacyPage' => $legacyPage,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, LegacyPage $legacyPage): RedirectResponse
    {
        $data = $this->validated($request, $legacyPage->id);
        // Automatically lock the page so the WP importer won't overwrite manual edits
        $data['content_locked'] = true;
        $legacyPage->update($data);

        return redirect()
            ->route('admin.legacy_pages.index')
            ->with('status', 'Page legacy mise à jour.');
    }

    public function destroy(LegacyPage $legacyPage): RedirectResponse
    {
        $legacyPage->delete();

        return redirect()
            ->route('admin.legacy_pages.index')
            ->with('status', 'Page legacy supprimée.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'old_path' => \App\Models\LegacyPage::normalizePath((string) $request->input('old_path', '')),
        ]);

        return $request->validate([
            'old_path' => ['required', 'string', 'max:255', Rule::unique('legacy_pages', 'old_path')->ignore($ignoreId)],
            'title' => ['required', 'string', 'max:255'],
            'h1' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content_html' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'is_active'      => ['nullable', 'boolean'],
            'content_locked' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ];
    }
}

