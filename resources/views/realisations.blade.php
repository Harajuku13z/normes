@php
    use App\Support\HomeView;
    use Illuminate\Support\Str;

    $h = $home ?? [];
    $rp = data_get($h, 'realisations_page', []);
    if (! is_array($rp)) {
        $rp = [];
    }
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = trim((string) data_get($rp, 'meta_title', ''));
    if ($metaTitle === '') {
        $metaTitle = 'Réalisations | '.$siteName;
    }
    $metaDescription = trim((string) data_get($rp, 'meta_description', ''));
    if ($metaDescription === '') {
        $metaDescription = 'Découvrez nos chantiers et réalisations en rénovation.';
    }
    $metaKeywords = trim((string) data_get($rp, 'meta_keywords', ''));
    $ogImage = trim((string) data_get($rp, 'og_image', data_get($h, 'meta.og_image', 'logo.png')));
    $canonicalUrl = route('realisations.page');
    $heroBg = HomeView::url((string) data_get($rp, 'hero_bg', 'slide/toiture.png'));
    $heroKicker = trim((string) data_get($rp, 'hero_kicker', 'Chantiers'));
    $heroH1Primary = trim((string) data_get($rp, 'hero_h1_primary', 'Nos réalisations'));
    $heroH1Accent = trim((string) data_get($rp, 'hero_h1_accent', 'en images'));
    $heroIntro = trim((string) data_get($rp, 'hero_intro', ''));
    $canonicalPath = route('realisations.page', [], false);

    $preloadImages = [$heroBg];
    foreach ($projects ?? [] as $proj) {
        if (! $proj->relationLoaded('images')) {
            continue;
        }
        foreach ($proj->images->take(2) as $im) {
            $u = HomeView::url((string) $im->path);
            if ($u !== '') {
                $preloadImages[] = $u;
            }
        }
    }
    $preloadImages = array_values(array_unique(array_filter($preloadImages)));
    $preloadImages = array_slice($preloadImages, 0, 8);
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
    'preloadImages' => $preloadImages,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
<a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[2000] focus:rounded-xl focus:bg-white focus:px-4 focus:py-3 focus:text-sm focus:font-extrabold focus:text-brand-dark focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-blue">Aller au contenu</a>
@include('home.header', ['home' => $h])

<section id="top" class="relative min-h-[440px] overflow-hidden sm:min-h-[500px]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $heroBg }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[440px] w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:min-h-[500px] sm:px-6 sm:py-10 lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                @if ($heroKicker !== '')
                    <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">
                        {{ $heroKicker }}
                    </p>
                @endif
                <h1 class="mb-4 text-2xl font-black leading-[1.06] tracking-tight drop-shadow-md sm:text-4xl lg:text-5xl">
                    <span>{{ $heroH1Primary }}</span>
                    @if ($heroH1Accent !== '')
                        <span class="text-brand-blue"> {{ $heroH1Accent }}</span>
                    @endif
                </h1>
                @if ($heroIntro !== '')
                    <p class="max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                        {{ $heroIntro }}
                    </p>
                @endif
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#projets" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Voir les projets
                    </a>
                    <a href="#devis" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Demander un devis
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">
    <section id="projets" class="scroll-mt-24 bg-slate-50 py-12 sm:py-16" aria-labelledby="realisations-list-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">Galerie</p>
                <h2 id="realisations-list-heading" class="mx-auto mt-3 max-w-2xl text-2xl font-black leading-tight tracking-tight text-brand-dark sm:text-3xl">
                    <span class="text-brand-blue">Projets</span> présentés
                </h2>
                <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-brand-blue"></div>
            </div>

            @if ($projects->isEmpty())
                <p class="mx-auto mt-12 max-w-lg text-center text-slate-600">
                    Les réalisations seront publiées prochainement.
                </p>
            @else
                <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-x-8 md:gap-y-10 lg:gap-x-10">
                    @foreach ($projects as $projectIndex => $project)
                        <article
                            class="flex h-full flex-col rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8"
                            aria-labelledby="projet-{{ $project->id }}-title"
                        >
                            <h3 id="projet-{{ $project->id }}-title" class="text-xl font-black tracking-tight text-brand-dark sm:text-2xl">
                                {{ $project->title }}
                            </h3>
                            @php
                                $descRaw = trim((string) $project->description);
                                $excerpt = $descRaw !== '' ? Str::limit($descRaw, 200) : '';
                            @endphp
                            @if ($excerpt !== '')
                                <p class="mt-3 text-base leading-relaxed text-slate-600">
                                    {{ $excerpt }}
                                </p>
                            @endif

                            @php
                                $previewImages = $project->images->take(3);
                                $thumbCount = $previewImages->count();
                            @endphp
                            @if ($thumbCount > 0)
                                <div class="mt-6 grid grid-cols-2 gap-1.5 sm:gap-2 md:grid-cols-4 md:gap-3">
                                    @foreach ($previewImages as $imgIndex => $img)
                                        @php
                                            $src = HomeView::url((string) $img->path);
                                            $alt = trim((string) $img->alt) !== '' ? $img->alt : $project->title;
                                            $eagerThumb = $projectIndex === 0 && $imgIndex < 3;
                                        @endphp
                                        <figure class="min-w-0 overflow-hidden rounded-lg bg-slate-100 ring-1 ring-slate-200/80">
                                            <img
                                                src="{{ $src }}"
                                                alt="{{ $alt }}"
                                                class="aspect-[4/3] w-full object-cover"
                                                width="240"
                                                height="180"
                                                loading="{{ $eagerThumb ? 'eager' : 'lazy' }}"
                                                decoding="async"
                                                @if ($projectIndex === 0 && $imgIndex === 0) fetchpriority="high" @endif
                                            >
                                        </figure>
                                    @endforeach
                                    @for ($i = $thumbCount; $i < 3; $i++)
                                        <div class="aspect-[4/3] min-h-0 rounded-lg bg-slate-50 ring-1 ring-slate-100/90" aria-hidden="true"></div>
                                    @endfor
                                    <a
                                        href="{{ route('realisations.show', $project) }}"
                                        class="flex min-h-0 min-w-0 flex-col items-center justify-center rounded-lg bg-brand-blue px-2 py-4 text-center text-base font-extrabold leading-tight text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 sm:px-3 sm:py-6 sm:text-lg md:text-xl"
                                    >
                                        Voir plus
                                    </a>
                                </div>
                            @else
                                <div class="mt-6 mt-auto pt-2">
                                    <a
                                        href="{{ route('realisations.show', $project) }}"
                                        class="inline-flex items-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2"
                                    >
                                        Voir plus
                                    </a>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>

@include('home.devis', ['home' => $h])

@php
    $realisationsLd = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $metaTitle,
        'description' => $metaDescription,
        'url' => url($canonicalPath),
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => url('/'),
        ],
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Accueil',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Réalisations',
                    'item' => url($canonicalPath),
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($realisationsLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
