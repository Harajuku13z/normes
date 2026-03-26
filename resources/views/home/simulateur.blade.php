@php $h = $home ?? []; @endphp
<section id="simulateur-devis" class="scroll-mt-28 border-b border-slate-200 bg-white py-10 sm:py-12">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <form class="grid gap-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-soft ring-1 ring-slate-100 sm:grid-cols-[1fr_auto] sm:items-end sm:gap-4">
            <div>
                <label for="address" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-brand-blue/95">{{ data_get($h, 'simulateur.label') }}</label>
                <input
                    id="address"
                    type="text"
                    placeholder="{{ data_get($h, 'simulateur.placeholder') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-brand-dark outline-none transition placeholder:text-slate-500 focus:border-brand-dark focus:ring-2 focus:ring-brand-blue/20"
                >
            </div>
            <button
                type="button"
                class="rounded-xl bg-brand-blue px-6 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-brand-dark active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-brand-blue/30"
            >
                {{ data_get($h, 'simulateur.button') }}
            </button>
        </form>
    </div>
</section>
