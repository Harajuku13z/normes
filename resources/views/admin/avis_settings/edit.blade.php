@php
    $a = is_array($avis ?? null) ? $avis : [];
    $testimonials = is_array(data_get($a, 'testimonials')) ? data_get($a, 'testimonials') : [];
@endphp

@extends('admin.layout')

@section('title', 'Avis — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Avis</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Gérez la section Avis utilisée sur l’accueil et les pages qui réutilisent ce bloc.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Retour
        </a>
    </div>

    <div class="mb-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-sm font-extrabold text-slate-900">Télécharger les avis Google (SerAPI)</h2>
        <p class="mt-1 text-xs text-slate-500">Configurez d’abord API key + place_id, puis cliquez : seuls les nouveaux avis Google sont ajoutés (pas de doublons).</p>
        <form method="post" action="{{ route('admin.avis_settings.fetch_google') }}" class="mt-4 flex flex-wrap items-end gap-3">
            @csrf
            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-600">Nombre max de nouveaux avis</label>
                <input type="number" min="1" max="200" name="max_reviews" value="200" class="w-36 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
            <button type="submit" class="inline-flex items-center rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-extrabold text-white hover:bg-sky-700">
                Télécharger les avis Google
            </button>
        </form>
    </div>

    <form method="post" action="{{ route('admin.avis_settings.update') }}" class="space-y-5">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-extrabold text-slate-900">Textes de la section</h2>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Kicker</label>
                    <input name="avis[kicker]" value="{{ old('avis.kicker', data_get($a, 'kicker', 'Avis multi-plateformes')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Texte info plateformes</label>
                    <input name="avis[platform_info]" value="{{ old('avis.platform_info', data_get($a, 'platform_info', 'Des retours concrets, provenant de plusieurs plateformes.')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Titre partie couleur</label>
                    <input name="avis[title_accent]" value="{{ old('avis.title_accent', data_get($a, 'title_accent', 'Ce que nos clients pensent de nous')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Titre partie normale</label>
                    <input name="avis[title_rest]" value="{{ old('avis.title_rest', data_get($a, 'title_rest', ': avis client')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
            </div>
            <div class="mt-4">
                <label class="text-sm font-semibold text-slate-800">Intro</label>
                <textarea name="avis[intro]" rows="2" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('avis.intro', data_get($a, 'intro', '')) }}</textarea>
            </div>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">URL fiche Google</label>
                    <input name="avis[google_url]" value="{{ old('avis.google_url', data_get($a, 'google_url', '#')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Texte bouton Google</label>
                    <input name="avis[google_button]" value="{{ old('avis.google_button', data_get($a, 'google_button', 'Voir la fiche')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-extrabold text-slate-900">SerAPI</h2>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">API key</label>
                    <input name="avis[serapi][api_key]" value="{{ old('avis.serapi.api_key', data_get($a, 'serapi.api_key', '')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Google place_id</label>
                    <input name="avis[serapi][place_id]" value="{{ old('avis.serapi.place_id', data_get($a, 'serapi.place_id', '')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Engine</label>
                    <input name="avis[serapi][engine]" value="{{ old('avis.serapi.engine', data_get($a, 'serapi.engine', 'google_maps_reviews')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Dernière sync</label>
                    <input name="avis[serapi][last_sync]" value="{{ old('avis.serapi.last_sync', data_get($a, 'serapi.last_sync', '')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600" />
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-3 flex items-center justify-between gap-3">
                <h2 class="text-sm font-extrabold text-slate-900">Avis manuels (autres plateformes)</h2>
                <button id="addAvisBtn" type="button" class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-sky-700">
                    + Ajouter un avis
                </button>
            </div>
            <div id="avisCount" class="mb-3 text-xs font-semibold text-slate-500"></div>
            <div id="avisItems" class="grid gap-3 lg:grid-cols-2">
                @for ($i = 0; $i < 12; $i++)
                    @php
                        $it = is_array($testimonials) ? (data_get($testimonials, $i, []) ?: []) : [];
                        $hasContent = trim((string) data_get($it, 'platform', '')) !== ''
                            || trim((string) data_get($it, 'text', '')) !== ''
                            || trim((string) data_get($it, 'author', '')) !== '';
                    @endphp
                    <div class="js-avis-item rounded-lg border border-slate-200 bg-slate-50/70 p-3" data-has-content="{{ $hasContent ? '1' : '0' }}">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Avis {{ $i + 1 }}</p>
                        <div class="mt-2 grid gap-2 lg:grid-cols-2">
                            <input name="avis[testimonials][{{ $i }}][platform]" value="{{ old("avis.testimonials.$i.platform", data_get($it, 'platform', 'google')) }}" placeholder="Plateforme" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            <input name="avis[testimonials][{{ $i }}][review_count]" value="{{ old("avis.testimonials.$i.review_count", data_get($it, 'review_count', '+100 avis')) }}" placeholder="Ex. +100 avis" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                        </div>
                        <textarea name="avis[testimonials][{{ $i }}][text]" rows="2" placeholder="Texte avis" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old("avis.testimonials.$i.text", data_get($it, 'text', '')) }}</textarea>
                        <input name="avis[testimonials][{{ $i }}][author]" value="{{ old("avis.testimonials.$i.author", data_get($it, 'author', '')) }}" placeholder="Auteur" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    </div>
                @endfor
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        (function () {
            const items = Array.from(document.querySelectorAll('.js-avis-item'));
            const addBtn = document.getElementById('addAvisBtn');
            const count = document.getElementById('avisCount');
            let visible = Math.max(1, items.filter((it) => it.dataset.hasContent === '1').length);
            visible = Math.min(visible, items.length);

            const render = () => {
                items.forEach((it, idx) => { it.style.display = idx < visible ? '' : 'none'; });
                if (count) count.textContent = visible + ' / ' + items.length;
                if (addBtn) {
                    addBtn.disabled = visible >= items.length;
                    addBtn.classList.toggle('opacity-50', visible >= items.length);
                    addBtn.classList.toggle('cursor-not-allowed', visible >= items.length);
                }
            };

            addBtn?.addEventListener('click', () => {
                if (visible < items.length) {
                    visible += 1;
                    render();
                }
            });

            render();
        })();
    </script>
    @endpush
@endsection
