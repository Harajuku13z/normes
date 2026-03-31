@php
    $h = $home ?? [];
    $d = data_get($h, 'devis', []);
    $serviceOptionsPreferred = collect((array) ($serviceOptionsPreferred ?? []))
        ->map(fn ($title) => trim((string) $title))
        ->filter(fn ($title) => $title !== '')
        ->unique()
        ->values()
        ->all();
    $serviceOptions = collect((array) data_get($h, 'service_options', []))
        ->map(fn ($title) => trim((string) $title))
        ->filter(fn ($title) => $title !== '')
        ->reject(fn ($title) => in_array($title, $serviceOptionsPreferred, true))
        ->values()
        ->all();
    $serviceOptions = array_values(array_merge($serviceOptionsPreferred, $serviceOptions));
@endphp

<div id="formulaire-contact" class="flex h-full min-h-0 scroll-mt-28 flex-col rounded-2xl border border-slate-200/90 bg-white p-5 text-brand-dark shadow-xl sm:p-7">
    <div class="mb-5 shrink-0 border-b border-slate-100 pb-4">
        <h3 class="text-2xl font-black tracking-tight text-brand-blue sm:text-3xl">{{ data_get($d, 'form.title') }}</h3>
        <p class="mt-2 inline-block rounded-lg bg-brand-blue/10 px-3 py-1.5 text-sm font-semibold text-brand-dark">{{ data_get($d, 'form.intro') }}</p>
    </div>
    <form class="flex flex-1 flex-col text-brand-dark" action="#" method="post" enctype="multipart/form-data">
        @csrf
        <p class="mb-4 text-sm font-semibold text-slate-600">{{ data_get($d, 'form.note') }}</p>
        <div class="grid gap-3 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="devisNomComplet" class="mb-1 block text-sm font-semibold">Nom et prenom</label>
                <input id="devisNomComplet" name="nom_complet" type="text" autocomplete="name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
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
            <div class="sm:col-span-2">
                <label for="devisService" class="mb-1 block text-sm font-semibold">Service</label>
                <select id="devisService" name="service" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    <option value="">Selectionner un service</option>
                    @foreach ($serviceOptions as $serviceTitle)
                        <option value="{{ $serviceTitle }}">{{ $serviceTitle }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-3">
            <label for="devisMessage" class="mb-1 block text-sm font-semibold">Message</label>
            <textarea id="devisMessage" name="message" rows="4" placeholder="Surface approximative, type de travaux, urgence, questions sur MaPrimeRénov ou CEE..." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25"></textarea>
        </div>
        <div class="mt-3">
            <label for="devisAutres" class="mb-1 block text-sm font-semibold">Autres informations</label>
            <textarea id="devisAutres" name="autres_infos" rows="3" placeholder="Contraintes d'acces, disponibilites, budget, delais, etc." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25"></textarea>
        </div>
        <div class="mt-3">
            <label for="devisPhotos" class="mb-1 block text-sm font-semibold">Photos et documents</label>
            <input id="devisPhotos" name="photos[]" type="file" multiple accept="image/*,.pdf,.doc,.docx,.heic" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-brand-blue file:px-3 file:py-1.5 file:text-xs file:font-extrabold file:text-white hover:file:bg-sky-500">
            <p class="mt-1 text-xs text-slate-500">Vous pouvez joindre plusieurs photos ou autres documents.</p>
        </div>
        <button type="submit" class="mt-5 w-full rounded-xl bg-brand-blue px-4 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 sm:text-base">{{ data_get($d, 'form.submit') }}</button>
        <p class="mt-3 text-center text-xs text-slate-500">{{ data_get($d, 'form.footer_note') }}</p>
    </form>
</div>

