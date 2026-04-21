<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\LegacyPage;
use App\Services\Legacy\WordPressApiImporter;
use App\Services\Legacy\WordPressLegacyImporter;
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
     * Trigger WordPress import via the live REST API (no SSH, no XML file needed).
     * - Deletes all non-locked legacy_pages (fresh start)
     * - Imports ad + page → legacy_pages  (images from nr.normesrenovation.fr)
     * - Imports post → blog_posts
     */
    public function importWordPress(Request $request): RedirectResponse
    {
        @set_time_limit(600);
        @ignore_user_abort(true);

        // 1. Delete all non-locked legacy_pages (keep manually-edited ones)
        $deleted = LegacyPage::query()->where('content_locked', false)->delete();

        // 2. Run full import via REST API
        /** @var WordPressApiImporter $importer */
        $importer = app(WordPressApiImporter::class);

        try {
            $result = $importer->importAll(updateExisting: true);
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.legacy_pages.index')
                ->with('import_error', 'Erreur lors de l\'import API WordPress : ' . $e->getMessage());
        }

        $p = $result['pages'];
        $b = $result['posts'];

        $msg = sprintf(
            'Import terminé (API WordPress). Pages supprimées : %d. Legacy créées : %d / mises à jour : %d / ignorées : %d. Articles créés : %d / mis à jour : %d.',
            $deleted, $p['created'], $p['updated'], $p['skipped'], $b['created'], $b['updated']
        );

        return redirect()
            ->route('admin.legacy_pages.index')
            ->with('import_status', $msg);
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

