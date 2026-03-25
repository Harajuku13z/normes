@php
    $h = $home ?? [];
    $floatLogo = \App\Support\HomeView::url(data_get($h, 'floating.logo', '/logo.png'));
    $sideIcon = \App\Support\HomeView::url(data_get($h, 'sidebar_avis.icon', '/iconne.png'));
@endphp
<aside class="fixed bottom-4 left-1/2 z-50 flex w-[min(100%,22.5rem)] max-w-[calc(100vw-1rem)] -translate-x-1/2 items-stretch gap-2 rounded-2xl border-2 border-brand-blue/40 bg-white p-2 shadow-lg ring-1 ring-slate-200/90 sm:left-4 sm:max-w-none sm:translate-x-0 xl:hidden" aria-label="Avis Google et appel">
    <a href="{{ data_get($h, 'floating.google_url') }}" target="_blank" rel="noopener noreferrer" class="flex min-h-[3.5rem] min-w-0 flex-1 items-center gap-2.5 rounded-xl py-1 pl-2 pr-1 transition hover:bg-slate-50">
        <img src="{{ $floatLogo }}" alt="" class="h-11 w-11 shrink-0 rounded-lg border border-brand-blue/25 bg-white object-contain p-0.5" width="44" height="44" decoding="async">
        <div class="min-w-0 flex-1 text-left">
            <p class="text-sm font-extrabold leading-tight text-brand-dark">{{ data_get($h, 'floating.title') }}</p>
            <p class="mt-0.5 text-xs leading-tight text-yellow-500">{{ data_get($h, 'floating.subtitle') }} <span class="font-semibold text-slate-600">{{ data_get($h, 'floating.subtitle_suffix') }}</span></p>
            <p class="mt-0.5 text-[11px] font-semibold text-brand-blue">{{ data_get($h, 'floating.link_text') }}</p>
        </div>
    </a>
    <a href="tel:{{ data_get($h, 'floating.phone') }}" class="inline-flex w-14 shrink-0 items-center justify-center rounded-xl bg-brand-blue text-white shadow-md transition hover:bg-brand-dark active:scale-[0.98]" aria-label="Appeler le {{ data_get($h, 'floating.phone_display') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25a2.25 2.25 0 012.25-2.25h2.1a2.25 2.25 0 012.214 1.848l.42 2.52a2.25 2.25 0 01-1.184 2.355l-1.34.67a16.521 16.521 0 006.246 6.246l.67-1.34a2.25 2.25 0 012.355-1.184l2.52.42A2.25 2.25 0 0121 16.65v2.1A2.25 2.25 0 0118.75 21h-.75C9.716 21 3 14.284 3 6v-.75z"/></svg>
    </a>
</aside>

<aside class="fixed left-0 top-1/2 z-40 hidden w-32 -translate-y-1/2 rounded-r-2xl bg-gradient-to-b from-brand-blue to-brand-dark px-4 py-6 text-white shadow-soft xl:block" style="animation: avisFloat 4s ease-in-out infinite;">
    <a href="{{ data_get($h, 'sidebar_avis.google_url') }}" target="_blank" rel="noopener noreferrer" class="block">
        <img src="{{ $sideIcon }}" alt="{{ data_get($h, 'sidebar_avis.icon_alt') }}" class="h-10 w-10 rounded-full border border-white/50 bg-white object-cover">
        <p class="mt-3 text-[11px] font-bold uppercase tracking-wider text-white/80">{{ data_get($h, 'sidebar_avis.label') }}</p>
        <div class="mt-2 text-3xl font-extrabold">{{ data_get($h, 'sidebar_avis.score') }}</div>
        <div class="text-sm text-brand-yellow">{{ data_get($h, 'sidebar_avis.stars') }}</div>
        <p class="mt-3 text-[12px] leading-tight text-white/90">{{ data_get($h, 'sidebar_avis.text') }}</p>
    </a>
</aside>
