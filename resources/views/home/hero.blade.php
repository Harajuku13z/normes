@php
    $h = $home ?? [];
    $slides = data_get($h, 'hero.slides', []);
    $first = $slides[0] ?? [];
    $isIdentity = !empty($first['identity']);
    $firstBgPath = $isIdentity ? 'slide/hero-groupe-1.png' : (string) data_get($first, 'image', 'slide/toiture.png');
    $firstBg = \App\Support\HomeView::url($firstBgPath);
    $firstBgFull = $isIdentity
        ? "url('".$firstBg."')"
        : "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('".$firstBg."')";
    $identityStats = [
        ['value' => '+5 000', 'label' => 'Chantiers', 'accent' => 'text-brand-blue'],
        ['value' => '99.9%', 'label' => 'Satisfaction', 'accent' => 'text-brand-yellow'],
        ['value' => 'RGE', 'label' => 'Certifie', 'accent' => 'text-brand-blue'],
        ['value' => '24 h', 'label' => 'Reponse', 'accent' => 'text-brand-yellow'],
    ];
@endphp

<section id="top" class="relative overflow-hidden {{ $isIdentity ? 'min-h-[720px] sm:min-h-[800px] lg:min-h-[860px]' : 'min-h-[580px] sm:min-h-[660px]' }}">

    {{-- Fond image --}}
    <div id="heroBg"
         class="absolute inset-0 bg-cover transition-all duration-700"
         style="background-image:{{ $firstBgFull }};background-position:center center;background-repeat:no-repeat"></div>

    {{-- ===================================================
         SLIDE 1 — IDENTITÉ : style PPF blanc + couleurs marque
         =================================================== --}}
    <div id="heroIdentityBlock"
         class="{{ $isIdentity ? 'flex' : 'hidden' }} absolute inset-0 z-10 items-center">

        <div class="pointer-events-none absolute inset-0 md:hidden bg-[linear-gradient(180deg,rgba(255,255,255,.88)_0%,rgba(255,255,255,.8)_30%,rgba(255,255,255,.5)_58%,rgba(255,255,255,.08)_100%)]"></div>

        <div class="relative z-10 mx-auto flex w-full max-w-[1720px] items-center px-5 pb-28 pt-10 sm:px-8 sm:pb-32 lg:px-16 xl:px-20"
             style="min-height:inherit">
            <div class="w-full max-w-[940px]">
                <h1 style="font-family:'Anton',sans-serif;font-size:clamp(4.1rem,8vw,7.7rem);line-height:.86;letter-spacing:-0.05em"
                    class="max-w-[900px] text-brand-dark drop-shadow-[0_14px_22px_rgba(255,255,255,.26)]">
                    <span>Oui</span>
                    <span class="text-brand-blue"> c'est </span>
                    <span>nous!</span>
                </h1>

                <p style="font-family:'Anton',sans-serif;font-size:clamp(1.55rem,3vw,3.45rem);line-height:.94;letter-spacing:-0.03em"
                   class="mt-7 max-w-[820px] text-brand-dark/95">
                    L'expert en renovation energetique<br class="hidden lg:block">
                    et entretien de la maison en Bourgogne.
                </p>

                <div class="mt-8 w-full max-w-[780px] overflow-hidden rounded-[28px] border border-white/70 bg-white/70 px-3 py-4 shadow-[0_22px_48px_rgba(47,66,81,.12)] backdrop-blur-[2px] sm:px-4 sm:py-4">
                    <div class="grid grid-cols-4 gap-0">
                        @foreach ($identityStats as $index => $stat)
                            <div class="flex flex-col items-center justify-center px-2 text-center {{ $index > 0 ? 'border-l border-brand-dark/12' : '' }}">
                                <span style="font-family:'Anton',sans-serif;font-size:clamp(1.45rem,2.45vw,2.55rem);line-height:.9;letter-spacing:-0.03em"
                                      class="{{ $stat['accent'] }}">
                                    {{ $stat['value'] }}
                                </span>
                                <span style="font-family:'Anton',sans-serif;font-size:clamp(.8rem,1.05vw,1.18rem);line-height:.95;letter-spacing:-0.03em"
                                      class="mt-1 text-brand-dark">
                                    {{ $stat['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 flex w-full max-w-[820px] flex-col gap-3 sm:gap-4">
                    <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                        <a href="#services"
                           class="inline-flex min-h-[64px] items-center justify-center gap-2 rounded-[22px] border border-[#d4b13f] bg-brand-yellow px-6 py-4 text-[0.95rem] font-extrabold text-brand-dark shadow-[0_12px_22px_rgba(250,223,112,.22)] transition hover:-translate-y-0.5 hover:bg-yellow-300 sm:min-h-[72px] sm:text-[1.05rem] lg:text-[1.1rem]">
                            <span class="truncate">Découvrir nos services</span>
                        </a>
                        <a href="tel:+33385419886"
                           class="inline-flex min-h-[64px] items-center justify-center gap-3 rounded-[22px] border border-white/60 bg-[#56697f] px-6 py-4 text-[0.95rem] font-extrabold text-white shadow-[0_12px_22px_rgba(47,66,81,.22)] transition hover:-translate-y-0.5 hover:bg-[#4e6074] sm:min-h-[72px] sm:text-[1.05rem] lg:text-[1.1rem]">
                            <svg class="h-4 w-4 shrink-0 text-brand-blue sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                            <span class="tabular-nums tracking-[0.08em]">03 85 41 98 86</span>
                        </a>
                    </div>
                    <a href="#devis"
                       class="inline-flex min-h-[64px] w-full items-center justify-center gap-2 rounded-[22px] bg-brand-blue px-6 py-4 text-[1rem] font-extrabold text-white shadow-[0_16px_30px_rgba(96,180,249,.34)] transition hover:-translate-y-0.5 hover:bg-sky-400 sm:min-h-[72px] sm:text-[1.18rem] lg:text-[1.22rem]">
                        <span>Je demande un devis</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================
         SLIDES CLASSIQUES (2, 3…)
         =================================================== --}}
    <div id="heroRegularBlock"
         class="{{ $isIdentity ? 'hidden' : 'flex' }} relative z-10 mx-auto w-[95%] flex-col justify-end gap-5 px-4 pb-28 pt-8 sm:py-8 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8"
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
                $u   = ! empty($slide['identity'])
                    ? \App\Support\HomeView::url('slide/hero-groupe-1.png')
                    : \App\Support\HomeView::url(data_get($slide, 'image'));
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
