@php
    $title = trim((string) ($stripTitle ?? 'NOUS CONTACTEZ'));
    $phone = trim((string) ($phone ?? ''));
    $phoneHref = trim((string) ($phoneHref ?? ''));
    if ($phoneHref === '' && $phone !== '') {
        $phoneHref = preg_replace('/\s+/', '', $phone);
    }
    if ($phoneHref !== '' && ! str_starts_with(strtolower($phoneHref), 'tel:')) {
        $phoneHref = 'tel:'.preg_replace('#^tel:#i', '', $phoneHref);
    }
    $email = trim((string) ($email ?? ''));
    $compact = ! empty($compact);
@endphp
@if ($title !== '')
    @if ($compact)
        <section class="border-y border-slate-200/80 bg-white py-10 sm:py-12">
            <div class="mx-auto w-[95%] px-4 text-center sm:px-6 lg:px-8">
                <h2 class="text-lg font-black uppercase tracking-[0.1em] text-brand-dark sm:text-xl">{{ $title }}</h2>
                <div class="mt-5 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-4">
                    @if ($phone !== '')
                        <a href="{{ $phoneHref !== '' ? $phoneHref : '#' }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-brand-dark shadow-sm transition hover:border-brand-blue/30 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue focus-visible:ring-offset-2">
                            <svg class="h-4 w-4 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $phone }}
                        </a>
                    @endif
                    @if ($email !== '')
                        <a href="mailto:{{ $email }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-brand-dark shadow-sm transition hover:border-brand-blue/30 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue focus-visible:ring-offset-2">
                            <svg class="h-4 w-4 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="max-w-[200px] truncate sm:max-w-none">{{ $email }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @else
        <section id="nous-contacter" class="relative overflow-hidden bg-brand-dark py-14 sm:py-16">
            <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-brand-blue/15 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-20 h-56 w-56 rounded-full bg-brand-yellow/10 blur-3xl" aria-hidden="true"></div>
            <div class="relative z-10 mx-auto w-[95%] px-4 text-center sm:px-6 lg:px-8">
                <h2 class="text-2xl font-black uppercase tracking-[0.1em] text-white sm:text-3xl">
                    <span class="text-brand-yellow">{{ $title }}</span>
                </h2>
                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-4">
                    @if ($phone !== '')
                        <a href="{{ $phoneHref !== '' ? $phoneHref : '#' }}" class="inline-flex items-center gap-3 rounded-2xl bg-white/10 px-6 py-3.5 text-sm font-extrabold text-white ring-1 ring-white/20 backdrop-blur-sm transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-yellow text-brand-dark" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            {{ $phone }}
                        </a>
                    @endif
                    @if ($email !== '')
                        <a href="mailto:{{ $email }}" class="inline-flex items-center gap-3 rounded-2xl bg-white/10 px-6 py-3.5 text-sm font-extrabold text-white ring-1 ring-white/20 backdrop-blur-sm transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-yellow text-brand-dark" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <span class="max-w-[200px] truncate sm:max-w-none">{{ $email }}</span>
                        </a>
                    @endif
                    @if ($contactHref !== '')
                        <a href="{{ $contactHref }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-blue px-7 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-brand-blue/30 transition hover:-translate-y-0.5 hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                            Formulaire de contact
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endif
