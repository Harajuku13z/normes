@php
    /** @var \App\Models\EmailSignature $signature */
    $isEdit = $isEdit ?? false;
    $previewUrl = $isEdit && $signature->exists ? route('email_signatures.show', $signature->slug) : null;
    $htmlUrl = $isEdit && $signature->exists ? route('email_signatures.html', $signature->slug) : null;
    $downloadUrl = $isEdit && $signature->exists ? route('email_signatures.download', $signature->slug) : null;
    $previewPhotoUrl = \App\Support\HomeView::url(old('photo_path', $signature->photo_path ?? ''));
@endphp

@extends('admin.layout')

@section('title', $isEdit ? 'Modifier une signature mail' : 'Nouvelle signature mail')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isEdit ? 'Modifier la signature mail' : 'Créer une signature mail' }}</h1>
            <p class="mt-2 max-w-3xl text-sm text-slate-600">
                Remplissez les informations de l’employé, chargez sa photo, puis copiez le HTML généré pour Gmail.
            </p>
        </div>
        <a href="{{ route('admin.email_signatures.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Retour à la liste
        </a>
    </div>

    <form
        method="post"
        action="{{ $isEdit ? route('admin.email_signatures.update', $signature) : route('admin.email_signatures.store') }}"
        class="grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_minmax(360px,0.9fr)]"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Nom complet</label>
                    <input
                        name="full_name"
                        required
                        value="{{ old('full_name', $signature->full_name ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Sylvain Duvernoy"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Poste</label>
                    <input
                        name="role_title"
                        value="{{ old('role_title', $signature->role_title ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Gérant"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Slug public</label>
                    <input
                        name="slug"
                        value="{{ old('slug', $signature->slug ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 font-mono text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="sylvain-duvernoy"
                    >
                    <p class="mt-1 text-xs text-slate-500">Laisser vide pour le générer automatiquement à partir du nom.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Mail</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $signature->email ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="prenom@normesrenovation.fr"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Téléphone</label>
                    <input
                        name="phone"
                        value="{{ old('phone', $signature->phone ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="+33 6 33 53 21 23"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Ville / agence</label>
                    <input
                        name="location"
                        value="{{ old('location', $signature->location ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Chalon-sur-Saône"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Site web</label>
                    <input
                        type="url"
                        name="website_url"
                        value="{{ old('website_url', $signature->website_url ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="https://normesrenovation.fr"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Texte d’accroche</label>
                    <input
                        name="tagline"
                        value="{{ old('tagline', $signature->tagline ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Toiture, façade, isolation et rénovation de l'habitat."
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Facebook</label>
                    <input
                        type="url"
                        name="facebook_url"
                        value="{{ old('facebook_url', $signature->facebook_url ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="https://facebook.com/..."
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Instagram</label>
                    <input
                        type="url"
                        name="instagram_url"
                        value="{{ old('instagram_url', $signature->instagram_url ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="https://instagram.com/..."
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">LinkedIn</label>
                    <input
                        type="url"
                        name="linkedin_url"
                        value="{{ old('linkedin_url', $signature->linkedin_url ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="https://linkedin.com/..."
                    >
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Photo du collaborateur</h2>
                        <p class="mt-1 text-sm text-slate-500">Charge une photo depuis l’admin ou colle un chemin existant.</p>
                    </div>
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        @if ($previewPhotoUrl !== '')
                            <img id="signature-photo-preview" src="{{ $previewPhotoUrl }}" alt="" class="h-full w-full object-cover">
                        @else
                            <img id="signature-photo-preview" src="" alt="" class="hidden h-full w-full object-cover">
                            <span id="signature-photo-placeholder" class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Aperçu</span>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-sm font-semibold text-slate-800">Chemin image</label>
                    <input
                        id="signature-photo-path"
                        name="photo_path"
                        value="{{ old('photo_path', $signature->photo_path ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="uploads/portrait-employe.png"
                    >
                    <input
                        id="signature-photo-file"
                        type="file"
                        accept="image/*"
                        class="mt-3 w-full text-sm"
                    >
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="text-sm font-semibold text-slate-800">Ordre d’affichage</label>
                    <input
                        type="number"
                        min="0"
                        name="sort_order"
                        value="{{ old('sort_order', $signature->sort_order ?? 0) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    >
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-800">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', $signature->is_active ?? true))
                            class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                        >
                        Signature active
                    </label>
                    <p class="mt-2 text-xs text-slate-500">Une signature inactive n’est pas visible sur l’URL publique.</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                    {{ $isEdit ? 'Enregistrer la signature' : 'Créer la signature' }}
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Aperçu</h2>
                        <p class="mt-1 text-sm text-slate-500">Rendu de la signature dans la maquette finale, prêt à contrôler avant copie.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if ($previewUrl)
                            <a href="{{ $previewUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                                Ouvrir la preview
                            </a>
                        @endif
                        @if ($htmlUrl)
                            <a href="{{ $htmlUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-extrabold text-white hover:bg-slate-800">
                                Ouvrir le code HTML
                            </a>
                        @endif
                        @if ($downloadUrl)
                            <a href="{{ $downloadUrl }}" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                                Télécharger la signature
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto rounded-[28px] bg-[#f0f2f5] p-5">
                    @if ($signatureHtml)
                        {!! $signatureHtml !!}
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-8 text-sm text-slate-500">
                            Enregistre d’abord la fiche pour générer l’aperçu HTML et la zone de copie Gmail.
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">HTML prêt à copier</h2>
                        <p class="mt-1 text-sm text-slate-500">Bouton admin pour récupérer directement le code à coller dans Gmail.</p>
                    </div>
                    @if ($signatureHtml)
                        <button type="button" id="copy-signature-html" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-extrabold text-white hover:bg-slate-800">
                            Copier le code HTML
                        </button>
                    @endif
                </div>

                <textarea
                    id="signature-html-output"
                    rows="18"
                    readonly
                    class="mt-4 w-full rounded-2xl border border-slate-300 bg-slate-950 px-4 py-4 font-mono text-xs leading-6 text-slate-100 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                >{{ $signatureHtml }}</textarea>
            </div>
        </div>
    </form>

    @if ($isEdit && $signature->exists)
        <form
            action="{{ route('admin.email_signatures.destroy', $signature) }}"
            method="post"
            class="mt-6"
            onsubmit="return confirm('Supprimer cette signature mail ?');"
        >
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-6 py-3 text-sm font-extrabold text-red-800 hover:bg-red-100">
                Supprimer la signature
            </button>
        </form>
    @endif

    <script>
        (function () {
            const uploadUrl = @json(route('admin.upload'));
            const csrfToken = @json(csrf_token());
            const pathInput = document.getElementById('signature-photo-path');
            const fileInput = document.getElementById('signature-photo-file');
            const preview = document.getElementById('signature-photo-preview');
            const placeholder = document.getElementById('signature-photo-placeholder');
            const copyButton = document.getElementById('copy-signature-html');
            const output = document.getElementById('signature-html-output');

            fileInput?.addEventListener('change', async function () {
                const file = fileInput.files && fileInput.files[0];
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
                    if (pathInput) pathInput.value = data.path || data.url || '';
                    if (preview && data.url) {
                        preview.src = data.url;
                        preview.classList.remove('hidden');
                    }
                    placeholder?.classList.add('hidden');
                } catch (err) {
                    alert(String(err));
                } finally {
                    fileInput.value = '';
                }
            });

            pathInput?.addEventListener('input', function () {
                const value = (pathInput.value || '').trim();
                if (!preview) return;
                if (value === '') {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder?.classList.remove('hidden');
                    return;
                }
                const absolute = /^https?:\/\//i.test(value) ? value : '/' + value.replace(/^\/+/, '');
                preview.src = absolute;
                preview.classList.remove('hidden');
                placeholder?.classList.add('hidden');
            });

            copyButton?.addEventListener('click', async function () {
                if (!output) return;
                output.select();
                output.setSelectionRange(0, output.value.length);
                try {
                    await navigator.clipboard.writeText(output.value);
                    copyButton.textContent = 'HTML copié';
                    setTimeout(function () {
                        copyButton.textContent = 'Copier le HTML';
                    }, 1800);
                } catch (err) {
                    document.execCommand('copy');
                }
            });
        })();
    </script>
@endsection
