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
        </div>

        <div class="flex h-full min-h-0 flex-col">
            <a
                id="franchise"
                href="{{ data_get($fr, 'href', '#devis') }}"
                class="group relative flex-1 block scroll-mt-28 overflow-hidden rounded-3xl shadow-soft"
            >
                <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-[1.03]" style="background-image:url('{{ $frImg }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/95 via-brand-dark/70 to-transparent"></div>
                <div class="relative z-10 flex h-full flex-col justify-end p-6">
                    <div class="rounded-2xl bg-brand-dark/40 backdrop-blur-sm px-5 py-5 ring-1 ring-white/10">
                        <p class="text-xs font-extrabold tracking-wide text-brand-yellow">{{ data_get($fr, 'kicker') }}</p>
                        <h3 class="mt-2 text-xl font-extrabold text-white sm:text-2xl">{{ data_get($fr, 'title') }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-slate-200 sm:text-base">{{ data_get($fr, 'text') }}</p>
                        <span class="mt-4 inline-flex rounded-lg bg-brand-blue px-4 py-2.5 text-xs font-extrabold text-white transition group-hover:bg-sky-500 sm:text-sm">
                            {{ data_get($fr, 'button') }}
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
