@extends('admin.layout')

@section('title', 'Sections — Admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Admin — Général</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">
            Accès rapide aux modifications générales du site.
        </p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Accueil</h2>
            <p class="mt-1 text-sm text-slate-600">Formulaires pour modifier l’accueil (hero, services, realisations, footer, etc.).</p>
            <a href="{{ route('admin.homepage.edit') }}" class="mt-5 inline-flex w-fit items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Modifier l’accueil
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Pages services</h2>
            <p class="mt-1 text-sm text-slate-600">Créer / modifier les pages “Traitement et démoussage…” et autres services.</p>
            <a href="{{ route('admin.services_pages.index') }}" class="mt-5 inline-flex w-fit items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Gérer les pages services
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Page contact</h2>
            <p class="mt-1 text-sm text-slate-600">Accès direct aux champs qui alimentent la page contact (hero, coordonnées, réseaux sociaux, formulaire).</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.homepage.edit') }}#section-devis" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Hero + Formulaire
                </a>
                <a href="{{ route('admin.homepage.edit') }}#section-footer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Adresse + Réseaux
                </a>
                <a href="{{ route('contact.page') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir la page contact
                </a>
            </div>
        </div>
    </div>
@endsection
