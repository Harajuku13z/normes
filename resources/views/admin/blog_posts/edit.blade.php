@extends('admin.layout')

@section('title', ($post->exists ? 'Éditer' : 'Créer').' — Article')

@section('content')
    @php
        $isEdit = $post->exists;
        $uploadUrl = route('admin.upload');
        $csrf = csrf_token();
    @endphp

    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isEdit ? 'Éditer' : 'Créer' }} un article</h1>
            <p class="mt-1 text-sm text-slate-600">Chaque article doit être pensé comme une landing page (structure claire, sections, CTA).</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.blog_posts.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">← Retour</a>
            @if ($isEdit)
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" rel="noopener" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Voir (si publié)</a>
            @endif
        </div>
    </div>

    <form class="mt-6 space-y-6" method="post" action="{{ $isEdit ? route('admin.blog_posts.update', $post) : route('admin.blog_posts.store') }}">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_420px]">
            {{-- Colonne contenu --}}
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Titre</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-base font-extrabold">
                    <p class="mt-2 text-xs text-slate-500">Titre clair orienté bénéfice + intention de recherche.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                        <div class="min-w-0 flex-1">
                            <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Slug (URL)</label>
                            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" placeholder="ex: isolation-toiture-bretagne" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 font-mono text-sm">
                        </div>
                        <div class="w-full sm:w-56">
                            <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Publié le</label>
                            <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm">
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Laissez vide = brouillon. Date passée = publié.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Accroche / Extrait</label>
                    <textarea name="excerpt" rows="3" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-relaxed">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Contenu (HTML)</p>
                            <p class="mt-1 text-xs text-slate-500">Astuce: H2/H3, listes, blocs “Avantages”, et 1 CTA toutes les 2–3 sections.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="insertH2" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50">+ H2</button>
                            <button type="button" id="insertH3" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50">+ H3</button>
                            <button type="button" id="insertCta" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50">+ CTA</button>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Ajouter une image dans l'article</label>
                        <input id="editorImageUpload" type="file" accept="image/*" class="w-full text-sm">
                        <p class="mt-1 text-xs text-slate-500">L'image est uploadée puis insérée automatiquement dans le contenu.</p>
                    </div>

                    <textarea id="contentEditor" name="content_html" rows="18" class="mt-4 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 font-mono text-sm leading-relaxed">{{ old('content_html', $post->content_html) }}</textarea>
                </div>
            </div>

            {{-- Colonne SEO + images --}}
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-extrabold text-slate-900">Image mise en avant</p>
                    @php
                        $featured = old('featured_image', $post->featured_image);
                        $featuredUrl = is_string($featured) && trim($featured) !== '' ? \App\Support\HomeView::url($featured) : '';
                    @endphp
                    <div class="mt-4 flex flex-wrap items-start gap-4">
                        <img id="featuredPreview" src="{{ $featuredUrl }}" alt="" class="h-24 w-28 rounded-lg border border-slate-200 bg-white object-cover {{ $featuredUrl ? '' : 'hidden' }}">
                        <div class="min-w-0 flex-1">
                            <input id="featuredInput" type="text" name="featured_image" value="{{ $featured }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm" placeholder="/storage/... ou /slide/...">
                            <input type="file" accept="image/*" class="mt-2 w-full text-sm" data-upload-target-input-id="featuredInput" data-upload-target-preview-id="featuredPreview">
                            <p class="mt-1 text-xs text-slate-500">Utilisée pour la carte + hero de l'article.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-extrabold text-slate-900">SEO</p>
                    <div class="mt-4 space-y-3">
                        <div>
                            <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Meta title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Meta description</label>
                            <textarea name="meta_description" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm leading-relaxed">{{ old('meta_description', $post->meta_description) }}</textarea>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Canonical (optionnel)</label>
                            <input type="text" name="canonical_url" value="{{ old('canonical_url', $post->canonical_url) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm" placeholder="https://...">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">OG image (optionnel)</label>
                            <input type="text" name="og_image" value="{{ old('og_image', $post->og_image) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm" placeholder="/storage/...">
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <button type="submit" class="w-full rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                        {{ $isEdit ? 'Enregistrer' : 'Créer' }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if ($isEdit)
        <form method="post" action="{{ route('admin.blog_posts.destroy', $post) }}" class="mt-6" onsubmit="return confirm('Supprimer cet article ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-extrabold text-red-700 hover:bg-red-100">Supprimer l'article</button>
        </form>
    @endif

    @push('scripts')
        <script>
            (function () {
                const uploadUrl = @json($uploadUrl);
                const csrfToken = @json($csrf);

                const editor = document.getElementById('contentEditor');
                const imgInput = document.getElementById('editorImageUpload');
                const btnH2 = document.getElementById('insertH2');
                const btnH3 = document.getElementById('insertH3');
                const btnCta = document.getElementById('insertCta');

                const insertAtCursor = (textarea, text) => {
                    if (!textarea) return;
                    const start = textarea.selectionStart || 0;
                    const end = textarea.selectionEnd || 0;
                    const before = textarea.value.slice(0, start);
                    const after = textarea.value.slice(end);
                    textarea.value = before + text + after;
                    const newPos = start + text.length;
                    textarea.setSelectionRange(newPos, newPos);
                    textarea.focus();
                };

                const uploadFile = async (file) => {
                    const fd = new FormData();
                    fd.append('file', file);
                    const res = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        body: fd,
                        credentials: 'same-origin'
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Erreur upload');
                    if (!data.url) throw new Error('URL upload manquante');
                    return data.url;
                };

                document.addEventListener('change', async (e) => {
                    const input = e.target;
                    if (!input || input.type !== 'file') return;
                    const targetId = input.dataset.uploadTargetInputId;
                    if (!targetId) return;
                    const file = input.files && input.files[0];
                    if (!file) return;
                    try {
                        const url = await uploadFile(file);
                        const target = document.getElementById(targetId);
                        if (target) target.value = url;
                        const previewId = input.dataset.uploadTargetPreviewId;
                        if (previewId) {
                            const img = document.getElementById(previewId);
                            if (img) {
                                img.src = url;
                                img.classList.remove('hidden');
                            }
                        }
                    } catch (err) {
                        alert(String(err));
                    } finally {
                        input.value = '';
                    }
                });

                if (imgInput) {
                    imgInput.addEventListener('change', async () => {
                        const file = imgInput.files && imgInput.files[0];
                        if (!file) return;
                        try {
                            const url = await uploadFile(file);
                            insertAtCursor(editor, `\\n<figure>\\n  <img src=\"${url}\" alt=\"\" loading=\"lazy\" decoding=\"async\">\\n</figure>\\n`);
                        } catch (e) {
                            alert(String(e));
                        } finally {
                            imgInput.value = '';
                        }
                    });
                }

                if (btnH2) btnH2.addEventListener('click', () => insertAtCursor(editor, '\\n<h2>Titre de section</h2>\\n<p>...</p>\\n'));
                if (btnH3) btnH3.addEventListener('click', () => insertAtCursor(editor, '\\n<h3>Sous-titre</h3>\\n<p>...</p>\\n'));
                if (btnCta) btnCta.addEventListener('click', () => insertAtCursor(editor, `\\n<div class=\"mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6\">\\n  <p class=\"text-sm font-extrabold uppercase tracking-wide text-slate-500\">Besoin d\\'un devis ?</p>\\n  <p class=\"mt-2 text-2xl font-black text-brand-dark\">Parlons de votre projet</p>\\n  <p class=\"mt-2 text-sm text-slate-600\">Un conseiller vous rappelle pour affiner le chiffrage et vérifier les aides.</p>\\n  <a href=\"/contact#devis\" class=\"mt-4 inline-flex rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white\">Demander un devis</a>\\n</div>\\n`));
            })();
        </script>
    @endpush
@endsection
