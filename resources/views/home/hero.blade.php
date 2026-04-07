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
    <div class="relative z-10 mx-auto flex min-h-[540px] w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
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
                    $aria = 'Slider '.$n;
                @endphp
                <button type="button" class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 {{ $n === 1 ? 'border-brand-blue' : 'border-transparent' }} bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="{{ $n }}" style="{{ $thumbStyle }}" aria-label="{{ $aria }}"></button>
            @endforeach

        </div>
    </div>
</section>
