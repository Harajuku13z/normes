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
            <h2 class="text-lg font-extrabold text-slate-900">Réalisations</h2>
            <p class="mt-1 text-sm text-slate-600">Page <code class="text-xs">/realisations</code> : hero, SEO et projets avec galeries photos.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.realisations.index') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Gérer les réalisations
                </a>
                <a href="{{ route('realisations.page') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir /realisations
                </a>
            </div>
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
            <p class="mt-1 text-sm text-slate-600">Page dédiée pour modifier les contenus de contact (hero, formulaire, coordonnées, réseaux sociaux).</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.contact_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Modifier la page contact
                </a>
                <a href="{{ route('contact.page') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir la page contact
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Page À propos</h2>
            <p class="mt-1 text-sm text-slate-600">Hero, piliers, textes, avis, image satisfaction / médiation, mentions légales et bandeaux contact.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.about_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Modifier la page À propos
                </a>
                <a href="{{ route('about.page') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir /a-propos
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Page Franchise</h2>
            <p class="mt-1 text-sm text-slate-600">Hero, piliers, implantation, réseau, étapes, FAQ et formulaire de candidature.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.franchise_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Modifier la page franchise
                </a>
                <a href="{{ route('franchise.page') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir /franchise
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Avis</h2>
            <p class="mt-1 text-sm text-slate-600">Page dédiée : importer les avis Google (SerAPI) et gérer manuellement les avis des autres plateformes.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.avis_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Gérer les avis
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Header & Footer</h2>
            <p class="mt-1 text-sm text-slate-600">Page dédiée : composer le menu header (routes + ancres) et modifier le footer.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.layout_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Modifier Header & Footer
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Simulator</h2>
            <p class="mt-1 text-sm text-slate-600">SMTP config and leads history are now separated into dedicated pages.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.simulateur_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Open SMTP settings
                </a>
                <a href="{{ route('admin.simulateur_leads.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Open leads page
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">IA Services</h2>
            <p class="mt-1 text-sm text-slate-600">Configure le prompt IA et la clé API pour générer automatiquement les fiches service et sous-services.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.ai_service_settings.edit') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Ouvrir la config IA
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <h2 class="text-lg font-extrabold text-slate-900">Legacy URLs (SEO)</h2>
            <p class="mt-1 text-sm text-slate-600">Crée des pages 200 sur les anciennes URLs WordPress pour conserver les pages indexées Google sans redirection.</p>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.legacy_pages.index') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                    Gérer les URLs legacy
                </a>
            </div>
        </div>
    </div>
@endsection
