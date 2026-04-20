@extends('admin.layout')

@section('title', $isEdit ? 'Modifier page legacy' : 'Créer page legacy')

@section('content')
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">
            {{ $isEdit ? 'Modifier la page legacy' : 'Créer une page legacy' }}
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            L'URL est servie en <strong>200</strong> (pas de redirection) — le contenu s'affiche à l'ancienne adresse WordPress.
        </p>
    </div>
    @if ($isEdit)
        <a href="{{ url('/' . ltrim($legacyPage->old_path, '/')) }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-sky-300 hover:text-sky-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
            Voir la page
        </a>
    @endif
</div>

@if ($errors->any())
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <strong>Erreurs :</strong>
        <ul class="mt-1 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
@endif

<form method="post"
      action="{{ $isEdit ? route('admin.legacy_pages.update', $legacyPage) : route('admin.legacy_pages.store') }}"
      class="space-y-6">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    {{-- ── CONTENU DE LA PAGE ──────────────────────────────────────── --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-sm font-extrabold uppercase tracking-wide text-slate-600">📄 Contenu de la page</h2>
        </div>
        <div class="grid gap-5 p-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">
                    Chemin WordPress <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center overflow-hidden rounded-xl border border-slate-200 focus-within:border-sky-500 focus-within:ring-2 focus-within:ring-sky-200">
                    <span class="shrink-0 border-r border-slate-200 bg-slate-50 px-3 py-2 text-xs text-slate-400">normesrenovation.fr/</span>
                    <input id="old_path" name="old_path" value="{{ old('old_path', $legacyPage->old_path ?? '') }}"
                           placeholder="couvreur-chalon-sur-saone"
                           class="w-full bg-white px-3 py-2 text-sm outline-none" />
                </div>
                <p class="mt-1 text-xs text-slate-400">Sans slash initial. Exemples : <code>couvreur-autun</code>, <code>aides-renovation-2026</code></p>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">Titre interne <span class="text-red-500">*</span></label>
                <input id="title_field" name="title" value="{{ old('title', $legacyPage->title ?? '') }}"
                       placeholder="Couvreur à Chalon-sur-Saône – Normes Rénovation"
                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                <p class="mt-1 text-xs text-slate-400">Utilisé si <em>Meta title</em> est vide.</p>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">H1 (optionnel)</label>
                <input name="h1" value="{{ old('h1', $legacyPage->h1 ?? '') }}"
                       placeholder="Laisser vide pour utiliser le titre"
                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">Extrait / introduction</label>
                <textarea name="excerpt" rows="3"
                          placeholder="Brève description affichée sous le H1 et en meta description si vide…"
                          class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('excerpt', $legacyPage->excerpt ?? '') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">
                    Contenu HTML
                    <span class="ml-1 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-500">optionnel</span>
                </label>
                <p class="mb-2 text-xs text-slate-400">
                    Laissez vide pour afficher la landing page de conversion. Remplissez avec l'HTML WordPress nettoyé pour un contenu spécifique.
                    Vous pouvez lancer <code class="rounded bg-slate-100 px-1">php artisan legacy:import-wordpress</code> pour importer automatiquement depuis le XML.
                </p>
                <textarea name="content_html" rows="16"
                          class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 font-mono text-xs focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('content_html', $legacyPage->content_html ?? '') }}</textarea>
            </div>

            <div class="sm:col-span-2 flex flex-wrap items-center gap-4">
                <label class="inline-flex cursor-pointer items-center gap-2.5 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $legacyPage->is_active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                    Page active (visible publiquement)
                </label>
                @if ($isEdit)
                <label class="inline-flex cursor-pointer items-center gap-2.5 text-sm font-semibold text-slate-700" title="Décocher pour permettre à l'importeur WordPress de réécrire cette page">
                    <input type="checkbox" name="content_locked" value="1"
                           {{ old('content_locked', $legacyPage->content_locked ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-400" />
                    <span class="{{ ($legacyPage->content_locked ?? false) ? 'text-amber-600' : 'text-slate-500' }}">
                        🔒 Contenu verrouillé (protégé de l'import WP)
                    </span>
                </label>
                @if ($legacyPage->content_locked ?? false)
                    <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-700">Protégé — l'importeur ne peut pas écraser cette page</span>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- ── SEO ──────────────────────────────────────────────────────── --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-sm font-extrabold uppercase tracking-wide text-slate-600">🔍 SEO & Métadonnées</h2>
            <p class="mt-0.5 text-xs text-slate-400">Laissez vide → le système génère automatiquement depuis l'URL.</p>
        </div>
        <div class="grid gap-5 p-5 sm:grid-cols-2">

            {{-- Aperçu Google --}}
            <div class="sm:col-span-2">
                <p class="mb-2 text-xs font-extrabold uppercase tracking-wide text-slate-500">Aperçu Google</p>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4">
                    <p id="seo_preview_url" class="text-[13px] text-green-700">
                        normesrenovation.fr › {{ $legacyPage->old_path ?? '…' }}
                    </p>
                    <p id="seo_preview_title" class="mt-0.5 text-[17px] font-medium text-blue-700 leading-snug">
                        {{ $legacyPage->meta_title ?? $legacyPage->title ?? 'Meta title…' }}
                    </p>
                    <p id="seo_preview_desc" class="mt-1 text-[13px] leading-relaxed text-slate-600 line-clamp-2">
                        {{ $legacyPage->meta_description ?? $legacyPage->excerpt ?? 'Meta description…' }}
                    </p>
                </div>
                <div class="mt-2 flex gap-4 text-[11px] text-slate-400">
                    <span id="title_count">Titre : <strong id="title_chars">0</strong>/60</span>
                    <span id="desc_count">Description : <strong id="desc_chars">0</strong>/160</span>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">Meta title</label>
                <input id="meta_title_input" name="meta_title"
                       value="{{ old('meta_title', $legacyPage->meta_title ?? '') }}"
                       placeholder="Laissez vide → généré automatiquement"
                       maxlength="70"
                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                <p class="mt-1 text-xs text-slate-400">Recommandé : 50–60 caractères</p>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-extrabold text-slate-700">Meta description</label>
                <textarea id="meta_desc_input" name="meta_description" rows="3" maxlength="180"
                          placeholder="Laissez vide → généré automatiquement depuis l'extrait"
                          class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('meta_description', $legacyPage->meta_description ?? '') }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Recommandé : 120–160 caractères</p>
            </div>

            <div>
                <label class="mb-1 block text-sm font-extrabold text-slate-700">Canonical URL</label>
                <input name="canonical_url"
                       value="{{ old('canonical_url', $legacyPage->canonical_url ?? '') }}"
                       placeholder="Laisser vide = URL courante"
                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                <p class="mt-1 text-xs text-slate-400">Pointez vers <code>/</code> pour éviter le duplicate content.</p>
            </div>

            <div>
                <label class="mb-1 block text-sm font-extrabold text-slate-700">OG Image (URL)</label>
                <input name="og_image"
                       value="{{ old('og_image', $legacyPage->og_image ?? '') }}"
                       placeholder="/slide/toiture.png"
                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
            </div>
        </div>
    </div>

    {{-- ── ACTIONS ──────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap items-center gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-extrabold text-white shadow-sm transition hover:bg-sky-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/></svg>
            {{ $isEdit ? 'Enregistrer les modifications' : 'Créer la page' }}
        </button>
        <a href="{{ route('admin.legacy_pages.index') }}"
           class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
            Annuler
        </a>
        @if ($isEdit)
            <form method="post" action="{{ route('admin.legacy_pages.destroy', $legacyPage) }}" class="ml-auto"
                  onsubmit="return confirm('Supprimer cette page legacy ?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    Supprimer
                </button>
            </form>
        @endif
    </div>
</form>

<script>
(function () {
    var titleInput   = document.getElementById('meta_title_input');
    var descInput    = document.getElementById('meta_desc_input');
    var pathInput    = document.getElementById('old_path');
    var titleField   = document.getElementById('title_field');
    var prevTitle    = document.getElementById('seo_preview_title');
    var prevDesc     = document.getElementById('seo_preview_desc');
    var prevUrl      = document.getElementById('seo_preview_url');
    var titleChars   = document.getElementById('title_chars');
    var descChars    = document.getElementById('desc_chars');

    function update() {
        var t = (titleInput.value || titleField.value || 'Meta title…').slice(0, 70);
        var d = (descInput.value || '').slice(0, 160) || 'Meta description…';
        var p = pathInput.value || '…';
        prevTitle.textContent = t;
        prevDesc.textContent  = d;
        prevUrl.textContent   = 'normesrenovation.fr › ' + p;
        titleChars.textContent = titleInput.value.length;
        descChars.textContent  = descInput.value.length;
        titleChars.className   = titleInput.value.length > 60 ? 'text-red-600 font-bold' : '';
        descChars.className    = descInput.value.length > 160 ? 'text-red-600 font-bold' : '';
    }

    [titleInput, descInput, pathInput, titleField].forEach(function (el) {
        if (el) el.addEventListener('input', update);
    });
    update();
})();
</script>
@endsection
