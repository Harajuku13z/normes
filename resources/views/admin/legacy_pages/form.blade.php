@extends('admin.layout')

@section('title', $isEdit ? 'Modifier page legacy' : 'Créer page legacy')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">{{ $isEdit ? 'Modifier la page legacy' : 'Créer une page legacy' }}</h1>
        <p class="mt-1 text-sm text-slate-600">
            L’URL legacy sera servie en 200 (pas de redirection), pour préserver les pages indexées.
        </p>
    </div>

    <form method="post" action="{{ $isEdit ? route('admin.legacy_pages.update', $legacyPage) : route('admin.legacy_pages.store') }}" class="space-y-5">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Ancien chemin WordPress</label>
                    <input name="old_path" value="{{ old('old_path', $legacyPage->old_path) }}" placeholder="ex: couvreur-autun" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                    <p class="mt-1 text-xs text-slate-500">Sans domaine. Exemples : <code>/couvreur-autun</code>, <code>/category/astuces</code></p>
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Titre interne</label>
                    <input name="title" value="{{ old('title', $legacyPage->title) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">H1 (optionnel)</label>
                    <input name="h1" value="{{ old('h1', $legacyPage->h1) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Introduction (optionnel)</label>
                    <textarea name="excerpt" rows="3" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('excerpt', $legacyPage->excerpt) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Contenu HTML</label>
                    <textarea name="content_html" rows="14" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 font-mono text-xs focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('content_html', $legacyPage->content_html) }}</textarea>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-extrabold uppercase tracking-wide text-slate-700">SEO</h2>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Meta title</label>
                    <input name="meta_title" value="{{ old('meta_title', $legacyPage->meta_title) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Meta description</label>
                    <textarea name="meta_description" rows="3" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('meta_description', $legacyPage->meta_description) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">Canonical URL (optionnel)</label>
                    <input name="canonical_url" value="{{ old('canonical_url', $legacyPage->canonical_url) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-extrabold text-slate-700">OG image (optionnel)</label>
                    <input name="og_image" value="{{ old('og_image', $legacyPage->og_image) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                </div>
                <div class="sm:col-span-2">
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $legacyPage->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600" />
                        Page active (servable en public)
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="submit" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                {{ $isEdit ? 'Enregistrer' : 'Créer la page' }}
            </button>
            <a href="{{ route('admin.legacy_pages.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                Retour
            </a>
        </div>
    </form>
@endsection

