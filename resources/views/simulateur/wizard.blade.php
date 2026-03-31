@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $s = is_array($state ?? null) ? $state : [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = 'Simulateur devis | '.$siteName;
@endphp
<!DOCTYPE html>
<html lang="fr">
@include('home.head', [
    'home' => $h,
    'title' => $metaTitle,
    'description' => 'Simulateur de devis rénovation en plusieurs étapes.',
    'canonicalUrl' => route('simulateur.step1'),
])
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex w-[95%] items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <img src="{{ $logo }}" alt="Logo {{ $siteName }}" class="h-10 w-auto">
                <span class="text-sm font-extrabold text-slate-700">Simulateur de devis</span>
            </a>
            <a href="{{ route('home') }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">
                Retour au site
            </a>
        </div>
    </header>

    <main class="mx-auto w-[95%] max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Étapes du simulateur</p>
            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-4">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="rounded-xl px-3 py-2 text-center text-xs font-extrabold {{ (int) $step === $i ? 'bg-brand-blue text-white' : ((int) $step > $i ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500') }}">
                        Étape {{ $i }}
                    </div>
                @endfor
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ((int) $step === 1)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Infos maison</h1>
                <p class="mt-1 text-sm text-slate-600">Nom, code postal et surface pour lancer une première estimation.</p>

                <form method="post" action="{{ route('simulateur.step1.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-semibold">Nom et prénom</label>
                        <input name="nom_prenom" value="{{ old('nom_prenom', data_get($s, 'nom_prenom', '')) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Code postal</label>
                        <input name="code_postal" value="{{ old('code_postal', data_get($s, 'code_postal', '')) }}" required maxlength="5" inputmode="numeric" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Surface maison (m²)</label>
                        <input name="surface_m2" value="{{ old('surface_m2', data_get($s, 'surface_m2', '')) }}" required type="number" min="10" step="1" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-semibold">Adresse (optionnel)</label>
                        <input name="address" value="{{ old('address', data_get($s, 'address', '')) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div class="sm:col-span-2 pt-1">
                        <button class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">Continuer</button>
                    </div>
                </form>
            </section>
        @endif

        @if ((int) $step === 2)
            @php
                $selectedSlug = old('service_slug', data_get($s, 'service_slug', ''));
                $selectedSub = old('sub_service', data_get($s, 'sub_service', ''));
                $serviceMap = collect($services)->mapWithKeys(fn ($sv) => [(string) data_get($sv, 'slug') => (array) data_get($sv, 'sub_services', [])])->all();
            @endphp
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Service et sous-service</h1>
                <p class="mt-1 text-sm text-slate-600">Choisissez le service principal puis le sous-service correspondant.</p>

                <form method="post" action="{{ route('simulateur.step2.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-semibold">Service</label>
                        <select id="simService" name="service_slug" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                            <option value="">Sélectionner un service</option>
                            @foreach ($services as $sv)
                                <option value="{{ data_get($sv, 'slug') }}" @selected($selectedSlug === data_get($sv, 'slug'))>
                                    {{ data_get($sv, 'title') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-semibold">Sous-service</label>
                        <select id="simSubService" name="sub_service" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                            <option value="">Sélectionner un sous-service (optionnel)</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2 pt-1 flex gap-2">
                        <a href="{{ route('simulateur.step1') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">Continuer</button>
                    </div>
                </form>
            </section>

            <script>
                (function () {
                    const map = @json($serviceMap);
                    const selectedSub = @json($selectedSub);
                    const serviceEl = document.getElementById('simService');
                    const subEl = document.getElementById('simSubService');
                    if (!serviceEl || !subEl) return;
                    const renderSub = () => {
                        const slug = serviceEl.value || '';
                        const subs = Array.isArray(map[slug]) ? map[slug] : [];
                        subEl.innerHTML = '<option value="">Sélectionner un sous-service (optionnel)</option>';
                        subs.forEach((name) => {
                            const opt = document.createElement('option');
                            opt.value = name;
                            opt.textContent = name;
                            if (name === selectedSub) opt.selected = true;
                            subEl.appendChild(opt);
                        });
                    };
                    serviceEl.addEventListener('change', renderSub);
                    renderSub();
                })();
            </script>
        @endif

        @if ((int) $step === 3)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Message et photos</h1>
                <p class="mt-1 text-sm text-slate-600">Ajoutez des précisions et des photos/documents si besoin.</p>

                <form method="post" action="{{ route('simulateur.step3.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Message</label>
                        <textarea name="message" rows="4" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">{{ old('message', data_get($s, 'message', '')) }}</textarea>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Photos / documents (optionnel)</label>
                        <input type="file" name="photos[]" multiple accept="image/*,application/pdf" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                        <p class="mt-1 text-xs text-slate-500">Formats autorisés : JPG, PNG, WEBP, PDF (max 12 Mo/fichier).</p>
                    </div>
                    <div class="pt-1 flex gap-2">
                        <a href="{{ route('simulateur.step2') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">Continuer</button>
                    </div>
                </form>
            </section>
        @endif

        @if ((int) $step === 4)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Validation finale</h1>
                <p class="mt-1 text-sm text-slate-600">Tout est prêt. Ajoutez votre téléphone pour qu’un conseiller vous rappelle.</p>

                <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm">
                    <p><span class="font-extrabold">Nom :</span> {{ data_get($s, 'nom_prenom', '-') }}</p>
                    <p><span class="font-extrabold">Code postal :</span> {{ data_get($s, 'code_postal', '-') }}</p>
                    <p><span class="font-extrabold">Surface :</span> {{ data_get($s, 'surface_m2', '-') }} m²</p>
                    <p><span class="font-extrabold">Service :</span> {{ data_get($s, 'service_title', '-') }}</p>
                    <p><span class="font-extrabold">Sous-service :</span> {{ data_get($s, 'sub_service', '-') ?: '—' }}</p>
                </div>

                <form method="post" action="{{ route('simulateur.finish') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Téléphone</label>
                        <input name="telephone" value="{{ old('telephone', data_get($s, 'telephone', '')) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Email (optionnel)</label>
                        <input name="email" value="{{ old('email', data_get($s, 'email', '')) }}" type="email" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div class="sm:col-span-2 pt-1 flex gap-2">
                        <a href="{{ route('simulateur.step3') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-emerald-700">Valider mon simulateur</button>
                    </div>
                </form>
            </section>
        @endif
    </main>
</body>
</html>
