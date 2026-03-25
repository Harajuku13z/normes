@extends('admin.layout')

@section('title', $label.' — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-sky-700 hover:underline">← Retour</a>
            <h1 class="mt-2 text-2xl font-extrabold text-slate-900">{{ $label }}</h1>
            <p class="mt-1 font-mono text-xs text-slate-500">{{ $key }}</p>
        </div>
    </div>

    <form method="post" action="{{ route('admin.section.update', $key) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="payload" class="mb-2 block text-sm font-semibold text-slate-800">Contenu JSON</label>
            <textarea id="payload" name="payload" rows="28" class="w-full rounded-xl border border-slate-300 bg-white p-4 font-mono text-sm leading-relaxed focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>{{ old('payload', $payloadJson) }}</textarea>
            @error('payload')
                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button type="submit" class="rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-extrabold text-white hover:bg-slate-800">Enregistrer</button>
        </div>
    </form>

    <div class="mt-10 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5">
        <p class="text-sm font-extrabold text-slate-900">Envoyer une image</p>
        <p class="mt-1 text-xs text-slate-600">Le fichier est stocké dans <code class="rounded bg-white px-1">storage/app/public/uploads</code>. Copiez l'URL retournée dans votre JSON (champ image, logo, etc.).</p>
        <form id="uploadForm" class="mt-4 flex flex-wrap items-end gap-3">
            @csrf
            <div>
                <label for="file" class="mb-1 block text-xs font-semibold text-slate-700">Fichier</label>
                <input id="file" name="file" type="file" accept="image/*" class="text-sm">
            </div>
            <button type="submit" class="rounded-lg bg-white px-4 py-2 text-sm font-bold text-slate-800 ring-1 ring-slate-300 hover:bg-slate-100">Uploader</button>
        </form>
        <pre id="uploadOut" class="mt-3 hidden whitespace-pre-wrap break-all rounded-lg bg-white p-3 text-xs text-slate-800 ring-1 ring-slate-200"></pre>
    </div>

    <script>
        document.getElementById('uploadForm')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const fd = new FormData(form);
            const out = document.getElementById('uploadOut');
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
@endsection
