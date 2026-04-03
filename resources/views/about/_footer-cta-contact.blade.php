@php
    $phone = trim((string) ($phone ?? ''));
    $phoneHref = trim((string) ($phoneHref ?? ''));
    if ($phoneHref === '' && $phone !== '') {
        $phoneHref = preg_replace('/\s+/', '', $phone);
    }
    if ($phoneHref !== '' && ! str_starts_with(strtolower($phoneHref), 'tel:')) {
        $phoneHref = 'tel:'.preg_replace('#^tel:#i', '', $phoneHref);
    }
    $email = trim((string) ($email ?? ''));
    $href = trim((string) ($contactHref ?? ''));
@endphp
<section id="nous-contacter" class="scroll-mt-24 border-t border-slate-200/90 bg-slate-50 py-12 sm:py-14" aria-label="Contacter Normes et Rénovation">
    <div class="mx-auto w-[95%] max-w-2xl px-4 text-center sm:px-6 lg:px-8">
        <p class="text-sm font-extrabold uppercase tracking-[0.15em] text-brand-blue">Contact</p>
        <p class="mt-2 text-base text-slate-600">
            Pour un devis ou une question, préférez le formulaire : nous vous recontactons rapidement.
        </p>
        @if ($href !== '')
            <a
                href="{{ $href }}"
                class="mt-6 inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-blue px-8 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-brand-blue/25 transition hover:-translate-y-0.5 hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2"
            >
                Formulaire de contact
            </a>
        @endif
        @if ($phone !== '' || $email !== '')
            <p class="mt-8 flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm text-slate-600">
                @if ($phone !== '')
                    <a href="{{ $phoneHref !== '' ? $phoneHref : '#' }}" class="font-semibold text-brand-dark underline-offset-2 hover:text-brand-blue hover:underline">{{ $phone }}</a>
                @endif
                @if ($phone !== '' && $email !== '')
                    <span class="text-slate-300" aria-hidden="true">·</span>
                @endif
                @if ($email !== '')
                    <a href="mailto:{{ $email }}" class="break-all font-semibold text-brand-dark underline-offset-2 hover:text-brand-blue hover:underline">{{ $email }}</a>
                @endif
            </p>
        @endif
    </div>
</section>
