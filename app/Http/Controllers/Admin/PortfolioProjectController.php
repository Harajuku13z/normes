<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioProjectRequest;
use App\Http\Requests\UpdatePortfolioProjectRequest;
use App\Models\PortfolioProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PortfolioProjectController extends Controller
{
    public function index(): View
    {
        $projects = PortfolioProject::query()
            ->withCount('images')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.portfolio_projects.index', [
            'projects' => $projects,
        ]);
    }

    public function create(): View
    {
        return view('admin.portfolio_projects.form', [
            'project' => new PortfolioProject,
            'isEdit' => false,
        ]);
    }

    public function store(StorePortfolioProjectRequest $request): RedirectResponse
    {
        $project = DB::transaction(function () use ($request): PortfolioProject {
            $data = $request->validated();
            $slug = $data['slug'] ?? null;
            if ($slug === null || $slug === '') {
                $slug = PortfolioProject::makeUniqueSlugFromTitle($data['title']);
            }
            $project = PortfolioProject::query()->create([
                'title' => $data['title'],
                'slug' => $slug,
                'description' => $data['description'] ?? null,
                'sort_order' => (int) ($data['sort_order'] ?? 0),
            ]);
            $this->syncImages($project, $request->input('images', []));

            return $project;
        });

        return redirect()
            ->route('admin.portfolio_projects.edit', $project)
            ->with('status', 'Projet créé.');
    }

    public function edit(PortfolioProject $portfolio_project): View
    {
        $portfolio_project->load('images');

        return view('admin.portfolio_projects.form', [
            'project' => $portfolio_project,
            'isEdit' => true,
        ]);
    }

    public function update(UpdatePortfolioProjectRequest $request, PortfolioProject $portfolio_project): RedirectResponse
    {
        DB::transaction(function () use ($request, $portfolio_project): void {
            $data = $request->validated();
            $slug = $data['slug'] ?? null;
            if ($slug === null || $slug === '') {
                $slug = $portfolio_project->slug ?? PortfolioProject::makeUniqueSlugFromTitle($data['title'], $portfolio_project->id);
            }
            $portfolio_project->update([
                'title' => $data['title'],
                'slug' => $slug,
                'description' => $data['description'] ?? null,
                'sort_order' => (int) ($data['sort_order'] ?? 0),
            ]);
            $this->syncImages($portfolio_project, $request->input('images', []));
        });

        return redirect()
            ->route('admin.portfolio_projects.edit', $portfolio_project)
            ->with('status', 'Projet enregistré.');
    }

    public function destroy(PortfolioProject $portfolio_project): RedirectResponse
    {
        $portfolio_project->delete();

        return redirect()
            ->route('admin.portfolio_projects.index')
            ->with('status', 'Projet supprimé.');
    }

    /**
     * @param  array<int, mixed>  $imagesInput
     */
    protected function syncImages(PortfolioProject $project, array $imagesInput): void
    {
        $project->images()->delete();

        $order = 0;
        foreach ($imagesInput as $row) {
            if (! is_array($row)) {
                continue;
            }
            $path = trim((string) ($row['path'] ?? ''));
            if ($path === '') {
                continue;
            }
            $path = $this->normalizeStoredPath($path);
            $project->images()->create([
                'path' => $path,
                'alt' => trim((string) ($row['alt'] ?? '')) ?: null,
                'sort_order' => $order,
            ]);
            $order++;
        }
    }

    protected function normalizeStoredPath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));
        if (preg_match('#^https?://[^/]+/(.+)$#i', $path, $m)) {
            $path = (string) $m[1];
        }
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        return ltrim($path, '/');
    }
}
