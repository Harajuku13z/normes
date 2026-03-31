@php
    $activeRoute = request()->route() ? request()->route()->getName() : null;
@endphp

@extends('admin.layout')

@section('title', 'Homepage — Admin')

@section('content')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Homepage</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Modifiez les blocs de la page d’accueil via des formulaires. Les valeurs sont enregistrées dans `home_sections`.
            </p>
        </div>
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Retour
            </a>
        </div>
    </div>

    <form method="post" action="{{ route('admin.homepage.update') }}" class="mt-8 space-y-6">
        @csrf

        <div class="flex flex-col gap-4">
            @foreach ($keys as $key)
                @if ($key === 'avis')
                    @continue
                @endif
                @php
                    $value = $merged[$key] ?? [];
                    $label = $labels[$key] ?? $key;
                @endphp
                <details id="section-{{ $key }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <summary class="cursor-pointer select-none">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-extrabold text-slate-900">{{ $label }}</p>
                                <p class="mt-1 text-xs font-mono text-slate-500">{{ $key }}</p>
                            </div>
                        </div>
                    </summary>

                    <div class="mt-4">
                        @include('admin.homepage.partials.form', [
                            'name' => "sections[{$key}]",
                            'value' => $value,
                            'depth' => 0
                        ])
                    </div>
                </details>
            @endforeach
        </div>

        @php
            $avis = is_array($merged['avis'] ?? null) ? $merged['avis'] : [];
            $avisTestimonials = is_array(data_get($avis, 'testimonials')) ? data_get($avis, 'testimonials') : [];
            $avisSerapi = is_array(data_get($avis, 'serapi')) ? data_get($avis, 'serapi') : [];
        @endphp
        <div id="avis-settings" class="scroll-mt-24 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4">
                <h2 class="text-sm font-extrabold text-slate-900">Onglet Avis (accueil + pages)</h2>
                <p class="mt-1 text-xs text-slate-500">Cette configuration alimente la section avis de la homepage et des pages service/contact qui réutilisent le même bloc.</p>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Textes section avis</p>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Kicker</label>
                    <input name="sections[avis][kicker]" value="{{ old('sections.avis.kicker', data_get($avis, 'kicker', 'Avis multi-plateformes')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Titre (partie couleur)</label>
                    <input name="sections[avis][title_accent]" value="{{ old('sections.avis.title_accent', data_get($avis, 'title_accent', 'Avis')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Titre (partie non couleur)</label>
                    <input name="sections[avis][title_rest]" value="{{ old('sections.avis.title_rest', data_get($avis, 'title_rest', 'clients')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Intro</label>
                    <textarea name="sections[avis][intro]" rows="2" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('sections.avis.intro', data_get($avis, 'intro', '')) }}</textarea>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Bouton Google</label>
                    <input name="sections[avis][google_button]" value="{{ old('sections.avis.google_button', data_get($avis, 'google_button', 'Voir la fiche')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">URL fiche Google</label>
                    <input name="sections[avis][google_url]" value="{{ old('sections.avis.google_url', data_get($avis, 'google_url', '#')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">SerAPI (préparation)</p>
                    <p class="mt-2 text-xs text-slate-500">Ajoutez ici vos infos SerAPI. La récupération auto sera branchée ensuite.</p>
                    <label class="mt-3 block text-sm font-semibold text-slate-800">API key</label>
                    <input name="sections[avis][serapi][api_key]" value="{{ old('sections.avis.serapi.api_key', data_get($avisSerapi, 'api_key', '')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Google place_id</label>
                    <input name="sections[avis][serapi][place_id]" value="{{ old('sections.avis.serapi.place_id', data_get($avisSerapi, 'place_id', '')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Engine</label>
                    <input name="sections[avis][serapi][engine]" value="{{ old('sections.avis.serapi.engine', data_get($avisSerapi, 'engine', 'google_maps_reviews')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <label class="mt-3 block text-sm font-semibold text-slate-800">Dernière sync (info)</label>
                    <input name="sections[avis][serapi][last_sync]" value="{{ old('sections.avis.serapi.last_sync', data_get($avisSerapi, 'last_sync', '')) }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
            </div>

            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Avis (cards carousel)</p>
                    <span class="text-xs font-semibold text-slate-500">Jusqu’à 8 avis</span>
                </div>
                <div class="grid gap-3 lg:grid-cols-2">
                    @for ($i = 0; $i < 8; $i++)
                        @php $it = is_array($avisTestimonials) ? (data_get($avisTestimonials, $i, []) ?: []) : []; @endphp
                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Avis {{ $i + 1 }}</p>
                            <div class="mt-2 grid gap-2 lg:grid-cols-2">
                                <input name="sections[avis][testimonials][{{ $i }}][platform]" value="{{ old("sections.avis.testimonials.$i.platform", data_get($it, 'platform', 'google')) }}" placeholder="Plateforme" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                                <input name="sections[avis][testimonials][{{ $i }}][review_count]" value="{{ old("sections.avis.testimonials.$i.review_count", data_get($it, 'review_count', '+100 avis')) }}" placeholder="Ex. +100 avis" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            </div>
                            <textarea name="sections[avis][testimonials][{{ $i }}][text]" rows="2" placeholder="Texte avis" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old("sections.avis.testimonials.$i.text", data_get($it, 'text', '')) }}</textarea>
                            <input name="sections[avis][testimonials][{{ $i }}][author]" value="{{ old("sections.avis.testimonials.$i.author", data_get($it, 'author', '')) }}" placeholder="Auteur" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer
            </button>
        </div>
    </form>

    <script>
        (function () {
            const uploadUrl = @json(route('admin.upload'));
            const csrfToken = @json(csrf_token());

            const openHashSection = () => {
                const hash = window.location.hash || '';
                if (!hash.startsWith('#section-')) return;
                const target = document.querySelector(hash);
                if (!(target instanceof HTMLDetailsElement)) return;
                target.open = true;
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            };
            openHashSection();

            function setPreview(previewId, url) {
                const img = document.getElementById(previewId);
                if (!img) return;
                img.src = url;
                img.style.display = 'block';
            }

            document.addEventListener('change', async (e) => {
                const input = e.target;
                if (!input) return;
                if (input.type !== 'file') return;
                const uploadTargetInputId = input.dataset.uploadTargetInputId;
                const uploadTargetPreviewId = input.dataset.uploadTargetPreviewId;
                if (!uploadTargetInputId) return;

                const file = input.files && input.files[0];
                if (!file) return;

                const fd = new FormData();
                fd.append('file', file);

                try {
                    const res = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: fd,
                        credentials: 'same-origin'
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Erreur upload');

                    const url = data.url;
                    if (!url) throw new Error('URL upload manquante');

                    const targetInput = document.getElementById(uploadTargetInputId);
                    if (targetInput) targetInput.value = url;
                    if (uploadTargetPreviewId) setPreview(uploadTargetPreviewId, url);
                } catch (err) {
                    // eslint-disable-next-line no-alert
                    alert(String(err));
                } finally {
                    input.value = '';
                }
            });
        })();
    </script>
@endsection

