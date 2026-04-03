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
                Modifiez les blocs de la page d’accueil via des formulaires. Les valeurs sont enregistrées dans `home_sections`. La page <strong>À propos</strong> (<code class="text-xs">/a-propos</code>) se modifie dans le menu <a href="{{ route('admin.about_settings.edit') }}" class="font-semibold text-sky-700 hover:underline">Page À propos</a>.
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
                        @if ($key === 'stats')
                            @include('admin.homepage.partials.stats_form', [
                                'name' => "sections[stats]",
                                'value' => $value,
                            ])
                        @else
                            @include('admin.homepage.partials.form', [
                                'name' => "sections[{$key}]",
                                'value' => $value,
                                'depth' => 0
                            ])
                        @endif
                    </div>
                </details>
            @endforeach
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

