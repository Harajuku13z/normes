@extends('admin.layout')

@section('title', 'Réalisations — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Réalisations</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Page publique <code class="rounded bg-slate-100 px-1 text-xs">/realisations</code> : textes du hero / SEO, et projets avec plusieurs photos.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Accueil admin
        </a>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Contenu & SEO de la page</h2>
            <p class="mt-1 text-sm text-slate-600">Hero, métadonnées, image Open Graph.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.realisations.page.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Modifier les textes
                </a>
                <a href="{{ route('realisations.page') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir /realisations
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Projets &amp; photos</h2>
            <p class="mt-1 text-sm text-slate-600">
                <strong>{{ $projectCount }}</strong> projet(s). Chaque projet : titre, description, plusieurs images (upload).
            </p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.portfolio_projects.index') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Liste des projets
                </a>
                <a href="{{ route('admin.portfolio_projects.create') }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Nouveau projet
                </a>
            </div>
        </div>
    </div>
@endsection
