@extends('admin.layout')

@section('title', 'Header — Admin')

@section('content')
    @php
        $menuItems = data_get($header, 'menu_items', []);
        if (! is_array($menuItems)) {
            $menuItems = [];
        }
    @endphp

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Header</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Modifie le logo, les menus et les routes associées du header principal.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Retour
        </a>
    </div>

    <form method="post" action="{{ route('admin.header_settings.update') }}" class="space-y-5">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-extrabold text-slate-900">Logo</h2>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Logo header (URL)</label>
                    <input id="headerLogoUrl" type="text" name="header[logo]" value="{{ data_get($header, 'logo') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    <input id="headerLogoUpload" type="file" accept="image/*" class="mt-2 w-full text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Alt logo</label>
                    <input type="text" name="header[logo_alt]" value="{{ data_get($header, 'logo_alt') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-extrabold text-slate-900">Menu principal</h2>
            <p class="mt-1 text-xs text-slate-600">Sélectionne une route, puis ajoute une ancre si besoin (ex: <code>services</code> => <code>#services</code>).</p>

            <div class="mt-3 space-y-3">
                @for ($i = 0; $i < 12; $i++)
                    <div class="grid gap-2 rounded-lg border border-slate-200 bg-slate-50 p-3 lg:grid-cols-[1.4fr_1.2fr_1fr_1.3fr_0.8fr]">
                        <input
                            type="text"
                            name="header[menu_items][{{ $i }}][label]"
                            value="{{ data_get($menuItems, $i.'.label', '') }}"
                            placeholder="Libellé (ex: Réalisations)"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                        >
                        <select
                            name="header[menu_items][{{ $i }}][route]"
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
                            name="header[menu_items][{{ $i }}][anchor]"
                            value="{{ data_get($menuItems, $i.'.anchor', '') }}"
                            placeholder="ancre"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                        >
                        <input
                            type="text"
                            name="header[menu_items][{{ $i }}][custom_url]"
                            value="{{ data_get($menuItems, $i.'.custom_url', '') }}"
                            placeholder="URL perso (optionnel)"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                        >
                        <select
                            name="header[menu_items][{{ $i }}][style]"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                        >
                            <option value="">Normal</option>
                            <option value="cta" @selected(data_get($menuItems, $i.'.style') === 'cta')>CTA</option>
                        </select>
                    </div>
                @endfor
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer le header
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        (function () {
            const fileInput = document.getElementById('headerLogoUpload');
            const targetInput = document.getElementById('headerLogoUrl');
            if (!fileInput || !targetInput) return;

            fileInput.addEventListener('change', async function () {
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
                } finally {
                    fileInput.value = '';
                }
            });
        })();
    </script>
    @endpush
@endsection

