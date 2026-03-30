@php
    $h = $home ?? [];
    $logos = data_get($h, 'partners.logos', []);
@endphp

<p class="text-center text-[11px] font-extrabold uppercase tracking-[0.28em] text-brand-dark/55">{{ data_get($h, 'partners.heading') }}</p>
<div class="relative mt-7 overflow-hidden bg-white [mask-image:linear-gradient(to_right,transparent,rgba(0,0,0,1)_10%,rgba(0,0,0,1)_90%,transparent)]">
    <div class="partners-marquee-track">
        <div class="flex shrink-0 items-center gap-x-12 px-6 sm:gap-x-16 sm:px-8">
            @foreach ($logos as $src)
                <img src="{{ \App\Support\HomeView::url($src) }}" alt="Logo" class="h-11 w-auto max-w-[9rem] shrink-0 object-contain opacity-90 transition duration-200 hover:opacity-100 sm:h-14 sm:max-w-[11rem]" width="180" height="56" loading="lazy" decoding="async">
            @endforeach
        </div>
        <div class="flex shrink-0 items-center gap-x-12 px-6 sm:gap-x-16 sm:px-8" aria-hidden="true">
            @foreach ($logos as $src)
                <img src="{{ \App\Support\HomeView::url($src) }}" alt="" class="h-11 w-auto max-w-[9rem] shrink-0 object-contain opacity-90 sm:h-14 sm:max-w-[11rem]" width="180" height="56" loading="lazy" decoding="async">
            @endforeach
        </div>
    </div>
</div>

