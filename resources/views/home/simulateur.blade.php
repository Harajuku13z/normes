@php
    $h   = $home ?? [];
    $sim = data_get($h, 'simulateur', []);
    $simBg = \App\Support\HomeView::url('/slide/toiture.png');
@endphp
<section id="simulateur-devis" class="scroll-mt-28 border-b border-slate-200 bg-white py-10 sm:py-12">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-soft ring-1 ring-slate-100 lg:grid lg:grid-cols-[2fr_1fr]">

            {{-- 2/3 : formulaire --}}
            <div class="bg-white p-6 sm:p-8 lg:p-10">
                <p class="mb-1 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Simulateur de devis</p>
                <h2 class="text-2xl font-black leading-tight text-brand-dark sm:text-3xl">
                    Estimez votre projet en <span class="text-brand-blue">30 secondes</span>
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-500 sm:text-base">
                    Saisissez votre adresse pour lancer une première analyse de votre bien. Un conseiller affine ensuite avec vous.
                </p>

                <form method="get" action="{{ route('simulateur.start') }}" class="mt-6 grid gap-3 sm:grid-cols-[1fr_auto] sm:items-end sm:gap-4">
                    <div>
                        <label for="address" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-brand-blue/95">
                            {{ data_get($sim, 'label', 'Entrez votre adresse') }}
                        </label>
                        <input
                            id="address"
                            name="address"
                            type="text"
                            placeholder="{{ data_get($sim, 'placeholder', 'Ex: 6 rue Pierre de Coubertin, Chalon-sur-Saône') }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-brand-dark outline-none transition placeholder:text-slate-400 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20"
                        >
                    </div>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-brand-blue/30"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        {{ data_get($sim, 'button', 'Lancer le simulateur') }}
                    </button>
                </form>

                <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2">
                    <span class="flex items-center gap-1.5 text-xs text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Sans engagement
                    </span>
                    <span class="flex items-center gap-1.5 text-xs text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Réponse sous 48h
                    </span>
                    <span class="flex items-center gap-1.5 text-xs text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Entreprise RGE certifiée
                    </span>
                </div>
            </div>

            {{-- 1/3 : texte + fond image --}}
            <div class="relative hidden min-h-[220px] lg:block">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $simBg }}');" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-brand-dark/90 via-brand-dark/70 to-brand-dark/50" aria-hidden="true"></div>
                <div class="relative z-10 flex h-full flex-col justify-center px-7 py-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-yellow">Pourquoi nous ?</p>
                    <h3 class="mt-3 text-xl font-black leading-snug text-white">
                        Des aides jusqu'à <span class="text-brand-yellow">90 %</span> sans avance de frais
                    </h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-200">
                        MaPrimeRénov', CEE, éco-PTZ — notre équipe monte les dossiers et optimise le cumul des aides pour votre projet.
                    </p>
                    <div class="mt-5 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-yellow/15 ring-1 ring-brand-yellow/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-yellow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-200">Certifié RGE · Devis gratuit · Suivi personnalisé</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
