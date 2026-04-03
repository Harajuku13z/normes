@extends('admin.layout')

@section('title', 'Page Franchise — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Page Franchise</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Contenus de <code class="rounded bg-slate-100 px-1 text-xs">/franchise</code> : hero, piliers, implantation, réseau, étapes, FAQ et formulaire.
                Enregistrés dans <code class="rounded bg-slate-100 px-1 text-xs">home_sections</code> (clé <code class="rounded bg-slate-100 px-1 text-xs">franchise_page</code>).
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">← Retour</a>
            <a href="{{ route('franchise.page') }}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">Voir /franchise</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">{{ session('status') }}</div>
    @endif

    <form method="post" action="{{ route('admin.franchise_settings.update') }}" class="space-y-5">
        @csrf

        {{-- ═══ SEO ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">SEO & Métadonnées</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Meta title</label>
                    <input type="text" name="sections[franchise_page][meta_title]" value="{{ data_get($fp, 'meta_title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Meta keywords</label>
                    <input type="text" name="sections[franchise_page][meta_keywords]" value="{{ data_get($fp, 'meta_keywords') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Meta description</label>
                    <textarea name="sections[franchise_page][meta_description]" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'meta_description') }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Image OG</label>
                    <input type="text" name="sections[franchise_page][og_image]" value="{{ data_get($fp, 'og_image') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm" placeholder="/slide/toiture.png">
                </div>
            </div>
        </details>

        {{-- ═══ HERO ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">Hero</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="lg:col-span-2">
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Image de fond</label>
                    <input type="text" name="sections[franchise_page][hero_bg]" value="{{ data_get($fp, 'hero_bg') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm" placeholder="URL ou chemin /slide/...">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Kicker</label>
                    <input type="text" name="sections[franchise_page][hero_kicker]" value="{{ data_get($fp, 'hero_kicker') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre H1 ligne 1</label>
                    <input type="text" name="sections[franchise_page][hero_h1_line1]" value="{{ data_get($fp, 'hero_h1_line1') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre H1 accent (bleu)</label>
                    <input type="text" name="sections[franchise_page][hero_h1_accent]" value="{{ data_get($fp, 'hero_h1_accent') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Intro</label>
                    <textarea name="sections[franchise_page][hero_intro]" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'hero_intro') }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">CTA primaire</label>
                    <input type="text" name="sections[franchise_page][hero_cta_primary]" value="{{ data_get($fp, 'hero_cta_primary') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">CTA secondaire</label>
                    <input type="text" name="sections[franchise_page][hero_cta_secondary]" value="{{ data_get($fp, 'hero_cta_secondary') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
            </div>
        </details>

        {{-- ═══ PILIERS ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">Piliers « Pourquoi ? »</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Kicker</label><input type="text" name="sections[franchise_page][pillars_kicker]" value="{{ data_get($fp, 'pillars_kicker') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre</label><input type="text" name="sections[franchise_page][pillars_title]" value="{{ data_get($fp, 'pillars_title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div class="lg:col-span-2"><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Sous-titre</label><input type="text" name="sections[franchise_page][pillars_subtitle]" value="{{ data_get($fp, 'pillars_subtitle') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
            </div>
            <div id="pillarsBuilder" class="mt-5 space-y-3">
                @foreach ((array) data_get($fp, 'pillars', []) as $idx => $pillar)
                    <div class="pillar-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Pilier {{ $idx + 1 }}</span>
                            <button type="button" onclick="this.closest('.pillar-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div>
                                <label class="mb-1 block text-xs font-bold text-slate-500">Icône</label>
                                <select name="sections[franchise_page][pillars][{{ $idx }}][icon]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm">
                                    @foreach (['shield-check' => 'Bouclier', 'academic-cap' => 'Casquette', 'arrow-trending-up' => 'Tendance', 'light-bulb' => 'Ampoule', 'user-group' => 'Groupe'] as $val => $lbl)
                                        <option value="{{ $val }}" {{ data_get($pillar, 'icon') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Titre</label><input type="text" name="sections[franchise_page][pillars][{{ $idx }}][title]" value="{{ data_get($pillar, 'title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][pillars][{{ $idx }}][text]" value="{{ data_get($pillar, 'text') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="addPillar" class="mt-3 rounded-lg border border-dashed border-slate-300 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">+ Ajouter un pilier</button>
        </details>

        {{-- ═══ IMPLANTATION ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">Implantation & chiffres</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre ligne 1</label><input type="text" name="sections[franchise_page][implantation_title_line1]" value="{{ data_get($fp, 'implantation_title_line1') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Accent 1 (bleu)</label><input type="text" name="sections[franchise_page][implantation_title_accent1]" value="{{ data_get($fp, 'implantation_title_accent1') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Accent 2 (bleu)</label><input type="text" name="sections[franchise_page][implantation_title_accent2]" value="{{ data_get($fp, 'implantation_title_accent2') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Texte CTA</label><input type="text" name="sections[franchise_page][implantation_cta]" value="{{ data_get($fp, 'implantation_cta') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div class="lg:col-span-2"><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Texte</label><textarea name="sections[franchise_page][implantation_text]" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'implantation_text') }}</textarea></div>
            </div>
            <p class="mt-5 text-xs font-extrabold uppercase tracking-wide text-slate-500">Chiffres clés</p>
            <div id="statsBuilder" class="mt-3 space-y-3">
                @foreach ((array) data_get($fp, 'stats', []) as $idx => $stat)
                    <div class="stat-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Chiffre {{ $idx + 1 }}</span>
                            <button type="button" onclick="this.closest('.stat-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Valeur</label><input type="text" name="sections[franchise_page][stats][{{ $idx }}][value]" value="{{ data_get($stat, 'value') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Label</label><input type="text" name="sections[franchise_page][stats][{{ $idx }}][label]" value="{{ data_get($stat, 'label') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][stats][{{ $idx }}][text]" value="{{ data_get($stat, 'text') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="addStat" class="mt-3 rounded-lg border border-dashed border-slate-300 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">+ Ajouter un chiffre</button>
        </details>

        {{-- ═══ RÉSEAU ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">Réseau franchisés</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre</label><input type="text" name="sections[franchise_page][network_title]" value="{{ data_get($fp, 'network_title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div class="lg:col-span-2"><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Intro</label><textarea name="sections[franchise_page][network_intro]" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'network_intro') }}</textarea></div>
            </div>
            <div id="networkBuilder" class="mt-4 space-y-3">
                @foreach ((array) data_get($fp, 'network_items', []) as $idx => $item)
                    <div class="network-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Item {{ $idx + 1 }}</span>
                            <button type="button" onclick="this.closest('.network-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Titre</label><input type="text" name="sections[franchise_page][network_items][{{ $idx }}][title]" value="{{ data_get($item, 'title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][network_items][{{ $idx }}][text]" value="{{ data_get($item, 'text') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="addNetwork" class="mt-3 rounded-lg border border-dashed border-slate-300 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">+ Ajouter un item</button>
            <div class="mt-5 grid gap-4 lg:grid-cols-2">
                <div class="lg:col-span-2"><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Témoignage</label><textarea name="sections[franchise_page][testimonial_text]" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'testimonial_text') }}</textarea></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Auteur témoignage</label><input type="text" name="sections[franchise_page][testimonial_author]" value="{{ data_get($fp, 'testimonial_author') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
            </div>
        </details>

        {{-- ═══ ÉTAPES ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">Étapes « Comment faire ? »</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre</label><input type="text" name="sections[franchise_page][steps_title]" value="{{ data_get($fp, 'steps_title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Sous-titre</label><input type="text" name="sections[franchise_page][steps_subtitle]" value="{{ data_get($fp, 'steps_subtitle') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
            </div>
            <div id="stepsBuilder" class="mt-4 space-y-3">
                @foreach ((array) data_get($fp, 'steps', []) as $idx => $step)
                    <div class="step-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Étape {{ $idx + 1 }}</span>
                            <button type="button" onclick="this.closest('.step-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Titre</label><input type="text" name="sections[franchise_page][steps][{{ $idx }}][title]" value="{{ data_get($step, 'title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][steps][{{ $idx }}][text]" value="{{ data_get($step, 'text') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="addStep" class="mt-3 rounded-lg border border-dashed border-slate-300 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">+ Ajouter une étape</button>
        </details>

        {{-- ═══ FAQ ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">FAQ</summary>
            <div class="mt-4">
                <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre FAQ</label>
                <input type="text" name="sections[franchise_page][faq_title]" value="{{ data_get($fp, 'faq_title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
            </div>
            <div id="faqBuilder" class="mt-4 space-y-3">
                @foreach ((array) data_get($fp, 'faq', []) as $idx => $faqItem)
                    <div class="faq-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Q&A {{ $idx + 1 }}</span>
                            <button type="button" onclick="this.closest('.faq-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button>
                        </div>
                        <div class="grid gap-3">
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Question</label><input type="text" name="sections[franchise_page][faq][{{ $idx }}][q]" value="{{ data_get($faqItem, 'q') }}" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                            <div><label class="mb-1 block text-xs font-bold text-slate-500">Réponse</label><textarea name="sections[franchise_page][faq][{{ $idx }}][a]" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm">{{ data_get($faqItem, 'a') }}</textarea></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="addFaq" class="mt-3 rounded-lg border border-dashed border-slate-300 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">+ Ajouter une Q&A</button>
        </details>

        {{-- ═══ FORMULAIRE ═══ --}}
        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">Formulaire de candidature</summary>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Kicker</label><input type="text" name="sections[franchise_page][form_kicker]" value="{{ data_get($fp, 'form_kicker') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre</label><input type="text" name="sections[franchise_page][form_title]" value="{{ data_get($fp, 'form_title') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div class="lg:col-span-2"><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Intro</label><textarea name="sections[franchise_page][form_intro]" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'form_intro') }}</textarea></div>
                <div><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Texte bouton</label><input type="text" name="sections[franchise_page][form_submit]" value="{{ data_get($fp, 'form_submit') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>
                <div class="lg:col-span-2"><label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Texte RGPD</label><textarea name="sections[franchise_page][form_rgpd]" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">{{ data_get($fp, 'form_rgpd') }}</textarea></div>
            </div>
        </details>

        <div class="pt-2">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">Enregistrer</button>
        </div>
    </form>

    <script>
        (function () {
            function addDynamic(btnId, containerId, itemClass, template) {
                const btn = document.getElementById(btnId);
                const container = document.getElementById(containerId);
                if (!btn || !container) return;
                btn.addEventListener('click', () => {
                    const idx = container.querySelectorAll('.' + itemClass).length;
                    const html = template(idx);
                    container.insertAdjacentHTML('beforeend', html);
                });
            }

            const iconOptions = '<option value="shield-check">Bouclier</option><option value="academic-cap">Casquette</option><option value="arrow-trending-up">Tendance</option><option value="light-bulb">Ampoule</option><option value="user-group">Groupe</option>';

            addDynamic('addPillar', 'pillarsBuilder', 'pillar-item', (i) => `
                <div class="pillar-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="mb-2 flex items-center justify-between"><span class="text-xs font-bold text-slate-400">Pilier ${i + 1}</span><button type="button" onclick="this.closest('.pillar-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button></div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Icône</label><select name="sections[franchise_page][pillars][${i}][icon]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm">${iconOptions}</select></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Titre</label><input type="text" name="sections[franchise_page][pillars][${i}][title]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][pillars][${i}][text]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                    </div>
                </div>`);

            addDynamic('addStat', 'statsBuilder', 'stat-item', (i) => `
                <div class="stat-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="mb-2 flex items-center justify-between"><span class="text-xs font-bold text-slate-400">Chiffre ${i + 1}</span><button type="button" onclick="this.closest('.stat-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button></div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Valeur</label><input type="text" name="sections[franchise_page][stats][${i}][value]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Label</label><input type="text" name="sections[franchise_page][stats][${i}][label]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][stats][${i}][text]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                    </div>
                </div>`);

            addDynamic('addNetwork', 'networkBuilder', 'network-item', (i) => `
                <div class="network-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="mb-2 flex items-center justify-between"><span class="text-xs font-bold text-slate-400">Item ${i + 1}</span><button type="button" onclick="this.closest('.network-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button></div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Titre</label><input type="text" name="sections[franchise_page][network_items][${i}][title]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][network_items][${i}][text]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                    </div>
                </div>`);

            addDynamic('addStep', 'stepsBuilder', 'step-item', (i) => `
                <div class="step-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="mb-2 flex items-center justify-between"><span class="text-xs font-bold text-slate-400">Étape ${i + 1}</span><button type="button" onclick="this.closest('.step-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button></div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Titre</label><input type="text" name="sections[franchise_page][steps][${i}][title]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Texte</label><input type="text" name="sections[franchise_page][steps][${i}][text]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                    </div>
                </div>`);

            addDynamic('addFaq', 'faqBuilder', 'faq-item', (i) => `
                <div class="faq-item rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="mb-2 flex items-center justify-between"><span class="text-xs font-bold text-slate-400">Q&A ${i + 1}</span><button type="button" onclick="this.closest('.faq-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button></div>
                    <div class="grid gap-3">
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Question</label><input type="text" name="sections[franchise_page][faq][${i}][q]" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-500">Réponse</label><textarea name="sections[franchise_page][faq][${i}][a]" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm"></textarea></div>
                    </div>
                </div>`);
        })();
    </script>
@endsection
