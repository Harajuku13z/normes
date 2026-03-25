@php
    $h = $home ?? [];
    $files = data_get($h, 'partners.files', []);
@endphp
<section class="partners-marquee border-y border-slate-200 bg-white py-10" aria-label="Nos partenaires">
    <p class="mx-auto max-w-7xl px-4 text-center text-[11px] font-extrabold uppercase tracking-[0.28em] text-brand-dark/55 sm:px-6 lg:px-8">{{ data_get($h, 'partners.heading') }}</p>
    <div class="relative mt-7 overflow-hidden bg-white [mask-image:linear-gradient(to_right,transparent,rgba(0,0,0,1)_10%,rgba(0,0,0,1)_90%,transparent)]">
        <div class="partners-marquee-track">
            <div class="flex shrink-0 items-center gap-x-12 px-6 sm:gap-x-16 sm:px-8">
                @foreach ($files as $file)
                    <img src="{{ asset('partenaire/'.$file) }}" alt="Logo partenaire" class="h-11 w-auto max-w-[9rem] shrink-0 object-contain opacity-90 transition duration-200 hover:opacity-100 sm:h-14 sm:max-w-[11rem]" width="180" height="56" loading="lazy" decoding="async">
                @endforeach
            </div>
            <div class="flex shrink-0 items-center gap-x-12 px-6 sm:gap-x-16 sm:px-8" aria-hidden="true">
                @foreach ($files as $file)
                    <img src="{{ asset('partenaire/'.$file) }}" alt="" class="h-11 w-auto max-w-[9rem] shrink-0 object-contain opacity-90 sm:h-14 sm:max-w-[11rem]" width="180" height="56" loading="lazy" decoding="async">
                @endforeach
            </div>
        </div>
    </div>
</section>
