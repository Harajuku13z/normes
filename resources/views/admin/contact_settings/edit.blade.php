@extends('admin.layout')

@section('title', 'Page contact — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Page contact</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Modifiez ici uniquement les données utilisées par la page contact (hero, formulaire, coordonnées, réseaux sociaux).
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Retour
            </a>
            <a href="{{ route('contact.page') }}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Voir la page contact
            </a>
        </div>
    </div>

    <form method="post" action="{{ route('admin.contact_settings.update') }}" class="space-y-5">
        @csrf

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Hero + Formulaire + Coordonnées agences (section `devis`)
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[devis]',
                    'value' => $merged['devis'] ?? [],
                    'depth' => 0,
                ])
            </div>
        </details>

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Adresse, téléphone, email, réseaux sociaux (section `footer`)
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[footer]',
                    'value' => $merged['footer'] ?? [],
                    'depth' => 0,
                ])
            </div>
        </details>

        <div class="pt-2">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer
            </button>
        </div>
    </form>
@endsection
