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
                if (!fileInput || !urlInput || !previewImg || !placeholderDiv) return;
                const file = fileInput.files && fileInput.files[0];
                if (!file) return;

                    // Preview instant (avant upload) pour éviter "aperçu qui ne s'affiche pas".
                    showPreviewFromLocalFile({ file, previewImg, placeholderDiv });

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
                    previewImg.src = url;
                    previewImg.style.display = 'block';
                    placeholderDiv.classList.add('hidden');
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
        })();
    </script>
@endsection

