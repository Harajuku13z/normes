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
    <section
        @if (! $compact) id="nous-contacter" @endif
        class="{{ $compact
            ? 'relative border-y border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-10 sm:py-12'
            : 'relative overflow-hidden bg-gradient-to-br from-brand-dark via-brand-dark to-slate-900 py-14 sm:py-16' }}"
    >
        @if (! $compact)
            <div class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-brand-blue/20 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-16 h-72 w-72 rounded-full bg-brand-yellow/10 blur-3xl" aria-hidden="true"></div>
        @endif
        <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h2 class="{{ $compact
                ? 'text-center text-xl font-black uppercase tracking-[0.12em] text-brand-dark sm:text-2xl'
                : 'text-center text-2xl font-black uppercase tracking-[0.12em] text-white sm:text-3xl' }}">
                <span class="{{ $compact ? '' : 'text-brand-yellow' }}">{{ $title }}</span>
            </h2>
            <div class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-center sm:gap-4">
                @if ($phone !== '')
                    <a
                        href="{{ $phoneHref !== '' ? $phoneHref : '#' }}"
                        class="inline-flex items-center justify-center gap-3 rounded-2xl px-5 py-3.5 text-sm font-extrabold shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 {{ $compact
                            ? 'border border-slate-200/80 bg-white text-brand-dark ring-1 ring-slate-100 hover:border-brand-blue/30 hover:shadow-md'
                            : 'bg-white/12 text-white ring-1 ring-white/25 backdrop-blur-sm hover:bg-white/20' }}"
                    >
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $compact ? 'bg-brand-blue/10 text-brand-blue' : 'bg-brand-yellow text-brand-dark' }}" aria-hidden="true">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        {{ $phone }}
                    </a>
                @endif
                @if ($email !== '')
                    <a
                        href="mailto:{{ $email }}"
                        class="inline-flex items-center justify-center gap-3 rounded-2xl px-5 py-3.5 text-sm font-extrabold shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 {{ $compact
                            ? 'border border-slate-200/80 bg-white text-brand-dark ring-1 ring-slate-100 hover:border-brand-blue/30 hover:shadow-md'
                            : 'bg-white/12 text-white ring-1 ring-white/25 backdrop-blur-sm hover:bg-white/20' }}"
                    >
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $compact ? 'bg-brand-blue/10 text-brand-blue' : 'bg-brand-yellow text-brand-dark' }}" aria-hidden="true">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <span class="max-w-[220px] truncate sm:max-w-none">{{ $email }}</span>
                    </a>
                @endif
                @if ($contactHref !== '')
                    <a
                        href="{{ $contactHref }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-blue px-6 py-3.5 text-sm font-extrabold text-white shadow-[0_12px_30px_-8px_rgba(14,165,233,0.55)] transition hover:-translate-y-0.5 hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2"
                    >
                        <svg class="h-4 w-4 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Formulaire de contact
                    </a>
                @endif
            </div>
        </div>
    </section>
@endif
