@php $h = $home ?? []; @endphp
<section id="services" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="mb-3 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($h, 'services.title_accent') }}</span>{{ data_get($h, 'services.title_rest') }}</h2>
        <p class="mb-6 max-w-3xl text-base text-slate-600 sm:text-lg">{{ data_get($h, 'services.intro') }}</p>
        <div id="serviceGrid" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach (data_get($h, 'services.items', []) as $item)
                <article data-category="{{ data_get($item, 'category') }}" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ \App\Support\HomeView::url(data_get($item, 'image')) }}" alt="{{ data_get($item, 'title') }}" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">{{ data_get($item, 'title') }}</h3>
                        <p class="text-sm text-slate-600">{{ data_get($item, 'description') }}</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">{{ data_get($item, 'cta', 'En savoir plus') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
