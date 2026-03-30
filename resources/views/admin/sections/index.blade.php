@extends('admin.layout')

@section('title', 'Sections — Admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Admin — Accueil &amp; contenus</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">
            Modifiez les blocs de la page d'accueil (et les pages associées) via de petites cartes. Chaque “card” ouvre les sections liées.
        </p>
    </div>

    @php
        $cardGroups = [
            [
                'title' => 'Accueil',
                'primary_key' => 'hero',
                'keys' => ['styles', 'header', 'hero', 'simulateur', 'floating'],
                'desc' => 'Hero, diaporama, simulateur et barre mobile.',
            ],
            [
                'title' => 'SEO &amp; styles',
                'primary_key' => 'styles',
                'keys' => ['meta', 'styles'],
                'desc' => 'Arrière-plans, variables et métadonnées.',
            ],
            [
                'title' => 'À propos',
                'primary_key' => 'about',
                'keys' => ['about', 'processus', 'aides_renov', 'pourquoi'],
                'desc' => 'Texte + Pourquoi nous ? + Processus MaPrimeRénov’.',
            ],
            [
                'title' => 'Nos services',
                'primary_key' => 'services',
                'keys' => ['services'],
                'desc' => 'Cartes services (images + titres + textes).',
            ],
            [
                'title' => 'Réalisations',
                'primary_key' => 'realisations',
                'keys' => ['realisations'],
                'desc' => 'Avant / après (projets & contenus).',
            ],
            [
                'title' => 'Nos agences &amp; franchise',
                'primary_key' => 'agences',
                'keys' => ['agences', 'map'],
                'desc' => 'Agences (et bloc franchise).',
            ],
            [
                'title' => 'Chiffres clés &amp; avis',
                'primary_key' => 'avis',
                'keys' => ['stats', 'avis'],
                'desc' => 'Stats + avis clients.',
            ],
            [
                'title' => 'Contact &amp; devis',
                'primary_key' => 'devis',
                'keys' => ['devis', 'footer'],
                'desc' => 'Formulaire + pied de page.',
            ],
            [
                'title' => 'Blog / conseils',
                'primary_key' => 'blog',
                'keys' => ['blog'],
                'desc' => 'Articles &amp; conseils affichés sur le site.',
            ],
            [
                'title' => 'Partenaires',
                'primary_key' => 'partners',
                'keys' => ['partners'],
                'desc' => 'Marquee partenaires & certifications.',
            ],
            [
                'title' => 'Confidentialité',
                'primary_key' => null,
                'keys' => [],
                'desc' => 'Mentions légales / confidentialité / CGV : à ajouter dans le module d’édition si tu veux.',
            ],
        ];
    @endphp

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($cardGroups as $group)
            @php
                $keysForGroup = array_values(array_filter($group['keys'], fn($k) => in_array($k, $keys, true)));
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">{{ $group['title'] }}</h2>
                        <p class="mt-1 text-sm text-slate-600">{{ $group['desc'] }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    @if (!empty($group['primary_key']))
                        <a
                            href="{{ route('admin.section.edit', $group['primary_key']) }}"
                            class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700"
                        >
                            Modifier
                        </a>
                    @else
                        <span class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-extrabold text-slate-500">
                            Info
                        </span>
                    @endif
                </div>

                @if (!empty($keysForGroup))
                    <div class="mt-4">
                        <p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Sections incluses</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($keysForGroup as $k)
                                <a
                                    href="{{ route('admin.section.edit', $k) }}"
                                    class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-white"
                                >
                                    {{ $labels[$k] ?? $k }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
