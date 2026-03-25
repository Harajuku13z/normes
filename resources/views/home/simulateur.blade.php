@php $h = $home ?? []; @endphp
<section id="simulateur-devis" class="scroll-mt-28 border-b border-yellow-300 bg-[#FADF70] py-8 sm:py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <form class="grid gap-3 rounded-2xl border-2 border-white bg-white p-4 shadow-soft ring-2 ring-white/70 sm:grid-cols-[1fr_auto] sm:items-end sm:gap-4 sm:p-5">
            <div>
                <label for="address" class="mb-2 block text-sm font-extrabold text-brand-dark">{{ data_get($h, 'simulateur.label') }}</label>
                <input id="address" type="text" placeholder="{{ data_get($h, 'simulateur.placeholder') }}" class="w-full rounded-xl border-2 border-brand-blue bg-white px-4 py-3 text-sm text-brand-dark outline-none transition placeholder:text-slate-500 focus:border-brand-dark">
            </div>
            <button type="button" class="rounded-xl bg-brand-blue px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-dark">{{ data_get($h, 'simulateur.button') }}</button>
        </form>
    </div>
</section>
