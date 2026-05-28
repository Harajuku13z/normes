@php
    $h = $home ?? [];
    $slides = data_get($h, 'hero.slides', []);
    $first = $slides[0] ?? [];
    $isIdentity = !empty($first['identity']);
    $firstBg = \App\Support\HomeView::url(data_get($first, 'image', 'slide/toiture.png'));
    $firstBgFull = "linear-gradient(110deg, rgba(47,66,81,.80), rgba(47,66,81,.40)), url('".$firstBg."')";
    $avisUrl = data_get($h, 'sidebar_avis.google_url');
@endphp
<section id="top" class="relative overflow-hidden {{ $isIdentity ? 'min-h-[600px] sm:min-h-[700px]' : 'min-h-[540px] sm:min-h-[620px]' }}">
    <div id="heroBg" class="absolute inset-0 bg-cover bg-center transition-all duration-700" style="background-image:{{ $firstBgFull }}"></div>

    {{-- ===== SLIDE IDENTITÉ (PPF-style) ===== --}}
    <div id="heroIdentityBlock" class="{{ $isIdentity ? 'flex' : 'hidden' }} relative z-10 mx-auto min-h-[600px] w-[95%] flex-col justify-center gap-8 px-4 py-12 sm:min-h-[700px] sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:gap-12 lg:px-8">

        {{-- Colonne gauche --}}
        <div class="max-w-2xl flex-1 text-white">
            {{-- Badge --}}
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-brand-yellow/40 bg-brand-yellow/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-brand-yellow backdrop-blur-sm">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-yellow"></span>
                Rénovation énergétique · Bourgogne · Certifié RGE
            </div>

            {{-- Grand titre PPF-style --}}
            <div class="mb-2 leading-none">
                <span class="block text-5xl font-black tracking-tight drop-shadow sm:text-6xl lg:text-7xl">L'EXPERT<span class="text-brand-yellow">.</span></span>
                <span class="block text-3xl font-black uppercase tracking-tight text-brand-yellow drop-shadow sm:text-4xl lg:text-5xl">Rénovation Énergétique</span>
                <span class="mt-1 block text-xl font-semibold text-white/85 sm:text-2xl">et entretien de la maison en Bourgogne</span>
            </div>

            {{-- Description --}}
            <p class="mb-6 mt-4 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg">
                Normes &amp; Rénovation accompagne vos projets de rénovation, isolation, toiture et énergie solaire. Une équipe de professionnels certifiés RGE, à votre écoute en Bourgogne.
            </p>

            {{-- Stats PPF-style --}}
            <div class="mb-7 grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <div class="text-2xl font-black text-brand-yellow">+5 000</div>
                    <div class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-white/70">Chantiers réalisés</div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <div class="text-2xl font-black text-brand-yellow">RGE</div>
                    <div class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-white/70">Certifié Qualibat</div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <div class="text-2xl font-black text-brand-yellow">6</div>
                    <div class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-white/70">Corps de métier</div>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <div class="text-2xl font-black text-brand-yellow">48h</div>
                    <div class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-white/70">Prise en charge</div>
                </div>
            </div>

            {{-- CTAs --}}
            <div class="flex flex-wrap gap-3">
                <a href="#devis" class="inline-flex items-center gap-2 rounded-xl bg-brand-yellow px-6 py-3.5 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">
                    Devis gratuit <span>→</span>
                </a>
                <a href="#services" class="inline-flex items-center gap-2 rounded-xl bg-white/15 px-6 py-3.5 text-sm font-extrabold text-white shadow-soft backdrop-blur-sm transition hover:-translate-y-0.5 hover:bg-white/25">
                    Nos services
                </a>
                <a href="tel:+33385419886" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-brand-dark/40 px-6 py-3.5 text-sm font-extrabold text-white shadow-soft backdrop-blur-sm transition hover:-translate-y-0.5 hover:bg-brand-dark/60">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                    03 85 41 98 86
                </a>
            </div>
        </div>

        {{-- Colonne droite : carte certifications --}}
        <div class="hidden lg:flex lg:flex-shrink-0 lg:items-center lg:justify-center">
            <div class="relative w-72 xl:w-80">
                {{-- Cercle décoratif (comme PPF) --}}
                <div class="relative overflow-hidden rounded-[2.5rem] border-2 border-white/20 bg-white/10 p-6 shadow-[0_8px_60px_rgba(0,0,0,.4)] backdrop-blur-md">
                    {{-- Logo --}}
                    <div class="mb-4 flex justify-center">
                        <img src="/logo.png" alt="Normes & Rénovation" class="h-14 drop-shadow">
                    </div>
                    {{-- Score avis --}}
                    <div class="mb-4 rounded-xl bg-white/15 px-4 py-3 text-center">
                        <div class="text-2xl font-black text-white">5.0 / 5</div>
                        <div class="mt-0.5 text-sm text-brand-yellow">★★★★★</div>
                        <div class="mt-0.5 text-xs font-semibold text-white/70">+100 avis Google</div>
                    </div>
                    {{-- USPs --}}
                    <ul class="space-y-2 text-sm text-white/90">
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-brand-yellow text-xs font-black text-brand-dark">✓</span>
                            Devis gratuit &amp; sans engagement
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-brand-yellow text-xs font-black text-brand-dark">✓</span>
                            Entreprise certifiée RGE Qualibat
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-brand-yellow text-xs font-black text-brand-dark">✓</span>
                            Aides jusqu'à 90 % des travaux
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-brand-yellow text-xs font-black text-brand-dark">✓</span>
                            Intervention en Bourgogne
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Thumbnails en bas --}}
        <div id="heroThumbsIdentity" class="absolute bottom-6 left-1/2 flex -translate-x-1/2 gap-2">
            @foreach ($slides as $idx => $slide)
                @php
                    $n = $idx + 1;
                    $u = \App\Support\HomeView::url(data_get($slide, 'image'));
                @endphp
                <button type="button"
                    class="hero-thumb h-2 rounded-full transition-all duration-300 {{ $n === 1 ? 'w-8 bg-brand-yellow' : 'w-2 bg-white/40 hover:bg-white/70' }}"
                    data-bg="{{ $n }}"
                    style="background-image:none"
                    aria-label="Slide {{ $n }}">
                </button>
            @endforeach
        </div>
    </div>

    {{-- ===== SLIDES CLASSIQUES ===== --}}
    <div id="heroRegularBlock" class="{{ $isIdentity ? 'hidden' : 'flex' }} relative z-10 mx-auto min-h-[540px] w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                <h1 id="heroTitle" class="mb-3 text-4xl font-black leading-[1.02] tracking-tight drop-shadow sm:text-5xl lg:text-6xl">{{ data_get($first, 'title') }}</h1>
                <p id="heroSubtitle" class="mb-6 text-lg font-semibold text-slate-100/95 drop-shadow sm:text-xl">{{ data_get($first, 'subtitle') }}</p>
                <div class="flex flex-wrap gap-3">
                    <a id="heroPrimaryCta" href="{{ data_get($first, 'primary_href', '#devis') }}" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">{{ data_get($first, 'primary_text') }}</a>
                    <a id="heroSecondaryCta" href="{{ data_get($first, 'secondary_href', '#devis') }}" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">{{ data_get($first, 'secondary_text') }}</a>
                    <a id="heroLearnMoreCta" href="#services"
                       class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-white/15 bg-brand-dark px-5 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow">
                        En savoir plus <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>

        <div id="heroThumbs" class="flex w-full gap-2 pb-1 lg:w-auto">
            @foreach ($slides as $idx => $slide)
                @php
                    $n = $idx + 1;
                    $u = \App\Support\HomeView::url(data_get($slide, 'image'));
                    $thumbStyle = "background-image:url('".$u."')";
                @endphp
                <button type="button" class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 {{ $n === 1 ? 'border-brand-blue' : 'border-transparent' }} bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="{{ $n }}" style="{{ $thumbStyle }}" aria-label="Slider {{ $n }}"></button>
            @endforeach
        </div>
    </div>
</section>
