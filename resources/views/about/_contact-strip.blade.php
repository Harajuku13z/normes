@php
    $title = trim((string) ($stripTitle ?? 'NOUS CONTACTEZ'));
    $phone = trim((string) ($phone ?? ''));
    $phoneHref = trim((string) ($phoneHref ?? ''));
    if ($phoneHref === '' && $phone !== '') {
        $phoneHref = 'tel:'.preg_replace('/\s+/', '', $phone);
    }
    $email = trim((string) ($email ?? ''));
    $compact = ! empty($compact);
@endphp
@if ($title !== '')
    <section @if(! $compact) id="nous-contacter" @endif class="{{ $compact ? 'bg-slate-100 py-8 sm:py-10' : 'bg-brand-dark py-12 sm:py-14' }} text-center">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h2 class="{{ $compact ? 'text-xl font-extrabold text-brand-dark sm:text-2xl' : 'text-2xl font-black uppercase tracking-wide text-white sm:text-3xl' }}">
                {{ $title }}
            </h2>
            <div class="mt-6 flex flex-col items-center justify-center gap-4 sm:flex-row sm:flex-wrap sm:gap-6">
                @if ($phone !== '')
                    <a href="{{ $phoneHref !== '' ? $phoneHref : '#' }}" class="inline-flex items-center gap-2 rounded-xl {{ $compact ? 'border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark hover:bg-slate-50' : 'bg-white/15 px-5 py-3 text-sm font-extrabold text-white ring-1 ring-white/25 hover:bg-white/25' }}">
                        {{ $phone }}
                    </a>
                @endif
                @if ($email !== '')
                    <a href="mailto:{{ $email }}" class="inline-flex items-center gap-2 rounded-xl {{ $compact ? 'border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark hover:bg-slate-50' : 'bg-white/15 px-5 py-3 text-sm font-extrabold text-white ring-1 ring-white/25 hover:bg-white/25' }}">
                        {{ $email }}
                    </a>
                @endif
                @if ($contactHref !== '')
                    <a href="{{ $contactHref }}" class="inline-flex rounded-xl bg-brand-blue px-6 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                        Formulaire de contact
                    </a>
                @endif
            </div>
        </div>
    </section>
@endif
