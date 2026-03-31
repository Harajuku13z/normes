@extends('admin.layout')

@section('title', 'Page contact — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Admin — Page contact</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Modifiez ici uniquement les données utilisées par la page contact (hero, formulaire, coordonnées, réseaux sociaux).
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Retour
            </a>
            <a href="{{ route('contact.page') }}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Voir la page contact
            </a>
        </div>
    </div>

    <form method="post" action="{{ route('admin.contact_settings.update') }}" class="space-y-5">
        @csrf

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Textes + visuels spécifiques page contact (section `contact_page`)
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[contact_page]',
                    'value' => $merged['contact_page'] ?? [],
                    'depth' => 0,
                ])
            </div>
        </details>

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Hero + Formulaire + Coordonnées agences (section `devis`)
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[devis]',
                    'value' => $merged['devis'] ?? [],
                    'depth' => 0,
                ])
            </div>
        </details>

        <details class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" open>
            <summary class="cursor-pointer select-none text-sm font-extrabold text-slate-900">
                Adresse, téléphone, email, réseaux sociaux (section `footer`)
            </summary>
            <div class="mt-4">
                @include('admin.homepage.partials.form', [
                    'name' => 'sections[footer]',
                    'value' => $merged['footer'] ?? [],
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

    <div class="mt-8 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5">
        <p class="text-sm font-extrabold text-slate-900">Uploader une image (hero / réseaux)</p>
        <p class="mt-1 text-xs text-slate-600">Uploadez ici, puis collez l’URL retournée dans <code class="rounded bg-white px-1">contact_page.hero_bg</code> ou <code class="rounded bg-white px-1">contact_page.social_bg</code>.</p>
        <form id="uploadFormContact" class="mt-4 flex flex-wrap items-end gap-3">
            @csrf
            <div>
                <label for="fileContact" class="mb-1 block text-xs font-semibold text-slate-700">Fichier</label>
                <input id="fileContact" name="file" type="file" accept="image/*" class="text-sm">
            </div>
            <button type="submit" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-slate-800 ring-1 ring-slate-300 hover:bg-slate-100">Uploader</button>
        </form>
        <pre id="uploadOutContact" class="mt-3 hidden whitespace-pre-wrap break-all rounded-lg bg-white p-3 text-xs text-slate-800 ring-1 ring-slate-200"></pre>
    </div>

    @push('scripts')
    <script>
        document.getElementById('uploadFormContact')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const fd = new FormData(form);
            const out = document.getElementById('uploadOutContact');
            out.classList.add('hidden');
            try {
                const res = await fetch(@json(route('admin.upload')), {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': @json(csrf_token()), 'Accept': 'application/json' },
                    body: fd,
                    credentials: 'same-origin',
                });
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(data.message || 'Erreur upload');
                out.textContent = data.url || JSON.stringify(data);
                out.classList.remove('hidden');
            } catch (err) {
                out.textContent = String(err);
                out.classList.remove('hidden');
            }
        });
    </script>
    @endpush
@endsection
