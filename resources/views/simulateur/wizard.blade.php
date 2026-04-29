@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $s = is_array($state ?? null) ? $state : [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = 'Simulateur devis | '.$siteName;
    $step = (int) ($step ?? 1);
    $step = max(1, min(5, $step));
    $stepTitles = [
        1 => 'Infos maison',
        2 => 'Choix du service',
        3 => 'Choix du sous-service',
        4 => 'Message et photos',
        5 => 'Validation finale',
    ];
    $stepTitle = $stepTitles[$step] ?? 'Étape';
    $callHref = trim((string) data_get($h, 'footer.phone_href', '+33385419886'));
    $callLabel = trim((string) data_get($h, 'footer.phone', '03 85 41 98 86'));
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
        <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="bg-gradient-to-r from-brand-dark to-slate-700 px-4 py-4 sm:px-5">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-yellow">Simulateur</p>
                <h2 class="mt-1 text-xl font-black text-white sm:text-2xl">{{ $stepTitle }}</h2>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-white/80">Étape {{ $step }} / 5</p>
            </div>
            <div class="px-4 py-4 sm:px-5">
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-slate-500">Progression réelle</p>
                <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-5">
                    @for ($i = 1; $i <= $step; $i++)
                        <div class="rounded-xl border px-3 py-2 text-center text-xs font-extrabold {{ $i === $step ? 'border-brand-blue bg-brand-blue text-white' : 'border-emerald-200 bg-emerald-50 text-emerald-700' }}">
                            {{ $i === $step ? 'En cours' : 'Validée' }} — Étape {{ $i }}
                        </div>
                    @endfor
                </div>
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
        @if (session('status'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($step === 1)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Infos maison</h1>
                <p class="mt-1 text-sm text-slate-600">Nom, téléphone, email, code postal et surface pour lancer une première estimation.</p>

                <form method="post" action="{{ route('simulateur.step1.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-semibold">Nom et prénom</label>
                        <input name="nom_prenom" value="{{ old('nom_prenom', data_get($s, 'nom_prenom', '')) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Téléphone</label>
                        <input name="telephone" value="{{ old('telephone', data_get($s, 'telephone', '')) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Email (optionnel)</label>
                        <input name="email" type="email" value="{{ old('email', data_get($s, 'email', '')) }}" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm">
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
                        <div class="flex flex-wrap gap-2">
                            <button class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">Continuer</button>
                            <a href="tel:{{ $callHref }}" class="rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-extrabold text-emerald-700 hover:bg-emerald-100">
                                Appeler tout de suite — {{ $callLabel }}
                            </a>
                        </div>
                    </div>
                </form>
            </section>
        @endif

        @if ($step === 2)
            @php
                $selectedSlugs = collect(old('service_slugs', data_get($s, 'service_slugs', [])))
                    ->map(fn ($v) => trim((string) $v))
                    ->filter(fn ($v) => $v !== '')
                    ->values()
                    ->all();
            @endphp
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Choisissez votre service</h1>
                <p class="mt-1 text-sm text-slate-600">Sélectionnez un ou plusieurs services, puis continuez.</p>

                <form id="simStep2Form" method="post" action="{{ route('simulateur.step2.store') }}" class="mt-5 grid gap-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold">Service</label>
                        <div id="simServiceCards" class="grid gap-3 sm:grid-cols-2">
                            @foreach ($services as $sv)
                                @php
                                    $slug = (string) data_get($sv, 'slug');
                                    $isSelected = in_array($slug, $selectedSlugs, true);
                                @endphp
                                <label class="js-service-card group relative overflow-hidden rounded-2xl border text-left shadow-sm transition cursor-pointer {{ $isSelected ? 'border-brand-blue ring-2 ring-brand-blue/30' : 'border-slate-200 hover:border-brand-blue/40' }}">
                                    <input type="checkbox" name="service_slugs[]" value="{{ $slug }}" class="sr-only js-service-checkbox" {{ $isSelected ? 'checked' : '' }}>
                                    <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100">
                                        <img src="{{ data_get($sv, 'image') }}" alt="{{ data_get($sv, 'title') }}" class="h-full w-full object-cover transition duration-200 group-hover:scale-[1.02]">
                                    </div>
                                    <div class="p-3">
                                        <p class="text-sm font-extrabold text-slate-900">{{ data_get($sv, 'title') }}</p>
                                        @if (trim((string) data_get($sv, 'subtitle')) !== '')
                                            <p class="mt-1 text-xs text-slate-600">{{ data_get($sv, 'subtitle') }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-1 flex gap-2">
                        <a href="{{ route('simulateur.step1') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button id="simStep2Continue" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500" disabled>Continuer</button>
                        <a href="tel:{{ $callHref }}" class="rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-extrabold text-emerald-700 hover:bg-emerald-100">
                            Appeler tout de suite
                        </a>
                    </div>
                </form>
            </section>

            <script>
                (function () {
                    const form = document.getElementById('simStep2Form');
                    const continueBtn = document.getElementById('simStep2Continue');
                    const serviceCards = Array.from(document.querySelectorAll('.js-service-card'));
                    const checkboxes = Array.from(document.querySelectorAll('.js-service-checkbox'));
                    if (!form || !continueBtn) return;

                    const updateServiceUI = () => {
                        serviceCards.forEach((card) => {
                            const box = card.querySelector('.js-service-checkbox');
                            const on = !!(box && box.checked);
                            card.classList.toggle('border-brand-blue', on);
                            card.classList.toggle('ring-2', on);
                            card.classList.toggle('ring-brand-blue/30', on);
                            card.classList.toggle('border-slate-200', !on);
                        });
                        continueBtn.disabled = !checkboxes.some((b) => b.checked);
                    };

                    checkboxes.forEach((box) => {
                        box.addEventListener('change', updateServiceUI);
                    });

                    updateServiceUI();
                })();
            </script>
        @endif

        @if ($step === 3)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                @php
                    $selected = is_array($selectedServices ?? null) ? $selectedServices : [];
                    $selectedSubs = collect(old('sub_services', data_get($s, 'sub_services', [])))
                        ->map(fn ($v) => trim((string) $v))
                        ->filter(fn ($v) => $v !== '')
                        ->values()
                        ->all();
                @endphp
                <h1 class="text-2xl font-black text-slate-900">Choisissez vos sous-services</h1>
                <p class="mt-1 text-sm text-slate-600">Sélectionnez un ou plusieurs sous-services liés à vos services.</p>

                <form method="post" action="{{ route('simulateur.step3.store') }}" class="mt-5 grid gap-4">
                    @csrf
                    <div>
                        <div id="simSubServiceCards" class="space-y-4">
                            @foreach ($selected as $sv)
                                @php
                                    $svTitle = (string) data_get($sv, 'title', '');
                                    $svSubs = is_array(data_get($sv, 'sub_services', [])) ? data_get($sv, 'sub_services', []) : [];
                                @endphp
                                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-3">
                                    <p class="mb-2 text-xs font-extrabold uppercase tracking-[0.18em] text-brand-blue">{{ $svTitle }}</p>
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        @foreach ($svSubs as $sub)
                                            @php
                                                $st = trim((string) data_get($sub, 'title', ''));
                                                if ($st === '') continue;
                                                $isSelected = in_array($st, $selectedSubs, true);
                                            @endphp
                                            <label class="js-sub-card group relative overflow-hidden rounded-2xl border text-left shadow-sm transition cursor-pointer {{ $isSelected ? 'border-brand-blue ring-2 ring-brand-blue/30' : 'border-slate-200 hover:border-brand-blue/40' }}">
                                                <input type="checkbox" name="sub_services[]" value="{{ $st }}" class="sr-only js-sub-checkbox" {{ $isSelected ? 'checked' : '' }}>
                                                <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100">
                                                    <img src="{{ data_get($sub, 'image') }}" alt="{{ $st }}" class="h-full w-full object-cover transition duration-200 group-hover:scale-[1.02]">
                                                </div>
                                                <div class="p-3">
                                                    <p class="text-sm font-extrabold text-slate-900">{{ $st }}</p>
                                                    @if (trim((string) data_get($sub, 'subtitle')) !== '')
                                                        <p class="mt-1 text-xs text-slate-600">{{ data_get($sub, 'subtitle') }}</p>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Optionnel : vous pouvez continuer sans sous-service.</p>
                    </div>
                    <div class="pt-1 flex gap-2">
                        <a href="{{ route('simulateur.step2') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">Continuer</button>
                        <a href="tel:{{ $callHref }}" class="rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-extrabold text-emerald-700 hover:bg-emerald-100">
                            Appeler tout de suite
                        </a>
                    </div>
                </form>
            </section>

            <script>
                (function () {
                    const cards = Array.from(document.querySelectorAll('.js-sub-card'));
                    const boxes = Array.from(document.querySelectorAll('.js-sub-checkbox'));
                    if (cards.length === 0) return;
                    const refresh = () => {
                        cards.forEach((card) => {
                            const box = card.querySelector('.js-sub-checkbox');
                            const on = !!(box && box.checked);
                            card.classList.toggle('border-brand-blue', on);
                            card.classList.toggle('ring-2', on);
                            card.classList.toggle('ring-brand-blue/30', on);
                            card.classList.toggle('border-slate-200', !on);
                        });
                    };
                    boxes.forEach((box) => {
                        box.addEventListener('change', refresh);
                    });
                    refresh();
                })();
            </script>
        @endif

        @if ($step === 4)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Message et photos</h1>
                <p class="mt-1 text-sm text-slate-600">Ajoutez des précisions et des photos/documents si besoin.</p>

                <form method="post" action="{{ route('simulateur.step4.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4">
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
                        <a href="{{ route('simulateur.step3') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">Continuer</button>
                        <a href="tel:{{ $callHref }}" class="rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-extrabold text-emerald-700 hover:bg-emerald-100">
                            Appeler tout de suite
                        </a>
                    </div>
                </form>
            </section>
        @endif

        @if ($step === 5)
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h1 class="text-2xl font-black text-slate-900">Validation finale</h1>
                <p class="mt-1 text-sm text-slate-600">Tout est prêt. Ajoutez votre téléphone pour qu’un conseiller vous rappelle.</p>

                <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm">
                    <p><span class="font-extrabold">Nom :</span> {{ data_get($s, 'nom_prenom', '-') }}</p>
                    <p><span class="font-extrabold">Code postal :</span> {{ data_get($s, 'code_postal', '-') }}</p>
                    <p><span class="font-extrabold">Surface :</span> {{ data_get($s, 'surface_m2', '-') }} m²</p>
                    <p><span class="font-extrabold">Services :</span> {{ collect((array) data_get($s, 'service_titles', []))->filter()->implode(', ') ?: '-' }}</p>
                    <p><span class="font-extrabold">Sous-services :</span> {{ collect((array) data_get($s, 'sub_services', []))->filter()->implode(', ') ?: '—' }}</p>
                </div>

                <form method="post" action="{{ route('simulateur.finish') }}" class="mt-5 grid gap-4 sm:grid-cols-2" id="simFinishForm" onsubmit="(function(f){var btn=f.querySelector('[data-finish-btn]');if(btn){btn.disabled=true;btn.textContent='Envoi en cours…';}})(this)">
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
                        <a href="{{ route('simulateur.step4') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">Retour</a>
                        <button type="submit" data-finish-btn class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed">Valider mon simulateur</button>
                        <a href="tel:{{ $callHref }}" class="rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-extrabold text-emerald-700 hover:bg-emerald-100">
                            Appeler tout de suite
                        </a>
                    </div>
                </form>
            </section>
        @endif
    </main>
</body>
</html>
