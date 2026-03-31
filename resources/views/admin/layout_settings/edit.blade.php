@extends('admin.layout')

@section('title', 'Header & Footer — Admin')

@section('content')
    @php
        $header = $merged['header'] ?? [];
        $footer = $merged['footer'] ?? [];
        $menuItems = data_get($header, 'menu_items', []);
        if (! is_array($menuItems)) {
            $menuItems = [];
        }
    @endphp

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Header & Footer</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Gérez ici le menu principal, le logo du header et tous les contenus du footer.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Retour
            </a>
        </div>
    </div>

    <form method="post" action="{{ route('admin.layout_settings.update') }}" class="space-y-5">
        @csrf

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Header (logo + menu principal)
            </summary>
            <div class="mt-4 space-y-4">
                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Logo header (URL)</label>
                        <input id="layoutHeaderLogo" type="text" name="sections[header][logo]" value="{{ data_get($header, 'logo') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                        <input id="layoutHeaderLogoUpload" type="file" accept="image/*" class="mt-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Alt logo</label>
                        <input type="text" name="sections[header][logo_alt]" value="{{ data_get($header, 'logo_alt') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Menu principal</p>
                    <p class="mt-1 text-xs text-slate-600">Choisissez une route existante et, si besoin, une ancre (ex: <code>services</code> pour <code>#services</code>).</p>

                    <div class="mt-3 space-y-3">
                        @for ($i = 0; $i < 10; $i++)
                            <div class="grid gap-2 rounded-lg border border-slate-200 bg-white p-3 lg:grid-cols-[1.4fr_1.2fr_1fr_1.2fr_0.8fr]">
                                <input
                                    type="text"
                                    name="sections[header][menu_items][{{ $i }}][label]"
                                    value="{{ data_get($menuItems, $i.'.label', '') }}"
                                    placeholder="Libellé (ex: Réalisations)"
                                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                >
                                <select
                                    name="sections[header][menu_items][{{ $i }}][route]"
                                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                >
                                    <option value="">Route</option>
                                    @foreach ($routeOptions as $opt)
                                        <option value="{{ $opt['value'] }}" @selected(data_get($menuItems, $i.'.route') === $opt['value'])>
                                            {{ $opt['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <input
                                    type="text"
                                    name="sections[header][menu_items][{{ $i }}][anchor]"
                                    value="{{ data_get($menuItems, $i.'.anchor', '') }}"
                                    placeholder="ancre"
                                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                >
                                <input
                                    type="text"
                                    name="sections[header][menu_items][{{ $i }}][custom_url]"
                                    value="{{ data_get($menuItems, $i.'.custom_url', '') }}"
                                    placeholder="URL perso (optionnel)"
                                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                >
                                <select
                                    name="sections[header][menu_items][{{ $i }}][style]"
                                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                                >
                                    <option value="">Normal</option>
                                    <option value="cta" @selected(data_get($menuItems, $i.'.style') === 'cta')>CTA</option>
                                </select>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </details>

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Footer
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[footer]',
                    'value' => $footer,
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

    @push('scripts')
    <script>
        async function uploadToInput(fileInputId, targetInputId) {
            const fileInput = document.getElementById(fileInputId);
            const targetInput = document.getElementById(targetInputId);
            if (!fileInput || !targetInput) return;
            fileInput.addEventListener('change', async () => {
                if (!fileInput.files || !fileInput.files[0]) return;
                const fd = new FormData();
                fd.append('file', fileInput.files[0]);
                try {
                    const res = await fetch(@json(route('admin.upload')), {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': @json(csrf_token()), 'Accept': 'application/json' },
                        body: fd,
                        credentials: 'same-origin',
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok || !data.url) throw new Error(data.message || 'Erreur upload');
                    targetInput.value = data.url;
                } catch (err) {
                    alert(String(err));
                }
            });
        }
        uploadToInput('layoutHeaderLogoUpload', 'layoutHeaderLogo');
    </script>
    @endpush
@endsection
