@php
    use App\Support\HomeView;
    use Illuminate\Support\Str;

    $h = $home ?? [];
    $rp = data_get($h, 'realisations_page', []);
    if (! is_array($rp)) {
        $rp = [];
    }
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = $project->title.' | Réalisations | '.$siteName;
    $plainDesc = trim(strip_tags((string) $project->description));
    $metaDescription = $plainDesc !== '' ? Str::limit($plainDesc, 160) : trim((string) data_get($rp, 'meta_description', 'Découvrez ce chantier et nos autres réalisations.'));
    if ($metaDescription === '') {
        $metaDescription = 'Découvrez ce chantier et nos autres réalisations.';
    }
    $metaKeywords = trim((string) data_get($rp, 'meta_keywords', ''));
    $firstImage = $project->images->first();
    $ogImage = $firstImage
        ? HomeView::url((string) $firstImage->path)
        : HomeView::url((string) data_get($rp, 'og_image', data_get($h, 'meta.og_image', 'logo.png')));
    $canonicalUrl = route('realisations.show', $project);
    $canonicalPath = route('realisations.show', $project, false);
    $listPath = route('realisations.page', [], false);
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
<a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[2000] focus:rounded-xl focus:bg-white focus:px-4 focus:py-3 focus:text-sm focus:font-extrabold focus:text-brand-dark focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-blue">Aller au contenu</a>
@include('home.header', ['home' => $h])

<main id="contenu" class="scroll-mt-24">
    <section class="border-b border-slate-200 bg-slate-50 py-8 sm:py-10" aria-labelledby="realisation-detail-title">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-600" aria-label="Fil d'Ariane">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                    <li><a href="{{ url('/') }}" class="font-semibold text-brand-blue hover:underline">Accueil</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ url($listPath) }}" class="font-semibold text-brand-blue hover:underline">Réalisations</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="font-semibold text-slate-900">{{ Str::limit($project->title, 64) }}</li>
                </ol>
            </nav>
            <h1 id="realisation-detail-title" class="mt-6 text-3xl font-black leading-tight tracking-tight text-brand-dark sm:text-4xl">
                {{ $project->title }}
            </h1>
            @if ($plainDesc !== '')
                <div class="mt-6 max-w-3xl text-base leading-relaxed text-slate-700">
                    {!! nl2br(e($project->description)) !!}
                </div>
            @endif
        </div>
    </section>

    <section class="bg-white py-12 sm:py-16" aria-labelledby="realisation-gallery-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h2 id="realisation-gallery-heading" class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">Galerie photos</h2>
            <p class="mt-2 text-lg font-bold text-brand-dark">Toutes les photos de ce chantier</p>
            @if ($project->images->isEmpty())
                <p class="mt-6 text-slate-600">Photos à venir.</p>
            @else
                <div class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($project->images as $img)
                        @php
                            $src = HomeView::url((string) $img->path);
                            $alt = trim((string) $img->alt) !== '' ? $img->alt : $project->title;
                        @endphp
                        <figure class="overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200/80">
                            <img
                                src="{{ $src }}"
                                alt="{{ $alt }}"
                                class="aspect-[4/3] w-full object-cover"
                                width="800"
                                height="600"
                                loading="lazy"
                                decoding="async"
                            >
                        </figure>
                    @endforeach
                </div>
            @endif

            <p class="mt-12">
                <a
                    href="{{ url($listPath) }}"
                    class="inline-flex items-center rounded-xl border-2 border-brand-dark bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue"
                >
                    ← Toutes les réalisations
                </a>
            </p>
        </div>
    </section>
</main>

@include('home.devis', ['home' => $h])

@php
    $imageObjects = $project->images->map(function ($img) use ($project) {
        return [
            '@type' => 'ImageObject',
            'url' => HomeView::url((string) $img->path),
            'caption' => trim((string) $img->alt) !== '' ? $img->alt : $project->title,
        ];
    })->values()->all();

    $detailLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $project->title,
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
                    'item' => url($listPath),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $project->title,
                    'item' => url($canonicalPath),
                ],
            ],
        ],
    ];
    if ($imageObjects !== []) {
        $detailLd['image'] = $imageObjects;
    }
@endphp
<script type="application/ld+json">{!! json_encode($detailLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
