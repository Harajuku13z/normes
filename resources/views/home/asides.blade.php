@php
    $h = $home ?? [];
    $sideIcon = \App\Support\HomeView::url(data_get($h, 'sidebar_avis.icon', '/iconne.png'));
@endphp
<aside id="mobileFloatingAvis" class="fixed bottom-4 left-1/2 z-50 hidden w-[min(100%,22.5rem)] max-w-[calc(100vw-1rem)] -translate-x-1/2 items-stretch gap-2 rounded-2xl border-2 border-brand-blue/40 bg-white p-2 shadow-lg ring-1 ring-slate-200/90 sm:left-4 sm:max-w-none sm:translate-x-0 xl:hidden" aria-label="Avis Google et appel">
    <a href="{{ data_get($h, 'floating.google_url') }}" target="_blank" rel="noopener noreferrer" class="flex min-h-[3.5rem] min-w-0 flex-1 items-center gap-2.5 rounded-xl py-1 pl-2 pr-1 transition hover:bg-slate-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
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
