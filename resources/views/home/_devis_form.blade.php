@php
    $h = $home ?? [];
    $d = data_get($h, 'devis', []);
@endphp

<div id="formulaire-contact" class="flex h-full min-h-0 scroll-mt-28 flex-col rounded-2xl border border-slate-200/90 bg-white p-5 text-brand-dark shadow-xl sm:p-7">
    <div class="mb-5 shrink-0 border-b border-slate-100 pb-4">
        <h3 class="text-xl font-extrabold text-brand-dark">{{ data_get($d, 'form.title') }}</h3>
        <p class="mt-1 text-sm text-slate-600">{{ data_get($d, 'form.intro') }}</p>
    </div>
    <form class="flex flex-1 flex-col text-brand-dark" action="#" method="post">
        @csrf
        <p class="mb-4 text-sm font-semibold text-slate-600">{{ data_get($d, 'form.note') }}</p>
        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="devisPrenom" class="mb-1 block text-sm font-semibold">Prenom</label>
                <input id="devisPrenom" name="prenom" type="text" autocomplete="given-name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
            </div>
            <div>
                <label for="devisNom" class="mb-1 block text-sm font-semibold">Nom</label>
                <input id="devisNom" name="nom" type="text" autocomplete="family-name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
            </div>
            <div>
                <label for="devisEmail" class="mb-1 block text-sm font-semibold">Email</label>
                <input id="devisEmail" name="email" type="email" autocomplete="email" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
            </div>
            <div>
                <label for="devisPhone" class="mb-1 block text-sm font-semibold">Telephone</label>
                <input id="devisPhone" name="telephone" type="tel" autocomplete="tel" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
            </div>
            <div>
                <label for="devisCp" class="mb-1 block text-sm font-semibold">Code postal</label>
                <input
                    id="devisCp"
                    name="code_postal"
                    type="text"
                    inputmode="numeric"
                    maxlength="10"
                    autocomplete="postal-code"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25"
                >
            </div>
        </div>
        <div class="mt-3">
            <label for="devisMessage" class="mb-1 block text-sm font-semibold">Message</label>
            <textarea id="devisMessage" name="message" rows="4" placeholder="Surface approximative, type de travaux, urgence, questions sur MaPrimeRénov ou CEE..." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25"></textarea>
        </div>
        <button type="submit" class="mt-5 w-full rounded-xl bg-brand-blue px-4 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 sm:text-base">{{ data_get($d, 'form.submit') }}</button>
        <p class="mt-3 text-center text-xs text-slate-500">{{ data_get($d, 'form.footer_note') }}</p>
    </form>
</div>

