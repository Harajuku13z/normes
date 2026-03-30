@php
    $isEdit = isset($page) && $page->exists;
    $pageTitle = $isEdit ? 'Modifier la page service' : 'Créer une page service';
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
            <label class="text-sm font-semibold text-slate-800">Texte principal (HTML ou texte brut)</label>
            <textarea name="body" rows="8" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('body', $page->body ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">Image mise en avant (Homepage)</label>
                <input name="featured_image" value="{{ old('featured_image', $page->featured_image ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                <p class="mt-1 text-xs text-slate-500">Ex: <code class="rounded bg-white px-1">services/menuiserie2.jpg</code> ou <code class="rounded bg-white px-1">slide/toiture.png</code></p>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-800">Aperçu</label>
                <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                    @php $fimg = $page->featured_image ?? ''; @endphp
                    @if (is_string($fimg) && trim($fimg) !== '')
                        <img src="{{ \App\Support\HomeView::url($fimg) }}" alt="" class="h-40 w-full object-cover">
                    @else
                        <div class="h-40 w-full bg-slate-50"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2 mt-2">
            <div>
                <label class="text-sm font-semibold text-slate-800">Image Hero (Page service)</label>
                <input name="image" value="{{ old('image', $page->image ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                <p class="mt-1 text-xs text-slate-500">Ex: <code class="rounded bg-white px-1">slide/toiture.png</code> ou <code class="rounded bg-white px-1">storage/uploads/...png</code></p>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-800">Aperçu</label>
                <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                    @php $img = $page->image ?? ''; @endphp
                    @if (is_string($img) && trim($img) !== '')
                        <img src="{{ \App\Support\HomeView::url($img) }}" alt="" class="h-40 w-full object-cover">
                    @else
                        <div class="h-40 w-full bg-slate-50"></div>
                    @endif
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
@endsection

