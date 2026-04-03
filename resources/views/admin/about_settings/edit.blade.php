@extends('admin.layout')

@section('title', 'Page À propos — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — {{ $label }}</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Contenus de la route <code class="rounded bg-slate-100 px-1 text-xs">/a-propos</code> : hero, piliers, expertise, avis, médiation, mentions légales, etc. Les valeurs sont enregistrées dans <code class="rounded bg-slate-100 px-1 text-xs">home_sections</code> (clé <code class="rounded bg-slate-100 px-1 text-xs">about_page</code>). Pour un <strong>titre en deux couleurs</strong> (comme sur l’accueil), utilisez <code class="rounded bg-slate-100 px-1 text-xs">partie une | partie deux</code> ou une virgule <code class="rounded bg-slate-100 px-1 text-xs">partie une, partie deux</code> (hero : 1<sup>re</sup> partie blanche, 2<sup>e</sup> en bleu ; blocs clairs : 1<sup>re</sup> en bleu, 2<sup>e</sup> en foncé).
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Retour
            </a>
            <a href="{{ route('about.page') }}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Voir la page À propos
            </a>
        </div>
    </div>

    <form method="post" action="{{ route('admin.about_settings.update') }}" class="space-y-5">
        @csrf

        @php
            $reelsForEditor = data_get($merged, 'reels', []);
            if (! is_array($reelsForEditor)) {
                $reelsForEditor = [];
            }
            $mergedForForm = $merged;
            unset($mergedForForm['reels']);
        @endphp

        @include('admin.about_settings.partials.reels_editor', [
            'reels' => $reelsForEditor,
            'namePrefix' => 'sections[about_page][reels]',
        ])

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Autres champs <span class="font-mono text-xs font-normal text-slate-500">about_page</span>
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[about_page]',
                    'value' => $mergedForForm,
                    'depth' => 0,
                ])
            </div>
        </details>

        <div class="pt-2">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer
            </button>
        </div>
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

            function setVideoPreview(previewId, url) {
                const vid = document.getElementById(previewId);
                if (!vid || vid.tagName !== 'VIDEO') return;
                vid.src = url;
                vid.classList.remove('hidden');
                vid.style.display = '';
                const ph = document.getElementById(previewId + '_placeholder');
                if (ph) ph.style.display = 'none';
            }

            document.addEventListener('change', async (e) => {
                const input = e.target;
                if (!input || input.type !== 'file') return;
                const uploadTargetInputId = input.dataset.uploadTargetInputId;
                const uploadTargetPreviewId = input.dataset.uploadTargetPreviewId;
                const uploadTargetPreviewVideoId = input.dataset.uploadTargetPreviewVideoId;
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
                    if (!url) throw new Error('URL upload manquante');

                    const targetInput = document.getElementById(uploadTargetInputId);
                    if (targetInput) targetInput.value = url;
                    if (uploadTargetPreviewVideoId) setVideoPreview(uploadTargetPreviewVideoId, url);
                    else if (uploadTargetPreviewId) setPreview(uploadTargetPreviewId, url);
                } catch (err) {
                    alert(String(err));
                } finally {
                    input.value = '';
                }
            });
        })();
    </script>
@endsection
