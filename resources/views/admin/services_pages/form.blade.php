@php
    $isEdit = isset($page) && $page->exists;
    $pageTitle = $isEdit ? 'Modifier la page service' : 'Créer une page service';
    $subServices = is_array($page->sub_services ?? null) ? $page->sub_services : [];
    $realisations = is_array($page->realisations ?? null) ? $page->realisations : [];
    $ov = is_array($page->content_overrides ?? null) ? $page->content_overrides : [];
@endphp

@extends('admin.layout')

@section('title', $pageTitle)

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $pageTitle }}</h1>
            <p class="mt-1 text-sm text-slate-600">Cette page sera accessible publiquement et liée au CTA “En savoir plus”.</p>
        </div>
        <a href="{{ route('admin.services_pages.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Retour
        </a>
    </div>

    <form method="post" action="{{ $isEdit ? route('admin.services_pages.update', $page) : route('admin.services_pages.store') }}" class="space-y-5">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        @if ($isEdit && !empty($page->slug))
            <div class="flex flex-wrap items-center justify-end">
                <a
                    href="{{ route('service.page', $page->slug) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50"
                >
                    Voir la page du service
                </a>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900">Assistant IA — Génération de fiche service</h2>
                    <p class="mt-1 text-xs text-slate-500">Saisis un titre + une description courte, puis clique “Générer avec IA”. Les champs ci-dessous seront remplis automatiquement.</p>
                </div>
                <a href="{{ route('admin.ai_service_settings.edit') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-extrabold text-slate-700 hover:bg-slate-50">
                    Config IA
                </a>
            </div>
            <div class="mt-3 grid gap-3 lg:grid-cols-[1fr_1fr_auto] lg:items-end">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Titre du service (IA)</label>
                    <input id="aiSourceTitle" type="text" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" placeholder="Ex: Isolation thermique extérieure" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Description courte (IA)</label>
                    <textarea id="aiSourceDescription" rows="2" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" placeholder="Ex: Solution performante pour améliorer le confort et réduire les consommations."></textarea>
                </div>
                <button id="aiGenerateBtn" type="button" class="inline-flex items-center justify-center rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-extrabold text-white hover:bg-sky-700">
                    Générer avec IA
                </button>
            </div>
            <p id="aiGenerateStatus" class="mt-2 text-xs font-semibold text-slate-500"></p>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">Slug (URL)</label>
                <input name="slug" required value="{{ old('slug', $page->slug ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Service num (pour matcher)</label>
                <input name="service_num" value="{{ old('service_num', $page->service_num ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                <p class="mt-1 text-xs text-slate-500">Correspond au champ `num` dans “Nos services” (ex: 1 pour Traitement et démoussage).</p>
            </div>
        </div>

        {{-- SEO / Meta --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="mb-3">
                <h2 class="text-sm font-extrabold text-slate-900">SEO (meta)</h2>
                <p class="mt-1 text-xs text-slate-500">Ces champs remplacent le SEO global de la homepage pour cette page service.</p>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <label class="text-sm font-semibold text-slate-800">Meta title</label>
                        <span id="metaTitleCount" class="text-xs font-semibold text-slate-500">0 / 60</span>
                    </div>
                    <input
                        id="metaTitleInput"
                        name="meta_title"
                        value="{{ old('meta_title', $page->meta_title ?? '') }}"
                        placeholder="Ex. Traitement et démoussage de toiture | Normes & Rénovation"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3">
                        <label class="text-sm font-semibold text-slate-800">Meta keywords</label>
                        <span id="metaKeywordsCount" class="text-xs font-semibold text-slate-500">0 / 200</span>
                    </div>
                    <input
                        id="metaKeywordsInput"
                        name="meta_keywords"
                        value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                        placeholder="démoussage toiture, hydrofuge, nettoyage toiture, ..."
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                </div>
            </div>

            <div class="mt-4">
                <div class="flex items-center justify-between gap-3">
                    <label class="text-sm font-semibold text-slate-800">Meta description</label>
                    <span id="metaDescriptionCount" class="text-xs font-semibold text-slate-500">0 / 160</span>
                </div>
                <textarea
                    id="metaDescriptionInput"
                    name="meta_description"
                    rows="3"
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                >{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">Titre</label>
                <input name="title" required value="{{ old('title', $page->title ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">Sous-titre</label>
                <input name="subtitle" value="{{ old('subtitle', $page->subtitle ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold text-slate-800">Intro</label>
            <textarea name="intro" rows="3" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('intro', $page->intro ?? '') }}</textarea>
        </div>

        <div>
            <label class="text-sm font-semibold text-slate-800">Description (page service)</label>
            <p class="mt-1 text-xs text-slate-500">
                Affichée <strong>au-dessus</strong> des sous-services sur la page publique. Éditeur : titres, gras, listes, liens, etc.
            </p>
            <textarea
                id="serviceBodyEditor"
                name="body"
                rows="14"
                class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
            >{{ old('body', $page->body ?? '') }}</textarea>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="mb-4">
                <h2 class="text-sm font-extrabold text-slate-900">Textes de la page service (éditables)</h2>
                <p class="mt-1 text-xs text-slate-500">Permet de personnaliser les libellés visibles sur la page (hors header/footer).</p>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Intro</p>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Kicker (ex. En bref)</label>
                    <input name="content_overrides[intro][kicker]" value="{{ old('content_overrides.intro.kicker', data_get($ov, 'intro.kicker', 'En bref')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Badge 1</label>
                    <input name="content_overrides[intro][badges][0]" value="{{ old('content_overrides.intro.badges.0', data_get($ov, 'intro.badges.0', 'Sans engagement')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Badge 2</label>
                    <input name="content_overrides[intro][badges][1]" value="{{ old('content_overrides.intro.badges.1', data_get($ov, 'intro.badges.1', 'Réponse sous 48h')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Badge 3</label>
                    <input name="content_overrides[intro][badges][2]" value="{{ old('content_overrides.intro.badges.2', data_get($ov, 'intro.badges.2', 'Devis gratuit')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Navigation & blocs</p>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Nav — Services</label>
                    <input name="content_overrides[subnav][services]" value="{{ old('content_overrides.subnav.services', data_get($ov, 'subnav.services', 'Services')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Nav — Réalisations</label>
                    <input name="content_overrides[subnav][realisations]" value="{{ old('content_overrides.subnav.realisations', data_get($ov, 'subnav.realisations', 'Réalisations')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Nav — Avis</label>
                    <input name="content_overrides[subnav][avis]" value="{{ old('content_overrides.subnav.avis', data_get($ov, 'subnav.avis', 'Avis')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Nav — Contact</label>
                    <input name="content_overrides[subnav][contact]" value="{{ old('content_overrides.subnav.contact', data_get($ov, 'subnav.contact', 'Contact')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
            </div>

            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Chiffres & partenaires</p>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Titre bloc chiffres</label>
                    <input name="content_overrides[stats][heading]" value="{{ old('content_overrides.stats.heading', data_get($ov, 'stats.heading', 'Chiffres clés')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Lien bloc chiffres</label>
                    <input name="content_overrides[stats][link_text]" value="{{ old('content_overrides.stats.link_text', data_get($ov, 'stats.link_text', 'Voir les avis')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Titre bloc partenaires</label>
                    <input name="content_overrides[partners][heading]" value="{{ old('content_overrides.partners.heading', data_get($ov, 'partners.heading', 'Partenaires associés')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Lien bloc partenaires</label>
                    <input name="content_overrides[partners][link_text]" value="{{ old('content_overrides.partners.link_text', data_get($ov, 'partners.link_text', 'Nous contacter')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Cartes & réalisations</p>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Bouton sous-service</label>
                    <input name="content_overrides[sub_services][cta_text]" value="{{ old('content_overrides.sub_services.cta_text', data_get($ov, 'sub_services.cta_text', 'C’EST CE QU’IL ME FAUT')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Bouton doc technique</label>
                    <input name="content_overrides[sub_services][doc_text]" value="{{ old('content_overrides.sub_services.doc_text', data_get($ov, 'sub_services.doc_text', 'DOC TECHNIQUE')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    @php
                        $subCardModel = old('content_overrides.sub_services.card_model', data_get($ov, 'sub_services.card_model', 'overlay'));
                    @endphp
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Mode visuel des cartes sous-services</label>
                    <div class="mt-2 grid gap-2 sm:grid-cols-2">
                        <label class="inline-flex items-start gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700">
                            <input type="radio" name="content_overrides[sub_services][card_model]" value="overlay" {{ $subCardModel === 'overlay' ? 'checked' : '' }}>
                            <span>
                                <span class="block font-extrabold">Image en fond (défaut)</span>
                                <span class="block text-xs font-medium text-slate-500">Image pleine carte, texte superposé.</span>
                            </span>
                        </label>
                        <label class="inline-flex items-start gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700">
                            <input type="radio" name="content_overrides[sub_services][card_model]" value="split" {{ $subCardModel === 'split' ? 'checked' : '' }}>
                            <span>
                                <span class="block font-extrabold">Fond blanc séparé</span>
                                <span class="block text-xs font-medium text-slate-500">Image en haut, texte et boutons en bloc blanc.</span>
                            </span>
                        </label>
                    </div>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Hauteur des cartes sous-services</label>
                    <div class="mt-2 grid gap-2 sm:grid-cols-2">
                        @php
                            $subCardHeight = old('content_overrides.sub_services.card_height', data_get($ov, 'sub_services.card_height', 'normal'));
                            $subCardColumns = old('content_overrides.sub_services.columns_desktop', data_get($ov, 'sub_services.columns_desktop', 'auto'));
                        @endphp
                        <label class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700">
                            <input type="radio" name="content_overrides[sub_services][card_height]" value="normal" {{ $subCardHeight === 'normal' ? 'checked' : '' }}>
                            Standard
                        </label>
                        <label class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700">
                            <input type="radio" name="content_overrides[sub_services][card_height]" value="tall" {{ $subCardHeight === 'tall' ? 'checked' : '' }}>
                            Allongée (texte long)
                        </label>
                    </div>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Nombre de cartes par ligne (desktop)</label>
                    <select
                        name="content_overrides[sub_services][columns_desktop]"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    >
                        <option value="auto" {{ $subCardColumns === 'auto' ? 'selected' : '' }}>Auto (règle intelligente)</option>
                        <option value="2" {{ $subCardColumns === '2' ? 'selected' : '' }}>2 par ligne</option>
                        <option value="3" {{ $subCardColumns === '3' ? 'selected' : '' }}>3 par ligne</option>
                        <option value="4" {{ $subCardColumns === '4' ? 'selected' : '' }}>4 par ligne</option>
                    </select>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Titre réalisations (accent)</label>
                    <input name="content_overrides[realisations][title_accent]" value="{{ old('content_overrides.realisations.title_accent', data_get($ov, 'realisations.title_accent', 'Réalisations')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Titre réalisations (suite)</label>
                    <input name="content_overrides[realisations][title_rest]" value="{{ old('content_overrides.realisations.title_rest', data_get($ov, 'realisations.title_rest', 'avant / après')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Texte intro réalisations</label>
                    <input name="content_overrides[realisations][intro]" value="{{ old('content_overrides.realisations.intro', data_get($ov, 'realisations.intro', 'Faites glisser le curseur pour comparer.')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <div class="mt-3 grid gap-3 lg:grid-cols-2">
                        <input name="content_overrides[realisations][before_label]" value="{{ old('content_overrides.realisations.before_label', data_get($ov, 'realisations.before_label', 'Avant')) }}" placeholder="Label Avant" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                        <input name="content_overrides[realisations][after_label]" value="{{ old('content_overrides.realisations.after_label', data_get($ov, 'realisations.after_label', 'Après')) }}" placeholder="Label Après" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Avis clients</p>
                <div class="mt-3 grid gap-3 lg:grid-cols-2">
                    <input name="content_overrides[avis][kicker]" value="{{ old('content_overrides.avis.kicker', data_get($ov, 'avis.kicker', 'Avis multi-plateformes')) }}" placeholder="Kicker avis" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <input name="content_overrides[avis][google_button]" value="{{ old('content_overrides.avis.google_button', data_get($ov, 'avis.google_button', 'Voir la fiche')) }}" placeholder="Texte bouton Google" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div class="mt-3 grid gap-3 lg:grid-cols-2">
                    <input name="content_overrides[avis][title_accent]" value="{{ old('content_overrides.avis.title_accent', data_get($ov, 'avis.title_accent', 'Ce que nos clients')) }}" placeholder="Titre avis - partie couleur" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <input name="content_overrides[avis][title_rest]" value="{{ old('content_overrides.avis.title_rest', data_get($ov, 'avis.title_rest', 'pensent de nous')) }}" placeholder="Titre avis - partie non couleur" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <textarea name="content_overrides[avis][intro]" rows="2" placeholder="Intro avis" class="mt-3 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('content_overrides.avis.intro', data_get($ov, 'avis.intro', '')) }}</textarea>
                <input name="content_overrides[avis][platform_info]" value="{{ old('content_overrides.avis.platform_info', data_get($ov, 'avis.platform_info', 'Des retours concrets, provenant de plusieurs plateformes.')) }}" placeholder="Texte sous le titre des avis" class="mt-3 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Processus</p>
                <div class="mt-3 grid gap-3 lg:grid-cols-3">
                    <input name="content_overrides[process][kicker]" value="{{ old('content_overrides.process.kicker', data_get($ov, 'process.kicker', 'Processus')) }}" placeholder="Kicker" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <input name="content_overrides[process][title_accent]" value="{{ old('content_overrides.process.title_accent', data_get($ov, 'process.title_accent', 'Prise en charge')) }}" placeholder="Titre accent" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <input name="content_overrides[process][title_rest]" value="{{ old('content_overrides.process.title_rest', data_get($ov, 'process.title_rest', 'en 4 étapes')) }}" placeholder="Titre suite" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <textarea name="content_overrides[process][intro]" rows="2" placeholder="Intro processus" class="mt-3 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('content_overrides.process.intro', data_get($ov, 'process.intro', '')) }}</textarea>
                <input name="content_overrides[process][cta_text]" value="{{ old('content_overrides.process.cta_text', data_get($ov, 'process.cta_text', 'Demander un devis')) }}" placeholder="Texte bouton processus" class="mt-3 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />

                <div class="mt-4 grid gap-3 lg:grid-cols-2">
                    @for ($pi = 0; $pi < 4; $pi++)
                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Étape {{ $pi + 1 }}</p>
                            <input name="content_overrides[process][steps][{{ $pi }}][num]" value="{{ old("content_overrides.process.steps.$pi.num", data_get($ov, "process.steps.$pi.num", (string) ($pi + 1))) }}" placeholder="Numéro" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            <input name="content_overrides[process][steps][{{ $pi }}][title]" value="{{ old("content_overrides.process.steps.$pi.title", data_get($ov, "process.steps.$pi.title", '')) }}" placeholder="Titre étape" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            <textarea name="content_overrides[process][steps][{{ $pi }}][text]" rows="2" placeholder="Texte étape" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old("content_overrides.process.steps.$pi.text", data_get($ov, "process.steps.$pi.text", '')) }}</textarea>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Carte “Un projet de rénovation ?”</p>
                <div class="mt-3 grid gap-3 lg:grid-cols-2">
                    <input name="content_overrides[cta_card][kicker]" value="{{ old('content_overrides.cta_card.kicker', data_get($ov, 'cta_card.kicker', 'Un projet de rénovation ?')) }}" placeholder="Kicker" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <input name="content_overrides[cta_card][title]" value="{{ old('content_overrides.cta_card.title', data_get($ov, 'cta_card.title', 'Démarrez dès maintenant')) }}" placeholder="Titre" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <textarea name="content_overrides[cta_card][text]" rows="2" placeholder="Texte descriptif" class="mt-3 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('content_overrides.cta_card.text', data_get($ov, 'cta_card.text', 'Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.')) }}</textarea>
                <div class="mt-3 grid gap-3 lg:grid-cols-2">
                    <input name="content_overrides[cta_card][simulateur_text]" value="{{ old('content_overrides.cta_card.simulateur_text', data_get($ov, 'cta_card.simulateur_text', 'Ouvrir le simulateur de devis')) }}" placeholder="Texte bouton simulateur" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <input name="content_overrides[cta_card][contact_text]" value="{{ old('content_overrides.cta_card.contact_text', data_get($ov, 'cta_card.contact_text', 'Accéder au formulaire de contact')) }}" placeholder="Texte bouton contact" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">Image mise en avant (Homepage)</label>
                <input
                    id="featuredImageUrl"
                    name="featured_image"
                    value="{{ old('featured_image', $page->featured_image ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                />
                <input
                    id="featuredImageFile"
                    type="file"
                    accept="image/*"
                    class="mt-2 w-full text-sm"
                />
                <p class="mt-1 text-xs text-slate-500">Choisis une image sur ton PC, puis elle sera uploadée automatiquement.</p>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-800">Aperçu</label>
                <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                    @php $fimg = $page->featured_image ?? ''; @endphp
                    <img
                        id="featuredImagePreview"
                        src="{{ (is_string($fimg) && trim($fimg) !== '') ? \App\Support\HomeView::url($fimg) : '' }}"
                        alt=""
                        class="h-40 w-full object-cover"
                        style="{{ (is_string($fimg) && trim($fimg) !== '') ? '' : 'display:none;' }}"
                    >
                    <div
                        id="featuredImagePlaceholder"
                        class="h-40 w-full bg-slate-50 {{ (is_string($fimg) && trim($fimg) !== '') ? 'hidden' : '' }}"
                    ></div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2 mt-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">Image Hero (Page service)</label>
                <input
                    id="heroImageUrl"
                    name="image"
                    value="{{ old('image', $page->image ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                />
                <input
                    id="heroImageFile"
                    type="file"
                    accept="image/*"
                    class="mt-2 w-full text-sm"
                />
                <p class="mt-1 text-xs text-slate-500">Choisis une image sur ton PC, puis elle sera uploadée automatiquement.</p>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-800">Aperçu</label>
                <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                    @php $img = $page->image ?? ''; @endphp
                    <img
                        id="heroImagePreview"
                        src="{{ (is_string($img) && trim($img) !== '') ? \App\Support\HomeView::url($img) : '' }}"
                        alt=""
                        class="h-40 w-full object-cover"
                        style="{{ (is_string($img) && trim($img) !== '') ? '' : 'display:none;' }}"
                    >
                    <div
                        id="heroImagePlaceholder"
                        class="h-40 w-full bg-slate-50 {{ (is_string($img) && trim($img) !== '') ? 'hidden' : '' }}"
                    ></div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">CTA texte</label>
                <input name="cta_text" value="{{ old('cta_text', $page->cta_text ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-800">CTA lien (href)</label>
                <input name="cta_href" value="{{ old('cta_href', $page->cta_href ?? '#devis') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
        </div>

        {{-- Chiffres (spécifiques au service) --}}
        @php
            $stats = is_array($page->service_stats ?? null) ? $page->service_stats : [];
            $statsItems = is_array(data_get($stats, 'items', [])) ? data_get($stats, 'items', []) : [];
        @endphp
        <div class="space-y-4 pt-2">
            <div>
                <h2 class="text-sm font-extrabold text-slate-900">Chiffres (service)</h2>
                <p class="mt-1 text-xs text-slate-500">Définis le titre (label) et la valeur (nombre/texte) affichés sur la page service. Minimum recommandé : <strong>3 chiffres clés</strong>.</p>
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        id="addStatItemBtn"
                        class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-sky-700"
                    >
                        + Ajouter un chiffre
                    </button>
                    <span id="statItemCount" class="text-xs font-semibold text-slate-500"></span>
                </div>
            </div>
            <div id="statItems" class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4 lg:grid-cols-3">
                @for ($s = 0; $s < 4; $s++)
                    @php
                        $item = is_array($statsItems) ? (data_get($statsItems, $s, []) ?: []) : [];
                        $labelVal = old("service_stats.items.$s.label", (string) data_get($item, 'label', ''));
                        $valueVal = old("service_stats.items.$s.value", (string) data_get($item, 'value', ''));
                        $textVal = old("service_stats.items.$s.text", (string) data_get($item, 'text', ''));
                        $hasStatContent = trim((string) $labelVal) !== '' || trim((string) $valueVal) !== '' || trim((string) $textVal) !== '';
                    @endphp
                    <div
                        class="js-stat-item rounded-xl border border-slate-200 bg-white p-4"
                        data-has-content="{{ $hasStatContent ? '1' : '0' }}"
                    >
                        <label class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Titre</label>
                        <input
                            name="service_stats[items][{{ $s }}][label]"
                            value="{{ $labelVal }}"
                            placeholder="Ex. Chantiers realises"
                            class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        />
                        <label class="mt-3 block text-xs font-extrabold uppercase tracking-wider text-slate-500">Nombre / Valeur</label>
                        <input
                            name="service_stats[items][{{ $s }}][value]"
                            value="{{ $valueVal }}"
                            placeholder="Ex. +250"
                            class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        />
                        <label class="mt-3 block text-xs font-extrabold uppercase tracking-wider text-slate-500">Texte (optionnel)</label>
                        <input
                            name="service_stats[items][{{ $s }}][text]"
                            value="{{ $textVal }}"
                            placeholder="Ex. sur les 24 derniers mois"
                            class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        />
                    </div>
                @endfor
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
            <h3 class="text-sm font-extrabold text-slate-900">Image de fond — carte « Un projet de rénovation ? »</h3>
            <p class="mt-1 text-xs text-slate-500">
                Photo affichée derrière la carte à droite (section avis + simulateur / contact), avec un dégradé pour la lisibilité du texte. Si vide, le site utilise <code class="rounded bg-white px-1">slide/toiture.png</code>.
            </p>
            <div class="mt-4 grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
                <div>
                    <label class="text-sm font-semibold text-slate-800">URL image</label>
                    <input
                        id="ctaCardBgUrl"
                        name="cta_card_background"
                        value="{{ old('cta_card_background', $page->cta_card_background ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Upload</label>
                    <input
                        id="ctaCardBgFile"
                        type="file"
                        accept="image/*"
                        data-url-target="ctaCardBgUrl"
                        data-preview-target="ctaCardBgPreview"
                        data-placeholder-target="ctaCardBgPlaceholder"
                        class="mt-2 w-full text-sm"
                    />
                </div>
            </div>
            <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-white">
                @php $ctaBg = old('cta_card_background', $page->cta_card_background ?? ''); @endphp
                <img
                    id="ctaCardBgPreview"
                    src="{{ (is_string($ctaBg) && trim($ctaBg) !== '') ? \App\Support\HomeView::url($ctaBg) : '' }}"
                    alt=""
                    class="h-36 w-full object-cover"
                    style="{{ (is_string($ctaBg) && trim($ctaBg) !== '') ? '' : 'display:none;' }}"
                >
                <div
                    id="ctaCardBgPlaceholder"
                    class="h-36 w-full bg-slate-100 {{ (is_string($ctaBg) && trim($ctaBg) !== '') ? 'hidden' : '' }}"
                ></div>
            </div>
        </div>

        {{-- Sous-services (6 à 9 cartes) --}}
        <div class="space-y-4 pt-2">
            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <h2 class="text-sm font-extrabold text-slate-900">Sous-services (6 à 9 cartes)</h2>
                <p class="mt-1 text-xs text-slate-500">Titre et texte d’introduction pour toute la section, puis pour chaque carte : titre, sous-titre, image et un ou plusieurs docs techniques (optionnel).</p>
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        id="addSubServiceBtn"
                        class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-sky-700"
                    >
                        + Ajouter un sous-service
                    </button>
                    <span id="subServiceCount" class="text-xs font-semibold text-slate-500"></span>
                </div>
            </div>

            <div class="grid gap-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Titre de la section (au-dessus des cartes)</label>
                    <input
                        name="sub_services_section_title"
                        value="{{ old('sub_services_section_title', $page->sub_services_section_title ?? '') }}"
                        placeholder="Ex. Sous prestations"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                    <p class="mt-1 text-xs text-slate-500">Sur le site, le premier mot sera en bleu (comme les autres titres), le reste en bleu nuit.</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Texte sous le titre (optionnel)</label>
                    <textarea
                        name="sub_services_section_intro"
                        rows="3"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    >{{ old('sub_services_section_intro', $page->sub_services_section_intro ?? '') }}</textarea>
                </div>
            </div>

            <div id="subServicesItems" class="space-y-4">
                @for ($i = 1; $i <= 9; $i++)
                    @php
                        $slot = is_array($subServices) ? (data_get($subServices, $i, []) ?: []) : [];
                        $sTitle = old('sub_services.'.$i.'.title', data_get($slot, 'title', ''));
                        $sSubtitle = old('sub_services.'.$i.'.subtitle', data_get($slot, 'subtitle', ''));
                        $sImage = old('sub_services.'.$i.'.image', data_get($slot, 'image', ''));
                        $sLegacyTechDoc = old('sub_services.'.$i.'.technical_doc', data_get($slot, 'technical_doc', ''));
                        $sTechDocsRaw = old('sub_services.'.$i.'.technical_docs', data_get($slot, 'technical_docs', []));
                        $sTechDocs = collect([
                            is_string($sLegacyTechDoc) ? trim($sLegacyTechDoc) : '',
                            ...collect(is_array($sTechDocsRaw) ? $sTechDocsRaw : [])
                                ->map(fn ($v) => trim((string) $v))
                                ->all(),
                        ])->filter(fn ($v) => $v !== '')
                            ->unique()
                            ->take(4)
                            ->values()
                            ->all();
                        $hasSubContent = trim((string) $sTitle) !== '' || trim((string) $sSubtitle) !== '' || trim((string) $sImage) !== '' || $sTechDocs !== [];
                    @endphp
                    <div
                        class="js-subservice-item rounded-xl border border-slate-200 bg-white p-4"
                        data-has-content="{{ $hasSubContent ? '1' : '0' }}"
                    >
                        <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.18em] text-slate-500">Carte {{ $i }}</p>
                        <div class="grid gap-4 lg:grid-cols-3 lg:items-start">
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Titre carte {{ $i }}</label>
                                    <input
                                        name="sub_services[{{ $i }}][title]"
                                        value="{{ $sTitle }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Sous-titre carte {{ $i }}</label>
                                    <textarea
                                        name="sub_services[{{ $i }}][subtitle]"
                                        rows="2"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >{{ $sSubtitle }}</textarea>
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="grid gap-3 sm:grid-cols-[1fr_auto] sm:items-end">
                                    <div>
                                        <label class="text-sm font-semibold text-slate-800">Image (URL stockée)</label>
                                        <input
                                            id="subService{{ $i }}ImageUrl"
                                            name="sub_services[{{ $i }}][image]"
                                            value="{{ $sImage }}"
                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                        />
                                    </div>

                                    <div>
                                        <label class="text-sm font-semibold text-slate-800">Upload</label>
                                        <input
                                            id="subService{{ $i }}ImageFile"
                                            type="file"
                                            accept="image/*"
                                            data-url-target="subService{{ $i }}ImageUrl"
                                            data-preview-target="subService{{ $i }}ImagePreview"
                                            data-placeholder-target="subService{{ $i }}ImagePlaceholder"
                                            class="mt-2 w-full text-sm"
                                        />
                                    </div>
                                </div>

                                <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                    <img
                                        id="subService{{ $i }}ImagePreview"
                                        src="{{ (is_string($sImage) && trim($sImage) !== '') ? \App\Support\HomeView::url($sImage) : '' }}"
                                        alt=""
                                        class="h-28 w-full object-cover"
                                        style="{{ (is_string($sImage) && trim($sImage) !== '') ? '' : 'display:none;' }}"
                                    >
                                    <div
                                        id="subService{{ $i }}ImagePlaceholder"
                                        class="h-28 w-full bg-slate-50 {{ (is_string($sImage) && trim($sImage) !== '') ? 'hidden' : '' }}"
                                    ></div>
                                </div>

                                <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50/70 p-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-slate-500">Docs techniques</p>
                                        <button
                                            type="button"
                                            id="addSubService{{ $i }}TechnicalDocBtn"
                                            class="inline-flex items-center rounded-lg bg-sky-600 px-2.5 py-1.5 text-[11px] font-extrabold text-white hover:bg-sky-700"
                                        >
                                            + Ajouter un doc
                                        </button>
                                        <span id="subService{{ $i }}TechnicalDocCount" class="text-[11px] font-semibold text-slate-500"></span>
                                    </div>

                                    <div class="mt-3 grid gap-3">
                                        @for ($d = 0; $d < 4; $d++)
                                            @php
                                                $sTechDocVal = (string) ($sTechDocs[$d] ?? '');
                                                $hasDoc = trim($sTechDocVal) !== '';
                                            @endphp
                                            <div class="js-subservice-doc-item-{{ $i }} rounded-lg border border-slate-200 bg-white p-3" data-has-content="{{ $hasDoc ? '1' : '0' }}">
                                                <div class="grid gap-3 sm:grid-cols-[1fr_auto] sm:items-end">
                                                    <div>
                                                        <label class="text-sm font-semibold text-slate-800">Doc technique {{ $d + 1 }} (PDF / image)</label>
                                                        <input
                                                            id="subService{{ $i }}TechnicalDoc{{ $d }}Url"
                                                            name="sub_services[{{ $i }}][technical_docs][{{ $d }}]"
                                                            value="{{ $sTechDocVal }}"
                                                            placeholder="/uploads/docs/fiche-technique.pdf"
                                                            class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                                        />
                                                        @if ($hasDoc)
                                                            <a href="{{ \App\Support\HomeView::url($sTechDocVal) }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex text-xs font-extrabold text-sky-700 hover:underline">
                                                                Ouvrir le doc {{ $d + 1 }} ↗
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <label class="text-sm font-semibold text-slate-800">Upload doc</label>
                                                        <input
                                                            id="subService{{ $i }}TechnicalDoc{{ $d }}File"
                                                            type="file"
                                                            accept="application/pdf,image/jpeg,image/png,image/webp"
                                                            data-url-target="subService{{ $i }}TechnicalDoc{{ $d }}Url"
                                                            data-preview-target=""
                                                            data-placeholder-target=""
                                                            class="mt-2 w-full text-sm"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Réalisations avant / après (comparateur) --}}
        <div class="space-y-4 pt-6">
            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <h2 class="text-sm font-extrabold text-slate-900">Réalisations (avant / après)</h2>
                <p class="mt-1 text-xs text-slate-500">Ajoute les photos. Elles seront affichées dans la section “Réalisations” de la page service.</p>
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        id="addRealisationBtn"
                        class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-sky-700"
                    >
                        + Ajouter une réalisation
                    </button>
                    <span id="realisationCount" class="text-xs font-semibold text-slate-500"></span>
                </div>
            </div>

            <div id="realisationsItems" class="space-y-4">
                @for ($j = 1; $j <= 6; $j++)
                    @php
                        $rSlot = is_array($realisations) ? (data_get($realisations, $j, []) ?: []) : [];
                        $rLabel = old('realisations.'.$j.'.label', data_get($rSlot, 'label', ''));
                        $before = old('realisations.'.$j.'.before', data_get($rSlot, 'before', ''));
                        $after = old('realisations.'.$j.'.after', data_get($rSlot, 'after', ''));
                        $hasRealContent = trim((string) $rLabel) !== '' || trim((string) $before) !== '' || trim((string) $after) !== '';
                    @endphp
                    <div
                        class="js-realisation-item rounded-xl border border-slate-200 bg-white p-4"
                        data-has-content="{{ $hasRealContent ? '1' : '0' }}"
                    >
                        <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.18em] text-slate-500">Réalisation {{ $j }}</p>
                        <div class="grid gap-4 lg:grid-cols-2 lg:items-start">
                            <div>
                                <label class="text-sm font-semibold text-slate-800">Label du bouton (cas {{ $j }})</label>
                                <input
                                    name="realisations[{{ $j }}][label]"
                                    value="{{ $rLabel }}"
                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                />
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Avant (URL)</label>
                                    <input
                                        id="realBefore{{ $j }}Url"
                                        name="realisations[{{ $j }}][before]"
                                        value="{{ $before }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    />
                                    <input
                                        id="realBefore{{ $j }}File"
                                        type="file"
                                        accept="image/*"
                                        data-url-target="realBefore{{ $j }}Url"
                                        data-preview-target="realBefore{{ $j }}Preview"
                                        data-placeholder-target="realBefore{{ $j }}Placeholder"
                                        class="mt-2 w-full text-sm"
                                    />
                                    <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                        <img
                                            id="realBefore{{ $j }}Preview"
                                            src="{{ (is_string($before) && trim($before) !== '') ? \App\Support\HomeView::url($before) : '' }}"
                                            alt=""
                                            class="h-28 w-full object-cover"
                                            style="{{ (is_string($before) && trim($before) !== '') ? '' : 'display:none;' }}"
                                        >
                                        <div
                                            id="realBefore{{ $j }}Placeholder"
                                            class="h-28 w-full bg-slate-50 {{ (is_string($before) && trim($before) !== '') ? 'hidden' : '' }}"
                                        ></div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Après (URL)</label>
                                    <input
                                        id="realAfter{{ $j }}Url"
                                        name="realisations[{{ $j }}][after]"
                                        value="{{ $after }}"
                                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    />
                                    <input
                                        id="realAfter{{ $j }}File"
                                        type="file"
                                        accept="image/*"
                                        data-url-target="realAfter{{ $j }}Url"
                                        data-preview-target="realAfter{{ $j }}Preview"
                                        data-placeholder-target="realAfter{{ $j }}Placeholder"
                                        class="mt-2 w-full text-sm"
                                    />
                                    <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                        <img
                                            id="realAfter{{ $j }}Preview"
                                            src="{{ (is_string($after) && trim($after) !== '') ? \App\Support\HomeView::url($after) : '' }}"
                                            alt=""
                                            class="h-28 w-full object-cover"
                                            style="{{ (is_string($after) && trim($after) !== '') ? '' : 'display:none;' }}"
                                        >
                                        <div
                                            id="realAfter{{ $j }}Placeholder"
                                            class="h-28 w-full bg-slate-50 {{ (is_string($after) && trim($after) !== '') ? 'hidden' : '' }}"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Partenaires associés au service --}}
        @php
            $sp = is_array($page->service_partners ?? null) ? $page->service_partners : [];
            $spPhrase = old('service_partners.phrase', (string) data_get($sp, 'phrase', ''));
            $spLogos = is_array(data_get($sp, 'logos', [])) ? data_get($sp, 'logos', []) : [];
        @endphp
        <div class="space-y-4 pt-6">
            <div>
                <h2 class="text-sm font-extrabold text-slate-900">Partenaires associés</h2>
                <p class="mt-1 text-xs text-slate-500">Logos + phrase (spécifiques à ce service). Si vide, rien ne s’affiche sur la page publique.</p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <label class="text-sm font-semibold text-slate-800">Phrase</label>
                <textarea
                    name="service_partners[phrase]"
                    rows="2"
                    placeholder="Ex. Partenaires et fabricants sélectionnés selon votre couverture et votre région."
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                >{{ $spPhrase }}</textarea>
            </div>

            <div class="grid gap-4">
                <div class="flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        id="addPartnerLogoBtn"
                        class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-sky-700"
                    >
                        + Ajouter un logo
                    </button>
                    <span id="partnerLogoCount" class="text-xs font-semibold text-slate-500"></span>
                </div>
                @for ($k = 1; $k <= 6; $k++)
                    @php
                        $logoVal = old('service_partners.logos.'.$k, (string) data_get($spLogos, $k, ''));
                        $hasLogoContent = trim((string) $logoVal) !== '';
                    @endphp
                    <div
                        class="js-partner-logo-item rounded-xl border border-slate-200 bg-white p-4"
                        data-has-content="{{ $hasLogoContent ? '1' : '0' }}"
                    >
                        <div class="grid gap-3 sm:grid-cols-[1fr_auto] sm:items-end">
                            <div>
                                <label class="text-sm font-semibold text-slate-800">Logo {{ $k }} (URL)</label>
                                <input
                                    id="servicePartnerLogo{{ $k }}Url"
                                    name="service_partners[logos][{{ $k }}]"
                                    value="{{ $logoVal }}"
                                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                />
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-800">Upload</label>
                                <input
                                    id="servicePartnerLogo{{ $k }}File"
                                    type="file"
                                    accept="image/*"
                                    data-url-target="servicePartnerLogo{{ $k }}Url"
                                    data-preview-target="servicePartnerLogo{{ $k }}Preview"
                                    data-placeholder-target="servicePartnerLogo{{ $k }}Placeholder"
                                    class="mt-2 w-full text-sm"
                                />
                            </div>
                        </div>
                        <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <img
                                id="servicePartnerLogo{{ $k }}Preview"
                                src="{{ (is_string($logoVal) && trim($logoVal) !== '') ? \App\Support\HomeView::url($logoVal) : '' }}"
                                alt=""
                                class="h-24 w-full object-contain p-3"
                                style="{{ (is_string($logoVal) && trim($logoVal) !== '') ? '' : 'display:none;' }}"
                            >
                            <div
                                id="servicePartnerLogo{{ $k }}Placeholder"
                                class="h-24 w-full bg-slate-50 {{ (is_string($logoVal) && trim($logoVal) !== '') ? 'hidden' : '' }}"
                            ></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3">
            <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600" {{ (old('is_active', $page->is_active ?? true)) ? 'checked' : '' }}>
            <span class="text-sm font-semibold text-slate-800">Page active</span>
        </label>

        <div class="flex flex-wrap items-center gap-3 pt-2">
            <button class="rounded-xl bg-sky-600 px-6 py-2.5 text-sm font-extrabold text-white hover:bg-sky-700" type="submit">
                Enregistrer
            </button>
        </div>
    </form>

    <script>
        (function () {
            const uploadUrl = @json(route('admin.upload'));
            const csrfToken = @json(csrf_token());
            const aiGenerateUrl = @json(route('admin.services_pages.generate_ai'));

                function showPreviewFromLocalFile({ file, previewImg, placeholderDiv }) {
                    try {
                        const reader = new FileReader();
                        reader.onload = function () {
                            if (previewImg) {
                                previewImg.src = String(reader.result || '');
                                previewImg.style.display = 'block';
                            }
                            if (placeholderDiv) {
                                placeholderDiv.classList.add('hidden');
                            }
                        };
                        reader.readAsDataURL(file);
                    } catch (e) {
                        // ignore (preview only)
                    }
                }

            async function uploadAndSet({ fileInput, urlInput, previewImg, placeholderDiv }) {
                if (!fileInput || !urlInput) return;
                const file = fileInput.files && fileInput.files[0];
                if (!file) return;

                    // Preview instant (avant upload) pour éviter "aperçu qui ne s'affiche pas".
                    if (previewImg && placeholderDiv) {
                        showPreviewFromLocalFile({ file, previewImg, placeholderDiv });
                    }

                const fd = new FormData();
                fd.append('file', file);

                try {
                    const res = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        body: fd,
                        credentials: 'same-origin'
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Erreur upload');
                    const url = data.url;
                    if (!url) throw new Error('URL upload manquante');

                    urlInput.value = url;
                    if (previewImg && placeholderDiv) {
                        previewImg.src = url;
                        previewImg.style.display = 'block';
                        placeholderDiv.classList.add('hidden');
                    }
                } catch (err) {
                    alert(String(err));
                } finally {
                    fileInput.value = '';
                }
            }

            const featuredFile = document.getElementById('featuredImageFile');
            const featuredUrl = document.getElementById('featuredImageUrl');
            const featuredPreview = document.getElementById('featuredImagePreview');
            const featuredPlaceholder = document.getElementById('featuredImagePlaceholder');

            const heroFile = document.getElementById('heroImageFile');
            const heroUrl = document.getElementById('heroImageUrl');
            const heroPreview = document.getElementById('heroImagePreview');
            const heroPlaceholder = document.getElementById('heroImagePlaceholder');

            // Fallback: si l'input URL est déjà rempli (édition), on force l'affichage.
            try {
                if (featuredUrl && featuredPreview && featuredPlaceholder && String(featuredUrl.value || '').trim() !== '') {
                    featuredPreview.src = featuredUrl.value;
                    featuredPreview.style.display = 'block';
                    featuredPlaceholder.classList.add('hidden');
                }
                if (heroUrl && heroPreview && heroPlaceholder && String(heroUrl.value || '').trim() !== '') {
                    heroPreview.src = heroUrl.value;
                    heroPreview.style.display = 'block';
                    heroPlaceholder.classList.add('hidden');
                }
            } catch (e) {
                // ignore
            }

            if (featuredFile) {
                featuredFile.addEventListener('change', function () {
                    uploadAndSet({
                        fileInput: featuredFile,
                        urlInput: featuredUrl,
                        previewImg: featuredPreview,
                        placeholderDiv: featuredPlaceholder,
                    });
                });
            }

            if (heroFile) {
                heroFile.addEventListener('change', function () {
                    uploadAndSet({
                        fileInput: heroFile,
                        urlInput: heroUrl,
                        previewImg: heroPreview,
                        placeholderDiv: heroPlaceholder,
                    });
                });
            }

            // Uploads additionnels (sous-services + réalisations)
            const extraFileInputs = document.querySelectorAll('input[type="file"][data-url-target][data-preview-target][data-placeholder-target]');
            extraFileInputs.forEach(function (fileInput) {
                const urlInput = document.getElementById(fileInput.dataset.urlTarget);
                const previewImg = fileInput.dataset.previewTarget ? document.getElementById(fileInput.dataset.previewTarget) : null;
                const placeholderDiv = fileInput.dataset.placeholderTarget ? document.getElementById(fileInput.dataset.placeholderTarget) : null;

                if (!urlInput) return;

                // Fallback édition : si l'URL est déjà présente, forcer l'affichage.
                try {
                    if (previewImg && placeholderDiv && String(urlInput.value || '').trim() !== '') {
                        previewImg.src = urlInput.value;
                        previewImg.style.display = 'block';
                        placeholderDiv.classList.add('hidden');
                    }
                } catch (e) {
                    // ignore
                }

                fileInput.addEventListener('change', function () {
                    uploadAndSet({
                        fileInput: fileInput,
                        urlInput: urlInput,
                        previewImg: previewImg,
                        placeholderDiv: placeholderDiv,
                    });
                });
            });

            function initProgressiveList({ itemSelector, addBtnId, countId, minVisible }) {
                const items = Array.from(document.querySelectorAll(itemSelector));
                if (items.length === 0) return;

                const addBtn = document.getElementById(addBtnId);
                const count = document.getElementById(countId);
                const filled = items.filter((item) => item.dataset.hasContent === '1').length;
                let visible = Math.max(minVisible || 1, filled || 0);
                visible = Math.min(visible, items.length);

                const render = () => {
                    items.forEach((item, idx) => {
                        item.style.display = idx < visible ? '' : 'none';
                    });
                    if (count) {
                        count.textContent = visible + ' / ' + items.length;
                    }
                    if (addBtn) {
                        addBtn.disabled = visible >= items.length;
                        addBtn.classList.toggle('opacity-50', visible >= items.length);
                        addBtn.classList.toggle('cursor-not-allowed', visible >= items.length);
                    }
                };

                if (addBtn) {
                    addBtn.addEventListener('click', function () {
                        if (visible < items.length) {
                            visible += 1;
                            render();
                        }
                    });
                }

                render();
            }

            initProgressiveList({
                itemSelector: '.js-subservice-item',
                addBtnId: 'addSubServiceBtn',
                countId: 'subServiceCount',
                minVisible: 1,
            });
            @for ($i = 1; $i <= 9; $i++)
            initProgressiveList({
                itemSelector: '.js-subservice-doc-item-{{ $i }}',
                addBtnId: 'addSubService{{ $i }}TechnicalDocBtn',
                countId: 'subService{{ $i }}TechnicalDocCount',
                minVisible: 1,
            });
            @endfor
            initProgressiveList({
                itemSelector: '.js-realisation-item',
                addBtnId: 'addRealisationBtn',
                countId: 'realisationCount',
                minVisible: 1,
            });
            initProgressiveList({
                itemSelector: '.js-partner-logo-item',
                addBtnId: 'addPartnerLogoBtn',
                countId: 'partnerLogoCount',
                minVisible: 1,
            });
            initProgressiveList({
                itemSelector: '.js-stat-item',
                addBtnId: 'addStatItemBtn',
                countId: 'statItemCount',
                minVisible: 3,
            });

            // Compteurs caractères SEO (meta)
            function bindCount({ input, counter, softMax }) {
                if (!input || !counter) return;
                const update = () => {
                    const v = String(input.value || '');
                    const n = v.length;
                    counter.textContent = n + ' / ' + softMax;
                    counter.classList.toggle('text-amber-600', n > softMax);
                };
                input.addEventListener('input', update);
                update();
            }

            bindCount({ input: document.getElementById('metaTitleInput'), counter: document.getElementById('metaTitleCount'), softMax: 60 });
            bindCount({ input: document.getElementById('metaDescriptionInput'), counter: document.getElementById('metaDescriptionCount'), softMax: 160 });
            bindCount({ input: document.getElementById('metaKeywordsInput'), counter: document.getElementById('metaKeywordsCount'), softMax: 200 });

            const aiBtn = document.getElementById('aiGenerateBtn');
            const aiTitle = document.getElementById('aiSourceTitle');
            const aiDescription = document.getElementById('aiSourceDescription');
            const aiStatus = document.getElementById('aiGenerateStatus');

            function setField(name, value) {
                const el = document.querySelector('[name="' + name.replaceAll('"', '\\"') + '"]');
                if (!el) return;
                el.value = value ?? '';
                el.dispatchEvent(new Event('input', { bubbles: true }));
            }

            function fillGenerated(g) {
                setField('slug', g.slug || '');
                setField('service_num', g.service_num || '');
                setField('meta_title', g.meta_title || '');
                setField('meta_keywords', g.meta_keywords || '');
                setField('meta_description', g.meta_description || '');
                setField('title', g.title || '');
                setField('subtitle', g.subtitle || '');
                setField('intro', g.intro || '');
                setField('body', g.body || '');
                setField('sub_services_section_title', g.sub_services_section_title || '');
                setField('sub_services_section_intro', g.sub_services_section_intro || '');

                for (let i = 1; i <= 9; i++) {
                    const item = Array.isArray(g.sub_services) ? (g.sub_services[i - 1] || {}) : {};
                    setField(`sub_services[${i}][title]`, item.title || '');
                    setField(`sub_services[${i}][subtitle]`, item.subtitle || '');
                }

                setField('content_overrides[intro][kicker]', g?.content_overrides?.intro?.kicker || '');
                setField('content_overrides[intro][badges][0]', g?.content_overrides?.intro?.badges?.[0] || '');
                setField('content_overrides[intro][badges][1]', g?.content_overrides?.intro?.badges?.[1] || '');
                setField('content_overrides[intro][badges][2]', g?.content_overrides?.intro?.badges?.[2] || '');

                setField('content_overrides[subnav][services]', g?.content_overrides?.subnav?.services || 'Services');
                setField('content_overrides[subnav][realisations]', g?.content_overrides?.subnav?.realisations || 'Réalisations');
                setField('content_overrides[subnav][avis]', g?.content_overrides?.subnav?.avis || 'Avis');
                setField('content_overrides[subnav][contact]', g?.content_overrides?.subnav?.contact || 'Contact');

                setField('content_overrides[partners][heading]', g?.content_overrides?.partners?.heading || 'Partenaires associés');
                setField('content_overrides[partners][link_text]', g?.content_overrides?.partners?.link_text || 'Nous contacter');

                setField('content_overrides[realisations][title_accent]', g?.content_overrides?.realisations?.title_accent || 'Réalisations');
                setField('content_overrides[realisations][title_rest]', g?.content_overrides?.realisations?.title_rest || 'avant / après');
                setField('content_overrides[realisations][intro]', g?.content_overrides?.realisations?.intro || '');

                setField('content_overrides[sub_services][cta_text]', g?.content_overrides?.sub_services?.cta_text || 'C’EST CE QU’IL ME FAUT');
                setField('content_overrides[sub_services][doc_text]', g?.content_overrides?.sub_services?.doc_text || 'DOC TECHNIQUE');

                const steps = g?.content_overrides?.process?.steps || [];
                for (let i = 0; i < 4; i++) {
                    const step = steps[i] || {};
                    setField(`content_overrides[process][steps][${i}][num]`, step.num || String(i + 1));
                    setField(`content_overrides[process][steps][${i}][title]`, step.title || '');
                    setField(`content_overrides[process][steps][${i}][text]`, step.text || '');
                }

                const stats = g?.service_stats?.items || [];
                for (let i = 0; i < 4; i++) {
                    const st = stats[i] || {};
                    setField(`service_stats[items][${i}][label]`, st.label || '');
                    setField(`service_stats[items][${i}][value]`, st.value || '');
                    setField(`service_stats[items][${i}][text]`, st.text || '');
                }

                if (typeof tinymce !== 'undefined' && tinymce.get('serviceBodyEditor')) {
                    tinymce.get('serviceBodyEditor').setContent(g.body || '');
                }
            }

            if (aiBtn && aiTitle && aiDescription && aiStatus) {
                aiBtn.addEventListener('click', async function () {
                    const title = String(aiTitle.value || '').trim();
                    const description = String(aiDescription.value || '').trim();
                    if (!title || !description) {
                        aiStatus.textContent = 'Renseigne un titre et une description courte.';
                        aiStatus.classList.add('text-red-600');
                        return;
                    }

                    aiBtn.disabled = true;
                    aiStatus.textContent = 'Génération IA en cours...';
                    aiStatus.classList.remove('text-red-600');
                    try {
                        const res = await fetch(aiGenerateUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ title, description }),
                            credentials: 'same-origin',
                        });
                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) {
                            throw new Error(json.message || 'Erreur IA');
                        }
                        fillGenerated(json.generated || {});
                        aiStatus.textContent = 'Contenu généré avec succès. Pense à vérifier avant enregistrement.';
                    } catch (e) {
                        aiStatus.textContent = String(e.message || e || 'Erreur IA');
                        aiStatus.classList.add('text-red-600');
                    } finally {
                        aiBtn.disabled = false;
                    }
                });
            }
        })();
    </script>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.4/tinymce.min.js" referrerpolicy="origin"></script>
<script>
(function () {
    const el = document.getElementById('serviceBodyEditor');
    if (!el || typeof tinymce === 'undefined') return;

    const form = el.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            try { tinymce.triggerSave(); } catch (e) {}
        });
    }

    tinymce.init({
        selector: '#serviceBodyEditor',
        height: 440,
        menubar: false,
        branding: false,
        promotion: false,
        license_key: 'gpl',
        plugins: 'lists link autoresize code',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignjustify | bullist numlist | link | removeformat | code',
        block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3',
        content_style: 'body{font-family:ui-sans-serif,system-ui,sans-serif;font-size:14px;line-height:1.65;}',
        paste_as_text: false,
        entity_encoding: 'raw',
        convert_urls: false,
    });
})();
</script>
@endpush

