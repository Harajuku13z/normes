<div
    id="cookieConsent"
    class="pointer-events-none fixed inset-x-0 bottom-0 z-[120] hidden px-3 pb-3 sm:px-5 sm:pb-5"
    aria-hidden="true"
>
    <div class="pointer-events-auto mx-auto w-full max-w-4xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl ring-1 ring-slate-100">
        <div class="p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Cookies & RGPD</p>
                    <h3 class="mt-1 text-lg font-extrabold text-brand-dark sm:text-xl">Nous respectons votre vie privée</h3>
                </div>
                <button
                    id="cookieConsentClose"
                    type="button"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 hover:text-brand-dark"
                    aria-label="Fermer"
                >
                    ×
                </button>
            </div>

            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Nous utilisons des cookies pour le fonctionnement du site, la mesure d'audience et l'amélioration de nos services.
                Vous pouvez accepter, refuser ou personnaliser vos choix.
            </p>

            <div id="cookiePrefsPanel" class="mt-4 hidden rounded-xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                <div class="space-y-3">
                    <label class="flex items-start justify-between gap-3 rounded-lg bg-white p-3 ring-1 ring-slate-100">
                        <span>
                            <span class="block text-sm font-extrabold text-brand-dark">Cookies nécessaires</span>
                            <span class="mt-0.5 block text-xs text-slate-600">Indispensables au fonctionnement du site.</span>
                        </span>
                        <input type="checkbox" checked disabled class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-blue">
                    </label>

                    <label class="flex items-start justify-between gap-3 rounded-lg bg-white p-3 ring-1 ring-slate-100">
                        <span>
                            <span class="block text-sm font-extrabold text-brand-dark">Mesure d'audience</span>
                            <span class="mt-0.5 block text-xs text-slate-600">Nous aide à comprendre l'utilisation du site.</span>
                        </span>
                        <input id="cookieAnalytics" type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-blue">
                    </label>

                    <label class="flex items-start justify-between gap-3 rounded-lg bg-white p-3 ring-1 ring-slate-100">
                        <span>
                            <span class="block text-sm font-extrabold text-brand-dark">Contenus marketing</span>
                            <span class="mt-0.5 block text-xs text-slate-600">Personnalisation et suivi de campagnes.</span>
                        </span>
                        <input id="cookieMarketing" type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-blue">
                    </label>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <button id="cookieReject" type="button" class="inline-flex rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-extrabold text-slate-700 transition hover:bg-slate-50 sm:text-sm">
                    Refuser
                </button>
                <button id="cookieCustomize" type="button" class="inline-flex rounded-lg border border-brand-dark/20 bg-brand-dark/5 px-4 py-2 text-xs font-extrabold text-brand-dark transition hover:bg-brand-dark/10 sm:text-sm">
                    Personnaliser
                </button>
                <button id="cookieSave" type="button" class="hidden inline-flex rounded-lg border border-brand-blue bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-sky-500 sm:text-sm">
                    Enregistrer mes choix
                </button>
                <button id="cookieAccept" type="button" class="inline-flex rounded-lg border border-brand-blue bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-sky-500 sm:text-sm">
                    Tout accepter
                </button>
            </div>
        </div>
    </div>
</div>

