@php
    $h = $home ?? [];
    $slides = data_get($h, 'hero.slides', []);
    $first = $slides[0] ?? [];
    $isIdentity = !empty($first['identity']);
    $firstBg = \App\Support\HomeView::url(data_get($first, 'image', 'slide/toiture.png'));
    $firstBgFull = $isIdentity
        ? "linear-gradient(135deg, rgba(20,35,50,.55), rgba(47,66,81,.30)), url('".$firstBg."')"
        : "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('".$firstBg."')";
@endphp

<section id="top" class="relative overflow-hidden {{ $isIdentity ? 'min-h-[680px] sm:min-h-[760px]' : 'min-h-[580px] sm:min-h-[660px]' }}">

    {{-- Fond image --}}
    <div id="heroBg"
         class="absolute inset-0 bg-cover bg-center transition-all duration-700"
         style="background-image:{{ $firstBgFull }}">
    </div>

    {{-- ===================================================
         SLIDE 1 — IDENTITÉ (style PPF)
         =================================================== --}}
    <div id="heroIdentityBlock"
         class="{{ $isIdentity ? 'flex' : 'hidden' }} relative z-10 w-full flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8"
         style="min-height:inherit">

        <div class="mx-auto w-full max-w-6xl">

            {{-- Carte blanche principale --}}
            <div class="overflow-hidden rounded-3xl bg-white/96 shadow-[0_20px_80px_rgba(0,0,0,.35)] backdrop-blur-sm">

                {{-- Partie haute : 2 colonnes --}}
                <div class="flex flex-col lg:flex-row">

                    {{-- Colonne gauche : texte --}}
                    <div class="flex flex-1 flex-col justify-center p-8 sm:p-10 lg:p-12">

                        {{-- Eyebrow --}}
                        <p class="mb-4 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">
                            Rénovation énergétique · Bourgogne
                        </p>

                        {{-- Grand titre PPF --}}
                        <div class="mb-5 leading-none">
                            <span class="block text-[3.5rem] font-black leading-none tracking-tight text-brand-dark sm:text-[4.5rem] lg:text-[5.5rem]">QUI ?<span class="text-brand-yellow">•</span></span>
                            <span class="mt-1 block text-2xl font-black text-brand-dark sm:text-3xl lg:text-4xl">sommes-nous</span>
                        </div>

                        {{-- Description --}}
                        <p class="mb-7 max-w-lg text-base leading-relaxed text-brand-dark/70 sm:text-lg">
                            <strong class="font-bold text-brand-dark">Normes &amp; Rénovation</strong> est l'expert rénovation énergétique et entretien de la maison en Bourgogne. Toiture, isolation, énergie solaire, ventilation — une équipe certifiée RGE à vos côtés.
                        </p>

                        {{-- CTAs --}}
                        <div class="flex flex-wrap gap-3">
                            <a href="#devis"
                               class="inline-flex items-center gap-2 rounded-xl bg-brand-dark px-6 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-slate-700">
                                Devis gratuit <span>→</span>
                            </a>
                            <a href="#services"
                               class="inline-flex items-center gap-2 rounded-xl border-2 border-brand-dark px-6 py-3.5 text-sm font-extrabold text-brand-dark transition hover:-translate-y-0.5 hover:bg-brand-dark hover:text-white">
                                Nos services
                            </a>
                            <a href="tel:+33385419886"
                               class="inline-flex items-center gap-2 rounded-xl bg-brand-yellow px-6 py-3.5 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                                03 85 41 98 86
                            </a>
                        </div>
                    </div>

                    {{-- Colonne droite : image circulaire --}}
                    <div class="hidden items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 p-10 lg:flex lg:w-[340px] xl:w-[400px]">
                        <div class="relative">
                            {{-- Cercle image principal --}}
                            <div class="h-64 w-64 overflow-hidden rounded-full border-4 border-white shadow-[0_8px_40px_rgba(0,0,0,.18)] xl:h-72 xl:w-72">
                                <img src="{{ \App\Support\HomeView::url('slide/toiture.png') }}"
                                     alt="Rénovation toiture Bourgogne"
                                     class="h-full w-full object-cover">
                            </div>
                            {{-- Badge flottant avis --}}
                            <div class="absolute -bottom-3 -right-3 rounded-2xl bg-white px-4 py-2.5 shadow-[0_4px_20px_rgba(0,0,0,.15)]">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-yellow text-xs font-black text-brand-dark">5.0</div>
                                    <div>
                                        <div class="text-xs font-bold text-brand-dark">Avis Google</div>
                                        <div class="text-xs text-brand-yellow">★★★★★</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Badge certif --}}
                            <div class="absolute -top-3 -left-3 rounded-2xl bg-brand-dark px-3 py-2 shadow-lg">
                                <div class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">✓ Certifié RGE</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Barre stats (style PPF) --}}
                <div class="border-t border-gray-100 bg-gray-50/60 px-6 py-5 sm:px-10">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-5">
                        @php
                        $stats = [
                            ['icon'=>'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'value'=>'+5 000', 'label'=>'Chantiers réalisés'],
                            ['icon'=>'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z', 'value'=>'Certifié', 'label'=>'RGE Qualibat'],
                            ['icon'=>'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z', 'value'=>'98 %', 'label'=>'Satisfaction client'],
                            ['icon'=>'M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'value'=>'Jusqu\'à 90 %', 'label'=>'Aides travaux'],
                            ['icon'=>'M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'value'=>'6', 'label'=>'Corps de métier'],
                        ];
                        @endphp
                        @foreach ($stats as $stat)
                        <div class="flex flex-col items-center gap-2 text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-yellow shadow-sm">
                                <svg class="h-7 w-7 text-brand-dark" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                                </svg>
                            </div>
                            <div class="text-sm font-black text-brand-dark sm:text-base">{{ $stat['value'] }}</div>
                            <div class="text-xs text-gray-500 leading-tight">{{ $stat['label'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- fin carte blanche --}}
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

        {{-- Espace réservé pour aligner avec les thumbs en bas --}}
        <div class="hidden lg:block lg:w-[280px] xl:w-[320px]"></div>
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
                    class="hero-thumb h-16 w-24 overflow-hidden rounded-xl border-2 {{ $act }} bg-cover bg-center shadow-[0_4px_16px_rgba(0,0,0,.4)] transition-all duration-300 hover:scale-105 hover:border-brand-yellow sm:h-20 sm:w-28"
                    data-bg="{{ $n }}"
                    style="background-image:url('{{ $u }}')"
                    aria-label="Slide {{ $n }}">
            </button>
        @endforeach
    </div>

</section>
