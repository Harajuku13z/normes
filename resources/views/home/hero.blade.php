@php
    $h = $home ?? [];
    $slides = data_get($h, 'hero.slides', []);
    $first = $slides[0] ?? [];
    $firstBg = \App\Support\HomeView::url(data_get($first, 'image', 'slide/toiture.png'));
    $firstBgFull = "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('".$firstBg."')";
    $avisUrl = data_get($h, 'sidebar_avis.google_url');
@endphp
<section id="top" class="relative min-h-[540px] overflow-hidden sm:min-h-[620px]">
    <div id="heroBg" class="absolute inset-0 bg-cover bg-center transition-all duration-500" style="background-image:{{ $firstBgFull }}"></div>
    <div class="relative z-10 mx-auto flex min-h-[540px] max-w-7xl flex-col justify-end gap-5 px-4 py-8 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
        <div class="max-w-3xl text-white">
            <h1 id="heroTitle" class="mb-3 text-4xl font-extrabold leading-[1.03] tracking-tight sm:text-5xl lg:text-6xl">{{ data_get($first, 'title') }}</h1>
            <p id="heroSubtitle" class="mb-5 text-lg text-slate-100 sm:text-xl">{{ data_get($first, 'subtitle') }}</p>
            <div class="flex flex-wrap gap-3">
                <a id="heroPrimaryCta" href="{{ data_get($first, 'primary_href', '#devis') }}" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">{{ data_get($first, 'primary_text') }}</a>
                <a id="heroSecondaryCta" href="{{ data_get($first, 'secondary_href', '#devis') }}" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">{{ data_get($first, 'secondary_text') }}</a>
            </div>
        </div>

        <div id="heroThumbs" class="flex w-full gap-2 pb-1 lg:w-auto">
            @foreach ($slides as $idx => $slide)
                @php
                    $n = $idx + 1;
                    $u = \App\Support\HomeView::url(data_get($slide, 'image'));
                    $thumbStyle = "background-image:url('".$u."')";
                    $aria = 'Slider '.$n;
                @endphp
                <button type="button" class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 {{ $n === 1 ? 'border-brand-blue' : 'border-transparent' }} bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="{{ $n }}" style="{{ $thumbStyle }}" aria-label="{{ $aria }}"></button>
            @endforeach

            <a href="{{ $avisUrl }}" target="_blank" rel="noopener noreferrer"
               class="hidden xl:flex h-20 min-w-0 flex-none items-center justify-center rounded-xl border border-white/20 bg-brand-dark/55 shadow-soft lg:h-24 lg:w-32 lg:flex-none">
                <span class="flex flex-col items-center justify-center leading-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="mt-1 text-[11px] font-extrabold tracking-tight text-brand-yellow">{{ data_get($h, 'sidebar_avis.score', '5.0/5') }}</span>
                    <span class="text-[9px] text-brand-yellow">{{ data_get($h, 'sidebar_avis.stars', '★★★★★') }}</span>
                </span>
            </a>
        </div>
    </div>
</section>
