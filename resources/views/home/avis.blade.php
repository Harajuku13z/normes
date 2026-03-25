@php $h = $home ?? []; @endphp
<section class="border-t border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between sm:gap-8">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($h, 'avis.title_accent') }}</span>{{ data_get($h, 'avis.title_rest') }}</h2>
                <p class="mt-3 text-base text-slate-600 sm:text-lg">{{ data_get($h, 'avis.intro') }}</p>
            </div>
            <a href="{{ data_get($h, 'avis.google_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border-2 border-brand-dark/15 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm ring-1 ring-slate-200/80 transition hover:border-brand-blue/40 hover:bg-slate-50 hover:text-brand-blue hover:shadow-md sm:self-start lg:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#4285F4]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                {{ data_get($h, 'avis.google_button') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @foreach (data_get($h, 'avis.testimonials', []) as $t)
                <article class="relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-6 shadow-soft ring-1 ring-slate-100 transition duration-300 hover:-translate-y-0.5 hover:border-brand-blue/25 hover:shadow-lg">
                    <div class="absolute -right-2 -top-2 h-16 w-16 rounded-full {{ data_get($t, 'deco_class', 'bg-brand-blue/5') }}" aria-hidden="true"></div>
                    <div class="relative mb-4 flex items-start justify-between gap-3">
                        <p class="text-lg tracking-wide text-yellow-500" aria-label="5 sur 5">★★★★★</p>
                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-slate-600">Google</span>
                    </div>
                    <p class="relative flex-1 text-sm leading-relaxed text-slate-700 sm:text-base">{{ data_get($t, 'text') }}</p>
                    <p class="relative mt-5 border-t border-slate-100 pt-4 text-sm font-extrabold text-brand-dark">{{ data_get($t, 'author') }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
