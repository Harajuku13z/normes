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
                Modifiez les blocs de la page d’accueil via des formulaires. Les valeurs sont enregistrées dans `home_sections`.
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
                        @include('admin.homepage.partials.form', [
                            'name' => "sections[{$key}]",
                            'value' => $value,
                            'depth' => 0
                        ])
                    </div>
                </details>
            @endforeach
        </div>

        @php
            $footerSocial = data_get($merged, 'footer.social', []);
            $socialByNetwork = [];
            if (is_array($footerSocial)) {
                foreach ($footerSocial as $entry) {
                    if (! is_array($entry)) {
                        continue;
                    }
                    $network = trim((string) ($entry['network'] ?? ''));
                    if ($network === '') {
                        continue;
                    }
                    $socialByNetwork[$network] = $entry;
                }
            }
            $socialUiItems = [
                ['key' => 'facebook', 'label' => 'Facebook', 'placeholder' => 'https://www.facebook.com/...'],
                ['key' => 'linkedin', 'label' => 'LinkedIn', 'placeholder' => 'https://www.linkedin.com/company/...'],
                ['key' => 'instagram', 'label' => 'Instagram', 'placeholder' => 'https://www.instagram.com/...'],
            ];
        @endphp
        <div id="contact-settings" class="scroll-mt-24 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4">
                <h2 class="text-sm font-extrabold text-slate-900">Paramètres page contact — Réseaux sociaux</h2>
                <p class="mt-1 text-xs text-slate-500">Renseigne les URLs officielles. Ces liens sont utilisés dans le footer et la section Réseaux sociaux de la page Contact.</p>
            </div>
            <div class="grid gap-4 lg:grid-cols-3">
                @foreach ($socialUiItems as $idx => $net)
                    @php
                        $entry = $socialByNetwork[$net['key']] ?? [];
                        $urlValue = (string) ($entry['url'] ?? '');
                        $labelValue = (string) ($entry['label'] ?? $net['label'].' Normes & Rénovation');
                    @endphp
                    <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $net['label'] }}</p>
                        <input type="hidden" name="sections[footer][social][{{ $idx }}][network]" value="{{ $net['key'] }}">
                        <input type="hidden" name="sections[footer][social][{{ $idx }}][label]" value="{{ $labelValue }}">
                        <label class="mt-3 block text-xs font-semibold text-slate-600">Lien</label>
                        <input
                            type="url"
                            name="sections[footer][social][{{ $idx }}][url]"
                            value="{{ old("sections.footer.social.$idx.url", $urlValue) }}"
                            placeholder="{{ $net['placeholder'] }}"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        >
                    </div>
                @endforeach
            </div>
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

