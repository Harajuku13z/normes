@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $metaTitle = 'Services | '.(string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaDescription = 'Découvrez tous nos services de rénovation énergétique : toiture, façade, isolation, ventilation, photovoltaïque et plus.';
    $metaKeywords = trim((string) data_get($h, 'meta.keywords', ''));
    $canonicalUrl = route('services.index');
    $ogImage = trim((string) data_get($h, 'meta.og_image', 'logo.png'));
@endphp

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'title' => $metaTitle,
    'description' => $metaDescription,
    'keywords' => $metaKeywords,
    'canonicalUrl' => $canonicalUrl,
    'ogImage' => $ogImage,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<section class="bg-slate-50/70 py-14 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl">
                <span class="text-brand-blue">Nos services</span> de rénovation
            </h1>
            <p class="mt-3 max-w-3xl text-base text-slate-600 sm:text-lg">
                Parcourez l’ensemble de nos prestations. Chaque fiche service détaille les solutions proposées, les étapes et les documents techniques associés.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($pages as $page)
                @php
                    $title = trim((string) ($page->title ?? ''));
                    $desc = trim((string) ($page->meta_description ?? ''));
                    if ($desc === '') {
                        $desc = trim((string) ($page->intro ?? ''));
                    }
                    $img = trim((string) ($page->featured_image ?? ''));
                    if ($img === '') {
                        $img = trim((string) ($page->image ?? ''));
                    }
                    $imgUrl = HomeView::url($img !== '' ? $img : 'slide/toiture.png');
                @endphp
                <article class="service-card relative h-[380px] overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-soft transition hover:-translate-y-0.5 hover:shadow-md sm:h-[410px] lg:h-[440px]">
                    <div class="absolute inset-0">
                        <img
                            src="{{ $imgUrl }}"
                            alt="{{ $title }}"
                            class="h-full w-full object-cover transition duration-300"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/95 via-brand-dark/65 to-transparent"></div>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 z-10 p-6">
                        <h2 class="text-2xl font-black leading-snug text-white sm:text-3xl">
                            {{ $title }}
                        </h2>
                        <p class="mt-3 text-sm leading-relaxed text-white/90">
                            {{ $desc }}
                        </p>
                        <a href="{{ route('service.page', $page->slug) }}" class="mt-5 inline-flex w-fit rounded-xl bg-brand-blue px-4 py-2 text-xs font-extrabold text-white shadow-soft transition hover:bg-brand-dark sm:text-sm">
                            En savoir plus
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>

