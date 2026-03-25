@php
    $h = $home ?? [];
    $a = data_get($h, 'agences', []);
    $fr = data_get($a, 'franchise', []);
    $frImg = \App\Support\HomeView::url(data_get($fr, 'image'));
    $mapBox = data_get($a, 'map_box', []);
@endphp
<section id="agences" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:items-stretch lg:px-8">
        <div class="flex h-full min-h-0 flex-col rounded-2xl border border-slate-200 bg-white p-4 shadow-soft sm:p-6">
            <h2 class="mb-3 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($a, 'title_accent') }}</span>{{ data_get($a, 'title_rest') }}</h2>
            <p class="mb-6 text-base text-slate-600 sm:text-lg">{{ data_get($a, 'intro') }}</p>
            <div class="space-y-3">
                @foreach (data_get($a, 'agencies', []) as $ag)
                    <article class="rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                        <p class="text-xs font-extrabold tracking-wide text-brand-blue">{{ data_get($ag, 'badge') }}</p>
                        <h3 class="text-lg font-extrabold text-brand-dark">{{ data_get($ag, 'name') }}</h3>
                        <p class="text-sm text-slate-600">{{ data_get($ag, 'address') }}</p>
                        <p class="mt-1 text-sm font-semibold text-brand-dark">Tél. : {{ data_get($ag, 'phone') }}</p>
                    </article>
                @endforeach
            </div>

            <a id="franchise" href="{{ data_get($fr, 'href', '#devis') }}" class="group relative mt-6 block shrink-0 scroll-mt-28 overflow-hidden rounded-xl border border-slate-200 shadow-soft lg:mt-auto">
                <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('{{ $frImg }}')"></div>
                <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-5 py-5 sm:px-6 sm:py-6">
                    <p class="text-xs font-extrabold tracking-wide text-brand-yellow">{{ data_get($fr, 'kicker') }}</p>
                    <h3 class="text-xl font-extrabold text-white sm:text-2xl">{{ data_get($fr, 'title') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-slate-200 sm:text-base">{{ data_get($fr, 'text') }}</p>
                    <span class="mt-4 inline-flex rounded-lg bg-brand-blue px-4 py-2.5 text-xs font-extrabold text-white transition group-hover:bg-sky-500 sm:text-sm">{{ data_get($fr, 'button') }}</span>
                </div>
            </a>
        </div>

        <div class="flex h-full min-h-0 flex-col rounded-2xl border border-slate-200 bg-white p-4 shadow-soft sm:p-6">
            <h2 class="mb-3 shrink-0 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($mapBox, 'title_accent') }}</span>{{ data_get($mapBox, 'title_rest') }}</h2>
            <div id="agencyMap" class="min-h-[400px] flex-1 rounded-xl border border-slate-200 sm:min-h-[440px] lg:min-h-0"></div>
            <div class="mt-3 flex shrink-0 flex-wrap gap-2 text-xs font-semibold">
                <span class="inline-flex items-center gap-1 rounded-full bg-brand-blue/20 px-3 py-1 text-brand-dark"><span class="h-2 w-2 rounded-full bg-brand-blue"></span>{{ data_get($mapBox, 'legend_1') }}</span>
                <span class="inline-flex items-center gap-1 rounded-full bg-brand-yellow/70 px-3 py-1 text-brand-dark"><span class="h-2 w-2 rounded-full bg-brand-yellow"></span>{{ data_get($mapBox, 'legend_2') }}</span>
            </div>
        </div>
    </div>
</section>
