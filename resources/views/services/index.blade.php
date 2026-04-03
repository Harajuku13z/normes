@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $metaTitle = 'Services | '.(string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaDescription = 'Découvrez tous nos services de rénovation énergétique : toiture, façade, isolation, ventilation, photovoltaïque et plus.';
    $metaKeywords = trim((string) data_get($h, 'meta.keywords', ''));
    $canonicalUrl = route('services.index', [], false);
    $ogImage = trim((string) data_get($h, 'meta.og_image', 'logo.png'));
    $heroBg = HomeView::url('slide/toiture.png');
    $contactHref = route('contact.page', [], false).'#devis';
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

<section id="top" class="relative min-h-[520px] overflow-hidden sm:min-h-[620px]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $heroBg }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto flex min-h-[520px] w-[95%] flex-col justify-end gap-6 px-4 py-10 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">
                    Nos prestations
                </p>
                <h1 class="mb-4 text-4xl font-black leading-[1.02] tracking-tight drop-shadow sm:text-5xl">
                    Nos services de rénovation énergétique
                </h1>
                <p class="mb-2 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                    Parcourez l’ensemble de nos prestations. Chaque fiche service détaille les solutions proposées, les étapes et les documents techniques associés.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a
                        href="#services-list"
                        class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500"
                    >
                        Voir les services
                    </a>
                    <a
                        href="{{ $contactHref }}"
                        class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300"
                    >
                        Devis gratuit
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services-list" class="scroll-mt-24 bg-slate-50/70 py-14 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
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
                        <a href="{{ route('service.page', $page->slug, false) }}" class="mt-5 inline-flex w-fit rounded-xl bg-brand-blue px-4 py-2 text-xs font-extrabold text-white shadow-soft transition hover:bg-brand-dark sm:text-sm">
                            En savoir plus
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-14 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        @include('services.avis_only', ['home' => $h])
    </div>
</section>

@include('home.devis', ['home' => $h])

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>

