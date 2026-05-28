@php
    $h = $home ?? [];
    $slides = data_get($h, 'hero.slides', []);
    $first = $slides[0] ?? [];
    $isIdentity = !empty($first['identity']);
    $firstBg = \App\Support\HomeView::url(data_get($first, 'image', 'slide/toiture.png'));
    $firstBgFull = $isIdentity
        ? "url('".$firstBg."')"
        : "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('".$firstBg."')";
@endphp

<section id="top" class="relative overflow-hidden {{ $isIdentity ? 'min-h-[680px] sm:min-h-[780px]' : 'min-h-[580px] sm:min-h-[660px]' }}">

    {{-- Fond image --}}
    <div id="heroBg" class="absolute inset-0 bg-cover bg-center transition-all duration-700" style="background-image:{{ $firstBgFull }}"></div>

    {{-- ===================================================
         SLIDE 1 — IDENTITÉ : layout magazine plein écran
         =================================================== --}}
    <div id="heroIdentityBlock"
         class="{{ $isIdentity ? 'flex' : 'hidden' }} absolute inset-0 z-10">

        {{-- Dégradé latéral : sombre à gauche, transparent à droite --}}
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark/95 via-brand-dark/70 to-brand-dark/10 pointer-events-none"></div>
        {{-- Dégradé bas pour lisibilité miniatures --}}
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-brand-dark/60 to-transparent pointer-events-none"></div>

        {{-- Contenu texte — colonne gauche --}}
        <div class="relative z-10 flex h-full w-full max-w-3xl flex-col justify-center px-8 py-12 sm:px-12 lg:px-16 xl:px-20">

            {{-- Eyebrow badge --}}
            <div class="mb-6 inline-flex w-fit items-center gap-2 rounded-full border border-brand-yellow/50 bg-brand-yellow/15 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.18em] text-brand-yellow backdrop-blur-sm">
                <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-brand-yellow"></span>
                Expert rénovation · Bourgogne · Certifié RGE
            </div>

            {{-- Titre principal --}}
            <h1 class="mb-4 leading-none text-white">
                <span class="block text-[2.6rem] font-black tracking-tight drop-shadow-lg sm:text-[3.4rem] lg:text-[4.2rem] xl:text-[5rem]">L'EXPERT<span class="text-brand-yellow">.</span></span>
                <span class="block text-[1.8rem] font-black uppercase tracking-tight text-brand-yellow drop-shadow sm:text-[2.4rem] lg:text-[3rem]">Rénovation Énergétique</span>
                <span class="mt-2 block text-lg font-semibold text-white/80 sm:text-xl lg:text-2xl">et entretien de la maison en Bourgogne</span>
            </h1>

            {{-- Description --}}
            <p class="mb-7 max-w-lg text-[0.95rem] leading-relaxed text-white/75 sm:text-base lg:text-lg">
                Toiture, isolation, énergie solaire, ventilation — une équipe certifiée RGE à vos côtés pour chaque projet de rénovation.
            </p>

            {{-- Stats inline --}}
            <div class="mb-8 flex flex-wrap gap-x-6 gap-y-3">
                @foreach ([
                    ['+5 000', 'chantiers'],
                    ['98 %',   'satisfaction'],
                    ['RGE',    'certifié'],
                    ['48 h',   'prise en charge'],
                ] as [$val, $lbl])
                <div class="flex items-center gap-2">
                    <span class="text-xl font-black text-brand-yellow sm:text-2xl">{{ $val }}</span>
                    <span class="text-xs font-semibold uppercase tracking-wide text-white/60">{{ $lbl }}</span>
                </div>
                @endforeach
            </div>

            {{-- CTAs --}}
            <div class="flex flex-wrap gap-3">
                <a href="#devis"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-yellow px-7 py-3.5 text-sm font-extrabold text-brand-dark shadow-[0_4px_24px_rgba(251,191,36,.4)] transition hover:-translate-y-0.5 hover:bg-yellow-300 hover:shadow-[0_6px_28px_rgba(251,191,36,.55)]">
                    Devis gratuit &nbsp;→
                </a>
                <a href="#services"
                   class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 px-7 py-3.5 text-sm font-extrabold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:border-white/60 hover:bg-white/20">
                    Nos services
                </a>
                <a href="tel:+33385419886"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-dark/60 px-5 py-3.5 text-sm font-bold text-white/90 backdrop-blur-sm transition hover:-translate-y-0.5 hover:bg-brand-dark/80">
                    <svg class="h-4 w-4 text-brand-yellow" fill="currentColor" viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                    03 85 41 98 86
                </a>
            </div>

            {{-- Badge avis flottant --}}
            <div class="mt-8 inline-flex w-fit items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 backdrop-blur-sm">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-brand-yellow text-sm font-black text-brand-dark">5.0</div>
                <div>
                    <div class="text-xs font-bold text-white">Avis Google vérifiés</div>
                    <div class="text-sm text-brand-yellow">★★★★★ <span class="text-white/60 text-xs">+100 avis</span></div>
                </div>
                <div class="ml-2 rounded-lg bg-brand-dark/50 px-2.5 py-1 text-xs font-extrabold uppercase tracking-wide text-brand-yellow">
                    ✓ RGE
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================
         SLIDES CLASSIQUES (2, 3…)
         =================================================== --}}
    <div id="heroRegularBlock"
         class="{{ $isIdentity ? 'hidden' : 'flex' }} relative z-10 mx-auto w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8"
         style="min-height:inherit">

        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                <h1 id="heroTitle" class="mb-3 text-4xl font-black leading-[1.02] tracking-tight drop-shadow sm:text-5xl lg:text-6xl">{{ data_get($first, 'title') }}</h1>
                <p id="heroSubtitle" class="mb-6 text-lg font-semibold text-slate-100/95 drop-shadow sm:text-xl">{{ data_get($first, 'subtitle') }}</p>
                <div class="flex flex-wrap gap-3">
                    <a id="heroPrimaryCta" href="{{ data_get($first, 'primary_href', '#devis') }}"
                       class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">{{ data_get($first, 'primary_text') }}</a>
                    <a id="heroSecondaryCta" href="{{ data_get($first, 'secondary_href', '#devis') }}"
                       class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">{{ data_get($first, 'secondary_text') }}</a>
                    <a id="heroLearnMoreCta" href="#services"
                       class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-white/15 bg-brand-dark px-5 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-slate-900">
                        En savoir plus <span>→</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="hidden lg:block lg:w-[280px]"></div>
    </div>

    {{-- ===================================================
         MINIATURES — toujours visibles, bas-droite
         =================================================== --}}
    <div id="heroThumbs"
         class="absolute bottom-5 right-5 z-20 flex gap-2 sm:bottom-6 sm:right-6">
        @foreach ($slides as $idx => $slide)
            @php
                $n   = $idx + 1;
                $u   = \App\Support\HomeView::url(data_get($slide, 'image'));
                $act = $n === 1 ? 'border-brand-yellow' : 'border-white/40';
            @endphp
            <button type="button"
                    class="hero-thumb h-16 w-24 overflow-hidden rounded-xl border-2 {{ $act }} bg-cover bg-center shadow-[0_4px_16px_rgba(0,0,0,.5)] transition-all duration-300 hover:scale-105 hover:border-brand-yellow sm:h-20 sm:w-28"
                    data-bg="{{ $n }}"
                    style="background-image:url('{{ $u }}')"
                    aria-label="Slide {{ $n }}">
            </button>
        @endforeach
    </div>

</section>
