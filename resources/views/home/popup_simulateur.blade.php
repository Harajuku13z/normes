@php $h = $home ?? []; @endphp
<div id="leadPopup" class="fixed inset-0 z-[120] hidden overflow-y-auto" aria-hidden="true">
    <div id="leadPopupBackdrop" class="absolute inset-0 bg-brand-dark/70 backdrop-blur-[2px]"></div>

    <div class="relative mx-auto flex min-h-dvh w-[95%] max-w-xl items-center py-6 sm:py-10">
        <div
            role="dialog"
            aria-modal="true"
            aria-labelledby="leadPopupTitle"
            class="relative w-full max-h-[calc(100dvh-3rem)] overflow-hidden rounded-3xl border border-white/15 bg-white shadow-2xl ring-1 ring-black/5 sm:max-h-[calc(100dvh-5rem)]"
        >
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-brand-blue/5 via-white to-brand-yellow/10" aria-hidden="true"></div>
            <div class="relative overflow-y-auto p-6 sm:p-8">
                <button
                    id="leadPopupClose"
                    type="button"
                    class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-[0.99]"
                    aria-label="Fermer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 6L6 18"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                </button>

                <div class="inline-flex items-center gap-2 rounded-full bg-brand-blue/10 px-4 py-2 text-xs font-extrabold uppercase tracking-wide text-brand-blue">
                    Devis en 48h
                </div>

                <div class="mt-5 flex items-center gap-3">
                    <img
                        src="{{ \App\Support\HomeView::url('/logo.png') }}"
                        alt="Normes & Rénovation"
                        width="220"
                        height="60"
                        class="h-9 w-auto object-contain sm:h-10"
                        loading="lazy"
                        decoding="async"
                    >
                    <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-brand-dark/55">
                        Normes &amp; Rénovation
                    </span>
                </div>

                <h3 id="leadPopupTitle" class="mt-4 text-2xl font-black leading-tight text-brand-dark sm:text-3xl">
                    Estimez votre projet en 30 secondes
                </h3>
                <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">
                    Lancez le simulateur pour une première estimation, puis un conseiller vous rappelle pour affiner le devis et les aides (MaPrimeRénov’, CEE).
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <a
                        id="leadPopupCtaSimulator"
                        href="{{ route('simulateur.start', ['source' => request()->getPathInfo().'#leadPopup']) }}"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-brand-blue px-5 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 active:scale-[0.99]"
                    >
                        Lancer le simulateur
                    </a>
                    <a
                        id="leadPopupCtaForm"
                        href="#formulaire-contact"
                        class="inline-flex w-full items-center justify-center rounded-xl border-2 border-brand-dark/15 bg-white px-5 py-3.5 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-brand-blue/40 hover:bg-slate-50 hover:text-brand-blue active:scale-[0.99]"
                    >
                        Être rappelé
                    </a>
                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Sans engagement. Vous pouvez fermer ce popup à tout moment.
                </p>
            </div>
        </div>
    </div>
</div>
