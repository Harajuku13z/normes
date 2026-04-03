@php
    /** @var \App\Models\PortfolioProject $project */
    $isEdit = $isEdit ?? false;
    if ($isEdit && $project->exists) {
        $project->loadMissing('images');
    }
    $defaultImages = $isEdit && $project->exists
        ? $project->images->map(fn ($i) => ['path' => $i->path, 'alt' => $i->alt ?? ''])->values()->all()
        : [['path' => '', 'alt' => '']];
    $imageRows = old('images', $defaultImages);
    if (! is_array($imageRows) || $imageRows === []) {
        $imageRows = [['path' => '', 'alt' => '']];
    }
@endphp

@extends('admin.layout')

@section('title', $isEdit ? 'Modifier un projet' : 'Nouveau projet')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isEdit ? 'Modifier le projet' : 'Nouveau projet' }}</h1>
            <p class="mt-1 text-sm text-slate-600">Titre, description, plusieurs photos (fichier ou chemin relatif).</p>
        </div>
        <a href="{{ route('admin.portfolio_projects.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Liste
        </a>
    </div>

    <form
        method="post"
        action="{{ $isEdit ? route('admin.portfolio_projects.update', $project) : route('admin.portfolio_projects.store') }}"
        class="space-y-6"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2">
                <label class="text-sm font-semibold text-slate-800">Titre</label>
                <input
                    name="title"
                    required
                    value="{{ old('title', $project->title ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                >
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2">
                <label class="text-sm font-semibold text-slate-800">Slug URL</label>
                <input
                    name="slug"
                    value="{{ old('slug', $project->slug ?? '') }}"
                    placeholder="ex. renovation-toiture-chalon (laisser vide = dérivé du titre)"
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 font-mono text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                >
                <p class="mt-1 text-xs text-slate-500">URL publique : <span class="font-mono">/realisations/<span class="text-sky-700">votre-slug</span></span>. Lettres minuscules, tirets. Laisser vide pour génération automatique.</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <label class="text-sm font-semibold text-slate-800">Ordre d’affichage</label>
                <input
                    type="number"
                    name="sort_order"
                    min="0"
                    value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                    class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                >
                <p class="mt-1 text-xs text-slate-500">Plus petit = plus haut dans la liste.</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <label class="text-sm font-semibold text-slate-800">Description</label>
            <textarea
                name="description"
                rows="6"
                class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
            >{{ old('description', $project->description ?? '') }}</textarea>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-sm font-extrabold text-slate-900">Photos</h2>
                <button type="button" id="portfolio-add-image" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-extrabold text-slate-700 hover:bg-slate-50">
                    + Ajouter une photo
                </button>
            </div>
            <p class="mt-1 text-xs text-slate-500">Lignes sans fichier / URL sont ignorées à l’enregistrement.</p>

            <div id="portfolio-image-rows" class="mt-4 space-y-5">
                @foreach ($imageRows as $idx => $row)
                    @php
                        $pathVal = is_array($row) ? (string) ($row['path'] ?? '') : '';
                        $altVal = is_array($row) ? (string) ($row['alt'] ?? '') : '';
                        $fieldId = 'pf_img_'.$idx;
                        $previewId = $fieldId.'_preview';
                        $previewUrl = $pathVal !== '' ? \App\Support\HomeView::url($pathVal) : '';
                    @endphp
                    <div class="portfolio-image-row rounded-xl border border-slate-100 bg-slate-50 p-4" data-row>
                        <div class="flex flex-wrap items-start gap-4">
                            <div class="w-28 shrink-0">
                                @if ($previewUrl !== '')
                                    <img id="{{ $previewId }}" src="{{ $previewUrl }}" alt="" class="h-24 w-28 rounded-lg border border-slate-200 bg-white object-cover">
                                @else
                                    <img id="{{ $previewId }}" src="" alt="" class="h-24 w-28 rounded-lg border border-slate-200 bg-white object-cover" style="display:none">
                                @endif
                            </div>
                            <div class="min-w-0 flex-1 space-y-3">
                                <div>
                                    <label class="text-xs font-semibold text-slate-700">Fichier ou chemin</label>
                                    <input
                                        id="{{ $fieldId }}"
                                        type="text"
                                        name="images[{{ $idx }}][path]"
                                        value="{{ $pathVal }}"
                                        class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                        placeholder="uploads/.... ou glisser via fichier ci-dessous"
                                    >
                                    <input
                                        type="file"
                                        accept="image/*"
                                        class="mt-2 w-full text-sm"
                                        data-upload-target-input-id="{{ $fieldId }}"
                                        data-upload-target-preview-id="{{ $previewId }}"
                                    >
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-slate-700">Texte alternatif (optionnel)</label>
                                    <input
                                        type="text"
                                        name="images[{{ $idx }}][alt]"
                                        value="{{ $altVal }}"
                                        class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                    >
                                </div>
                                <button type="button" class="portfolio-remove-row text-xs font-extrabold text-red-600 hover:underline">
                                    Retirer cette photo
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer
            </button>
        </div>
    </form>

    @if ($isEdit && $project->exists)
        <form
            action="{{ route('admin.portfolio_projects.destroy', $project) }}"
            method="post"
            class="mt-6"
            onsubmit="return confirm('Supprimer ce projet et toutes ses photos ?');"
        >
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-6 py-3 text-sm font-extrabold text-red-800 hover:bg-red-100">
                Supprimer le projet
            </button>
        </form>
    @endif

    <template id="portfolio-image-row-template">
        <div class="portfolio-image-row rounded-xl border border-slate-100 bg-slate-50 p-4" data-row>
            <div class="flex flex-wrap items-start gap-4">
                <div class="w-28 shrink-0">
                    <img data-preview class="h-24 w-28 rounded-lg border border-slate-200 bg-white object-cover" style="display:none" src="" alt="">
                </div>
                <div class="min-w-0 flex-1 space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-slate-700">Fichier ou chemin</label>
                        <input data-path type="text" name="" value="" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm" placeholder="uploads/....">
                        <input type="file" accept="image/*" class="mt-2 w-full text-sm" data-file>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-700">Texte alternatif (optionnel)</label>
                        <input data-alt type="text" name="" value="" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    </div>
                    <button type="button" class="portfolio-remove-row text-xs font-extrabold text-red-600 hover:underline">
                        Retirer cette photo
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script>
        (function () {
            const uploadUrl = @json(route('admin.upload'));
            const csrfToken = @json(csrf_token());
            const rowsContainer = document.getElementById('portfolio-image-rows');
            const addBtn = document.getElementById('portfolio-add-image');
            const tpl = document.getElementById('portfolio-image-row-template');

            function nextIndex() {
                let max = -1;
                rowsContainer.querySelectorAll('input[name^="images["]').forEach(function (el) {
                    const m = String(el.name).match(/^images\[(\d+)\]/);
                    if (m) max = Math.max(max, parseInt(m[1], 10));
                });
                return max + 1;
            }

            function wireRemove(row) {
                const btn = row.querySelector('.portfolio-remove-row');
                if (!btn || btn.dataset.wired) return;
                btn.dataset.wired = '1';
                btn.addEventListener('click', function () {
                    row.remove();
                    if (!rowsContainer.querySelector('[data-row]')) addRow();
                });
            }

            function setFileUploadBinding(fileInput, pathInput, preview) {
                if (!fileInput || !pathInput || !preview) return;
                const pid = 'pf_img_' + Math.random().toString(36).slice(2) + '_preview';
                preview.id = pid;
                fileInput.dataset.uploadTargetInputId = pathInput.id;
                fileInput.dataset.uploadTargetPreviewId = pid;
            }

            function addRow() {
                const idx = nextIndex();
                const node = tpl.content.cloneNode(true);
                const row = node.querySelector('[data-row]');
                if (!row) return;
                const pathInput = row.querySelector('[data-path]');
                const altInput = row.querySelector('[data-alt]');
                const fileInput = row.querySelector('[data-file]');
                const preview = row.querySelector('[data-preview]');
                if (pathInput) {
                    pathInput.name = 'images[' + idx + '][path]';
                    pathInput.id = 'pf_img_' + idx + '_' + Math.random().toString(36).slice(2);
                }
                if (altInput) altInput.name = 'images[' + idx + '][alt]';
                setFileUploadBinding(fileInput, pathInput, preview);
                rowsContainer.appendChild(row);
                wireRemove(row);
            }

            rowsContainer.querySelectorAll('[data-row]').forEach(wireRemove);

            document.addEventListener('change', async function (e) {
                const input = e.target;
                if (!input || input.type !== 'file') return;
                const tid = input.dataset.uploadTargetInputId;
                const pid = input.dataset.uploadTargetPreviewId;
                if (!tid || !pid) return;
                const file = input.files && input.files[0];
                if (!file) return;
                const fd = new FormData();
                fd.append('file', file);
                try {
                    const res = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json' },
                        body: fd,
                        credentials: 'same-origin',
                    });
                    const data = await res.json().catch(function () { return {}; });
                    if (!res.ok) throw new Error(data.message || 'Erreur upload');
                    const targetInput = document.getElementById(tid);
                    if (targetInput) targetInput.value = data.path || data.url || '';
                    const preview = document.getElementById(pid);
                    if (preview && data.url) {
                        preview.src = data.url;
                        preview.style.display = 'block';
                    }
                } catch (err) {
                    alert(String(err));
                } finally {
                    input.value = '';
                }
            });

            addBtn?.addEventListener('click', function () { addRow(); });
        })();
    </script>
@endsection
