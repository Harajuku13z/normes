@extends('admin.layout')

@section('title', 'Réalisations — Contenu de la page')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $label }}</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Ces champs alimentent le hero et les métadonnées de <code class="rounded bg-slate-100 px-1 text-xs">/realisations</code>. Les projets se gèrent dans « Liste des projets ».
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.realisations.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Réalisations
            </a>
            <a href="{{ route('realisations.page') }}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Voir la page
            </a>
        </div>
    </div>

    <form method="post" action="{{ route('admin.realisations.page.update') }}" class="space-y-5">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            @include('admin.homepage.partials.form', [
                'name' => 'sections[realisations_page]',
                'value' => $merged,
                'depth' => 0,
            ])
        </div>
        <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
            Enregistrer
        </button>
    </form>

    <script>
        (function () {
            const uploadUrl = @json(route('admin.upload'));
            const csrfToken = @json(csrf_token());

            function setPreview(previewId, url) {
                const img = document.getElementById(previewId);
                if (!img) return;
                img.src = url;
                img.classList.remove('hidden');
                img.style.display = 'block';
            }

            document.addEventListener('change', async (e) => {
                const input = e.target;
                if (!input || input.type !== 'file') return;
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
                            Accept: 'application/json',
                        },
                        body: fd,
                        credentials: 'same-origin',
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Erreur upload');

                    const url = data.url;
                    const path = data.path;
                    if (!path && !url) throw new Error('Réponse upload incomplète');

                    const targetInput = document.getElementById(uploadTargetInputId);
                    if (targetInput) targetInput.value = path || url;
                    if (uploadTargetPreviewId) setPreview(uploadTargetPreviewId, url || '');
                } catch (err) {
                    alert(String(err));
                } finally {
                    input.value = '';
                }
            });
        })();
    </script>
@endsection
