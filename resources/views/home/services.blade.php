@php $h = $home ?? []; @endphp
<section id="services" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <h2 class="mb-3 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($h, 'services.title_accent') }}</span>{{ data_get($h, 'services.title_rest') }}</h2>
        <p class="mb-6 max-w-3xl text-base text-slate-600 sm:text-lg">{{ data_get($h, 'services.intro') }}</p>
        <div id="serviceGrid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (data_get($h, 'services.items', []) as $item)
                @php
                    $num = data_get($item, 'num');
                    $title = data_get($item, 'title');
                    $bg = \App\Support\HomeView::url(data_get($item, 'image'));
                    $servicePage = \App\Models\ServicePage::query()
                        ->where('service_num', (int) $num)
                        ->where('is_active', true)
                        ->first();

                    $href = $servicePage ? route('service.page', $servicePage->slug) : '#devis';
                    if ($servicePage && !empty($servicePage->featured_image)) {
                        $bg = \App\Support\HomeView::url($servicePage->featured_image);
                    }
                    $ctaText = $servicePage && !empty($servicePage->cta_text)
                        ? $servicePage->cta_text
                        : data_get($item, 'cta', 'En savoir plus');
                @endphp
                <article class="service-card relative h-[340px] overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-soft transition hover:-translate-y-0.5 hover:shadow-md sm:h-[360px] lg:h-[380px]">
                    <div class="absolute inset-0">
                        <img
                            src="{{ $bg }}"
                            alt="{{ $title }}"
                            class="h-full w-full object-cover transition duration-300"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/95 via-brand-dark/65 to-transparent"></div>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 z-10 p-6">
                        <h3 class="text-2xl font-black leading-snug text-white sm:text-3xl">
                            {{ $title }}
                        </h3>
                        <p class="mt-3 text-sm leading-relaxed text-white/90">
                            {{ data_get($item, 'description') }}
                        </p>
                        <a href="{{ $href }}" class="mt-5 inline-flex w-fit rounded-xl bg-brand-blue px-4 py-2 text-xs font-extrabold text-white shadow-soft transition hover:bg-brand-dark sm:text-sm">
                            {{ $ctaText }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
