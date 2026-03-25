@php
    $h = $home ?? [];
    $d = data_get($h, 'devis', []);
    $sim = data_get($d, 'sim_block', []);
@endphp
<section id="devis" class="scroll-mt-24 bg-brand-dark py-16 text-white sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1.05fr_1fr] lg:items-stretch lg:gap-12 lg:px-8">
        <div class="flex min-h-0 flex-col gap-8 lg:h-full lg:min-h-0">
            <div class="max-w-lg shrink-0">
                <h2 class="mb-4 text-4xl font-extrabold leading-tight sm:text-5xl"><span class="text-brand-yellow">{{ data_get($d, 'title_line1') }}</span> <span class="text-white">{{ data_get($d, 'title_line2') }}</span></h2>
                <p class="text-xl font-bold text-white sm:text-2xl">{{ data_get($d, 'subtitle') }}</p>
                <p class="mt-3 text-sm leading-relaxed text-slate-200 sm:text-base">{{ data_get($d, 'intro') }}</p>
                <p class="mt-2 text-sm text-slate-300">{{ data_get($d, 'response_note') }}</p>
                <a href="#formulaire-contact" class="mt-5 inline-flex rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-lg transition hover:bg-yellow-300 lg:hidden">{{ data_get($d, 'mobile_form_cta') }}</a>
            </div>
            <div class="hidden min-h-0 lg:block lg:flex-1" aria-hidden="true"></div>

            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 sm:p-6 lg:shrink-0">
                <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">{{ data_get($sim, 'kicker') }}</p>
                <p class="mt-2 text-base font-semibold text-white sm:text-lg">{{ data_get($sim, 'title') }}</p>
                <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ data_get($sim, 'text') }}</p>
                <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                    <a href="{{ data_get($sim, 'primary_href') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-md transition hover:bg-yellow-300">{{ data_get($sim, 'primary') }}</a>
                    <a href="{{ data_get($sim, 'secondary_href') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-white/40 bg-transparent px-5 py-3 text-sm font-extrabold text-white transition hover:border-white hover:bg-white/10">{{ data_get($sim, 'secondary') }}</a>
                </div>
            </div>
        </div>

        <div id="formulaire-contact" class="flex h-full min-h-0 scroll-mt-28 flex-col rounded-2xl border border-slate-200/90 bg-white p-5 text-brand-dark shadow-xl sm:p-7">
            <div class="mb-5 shrink-0 border-b border-slate-100 pb-4">
                <h3 class="text-xl font-extrabold text-brand-dark">{{ data_get($d, 'form.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ data_get($d, 'form.intro') }}</p>
            </div>
            <form class="flex flex-1 flex-col text-brand-dark" action="#" method="post">
                @csrf
                <p class="mb-4 text-sm font-semibold text-slate-600">{{ data_get($d, 'form.note') }}</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label for="devisPrenom" class="mb-1 block text-sm font-semibold">Prenom</label>
                        <input id="devisPrenom" name="prenom" type="text" autocomplete="given-name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                    <div class="sm:col-span-1">
                        <label for="devisNom" class="mb-1 block text-sm font-semibold">Nom</label>
                        <input id="devisNom" name="nom" type="text" autocomplete="family-name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                </div>
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    <div>
                        <label for="devisEmail" class="mb-1 block text-sm font-semibold">Email</label>
                        <input id="devisEmail" name="email" type="email" autocomplete="email" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                    <div>
                        <label for="devisPhone" class="mb-1 block text-sm font-semibold">Telephone</label>
                        <input id="devisPhone" name="telephone" type="tel" autocomplete="tel" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                </div>
                <div class="mt-3 grid gap-3 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <label for="devisCp" class="mb-1 block text-sm font-semibold">Code postal</label>
                        <input id="devisCp" name="code_postal" type="text" inputmode="numeric" maxlength="10" autocomplete="postal-code" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="devisVille" class="mb-1 block text-sm font-semibold">Ville</label>
                        <input id="devisVille" name="ville" type="text" autocomplete="address-level2" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                </div>
                <div class="mt-3">
                    <label for="devisBien" class="mb-1 block text-sm font-semibold">Type de bien</label>
                    <select id="devisBien" name="type_bien" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                        <option value="">Selectionnez</option>
                        <option value="maison">Maison</option>
                        <option value="appartement">Appartement</option>
                        <option value="local">Local professionnel</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="devisProject" class="mb-1 block text-sm font-semibold">Nature du projet</label>
                    <select id="devisProject" name="projet" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                        <option value="toiture_couverture">Toiture &amp; couverture</option>
                        <option value="demoussage">Nettoyage &amp; demoussage de toiture</option>
                        <option value="hydrofuge">Traitement hydrofuge</option>
                        <option value="facade">Renovation de facade</option>
                        <option value="isolation">Isolation thermique</option>
                        <option value="vmc">Ventilation (VMC / VMI)</option>
                        <option value="electricite">Mise aux normes electriques</option>
                        <option value="solaire">Installation photovoltaique</option>
                        <option value="clim">Climatisation &amp; confort d'ete</option>
                        <option value="humidite">Traitement de l'humidite</option>
                        <option value="adoucisseur">Adoucisseur d'eau</option>
                        <option value="charpente">Traitement de charpente</option>
                        <option value="multiple">Plusieurs travaux</option>
                        <option value="conseil">Je souhaite etre conseille(e)</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="devisMessage" class="mb-1 block text-sm font-semibold">Message et precisions</label>
                    <textarea id="devisMessage" name="message" rows="4" placeholder="Surface approximative, urgence, questions sur MaPrimeRénov ou CEE..." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25"></textarea>
                </div>
                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-start">
                    <label class="flex cursor-pointer gap-2 text-xs text-slate-600 sm:max-w-lg">
                        <input type="checkbox" name="rgpd" value="1" class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                        <span>J'accepte que mes informations soient utilisees pour me recontacter concernant ma demande (voir les engagements RGPD de l'entreprise).</span>
                    </label>
                </div>
                <button type="submit" class="mt-5 w-full rounded-xl bg-brand-yellow px-4 py-3.5 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300 sm:text-base">{{ data_get($d, 'form.submit') }}</button>
                <p class="mt-3 text-center text-xs text-slate-500">{{ data_get($d, 'form.footer_note') }}</p>
            </form>
        </div>
    </div>
</section>
