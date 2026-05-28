@php
    $h = app(\App\Services\HomePageService::class)->merged();
    $title = trim((string) $post->meta_title) !== '' ? $post->meta_title : $post->title.' — Blog';
    $description = trim((string) $post->meta_description) !== '' ? $post->meta_description : (trim((string) $post->excerpt) !== '' ? $post->excerpt : 'Article du blog Normes & Rénovation.');
    $canonicalUrl = trim((string) $post->canonical_url) !== '' ? $post->canonical_url : url('/blog/'.$post->slug);
    $ogImage = trim((string) $post->og_image) !== '' ? $post->og_image : $post->featured_image;
    $img = trim((string) $post->featured_image) !== '' ? \App\Support\HomeView::url($post->featured_image) : \App\Support\HomeView::url('/slide/toiture.png');
    $imgAlt = trim((string) $post->title) !== ''
        ? 'Photo chantier couvreur à Chalon-sur-Saône : '.$post->title
        : 'Illustration article Normes Rénovation';
    $shareUrl = $canonicalUrl;
    $shareTitle = $post->title;
    $shareText = trim((string) $post->excerpt) !== '' ? $post->excerpt : $post->title;
    $shareFacebook = 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($shareUrl);
    $shareLinkedin = 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode($shareUrl);
    $shareX = 'https://twitter.com/intent/tweet?url='.urlencode($shareUrl).'&text='.urlencode($shareTitle);
    $shareWhatsapp = 'https://wa.me/?text='.urlencode($shareTitle.' '.$shareUrl);
    $keywordBadges = collect(explode(',', (string) $post->meta_keywords))
        ->map(fn ($item) => trim((string) $item))
        ->filter()
        ->take(4)
        ->values();

    $articleLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'datePublished' => optional($post->published_at)->toIso8601String(),
        'dateModified' => optional($post->updated_at)->toIso8601String(),
        'image' => [$img],
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonicalUrl],
        'publisher' => [
            '@type' => 'Organization',
            'name' => data_get($h, 'meta.site_name', 'Normes & Rénovation'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => \App\Support\HomeView::url(data_get($h, 'meta.og_image', 'logo.png')),
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'title' => $title,
    'description' => $description,
    'keywords' => $post->meta_keywords,
    'canonicalUrl' => $canonicalUrl,
    'ogImage' => $ogImage,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<main>
    <section class="relative overflow-hidden bg-brand-dark py-12 text-white sm:py-16">
        <div class="absolute inset-0 opacity-70" aria-hidden="true">
            <div class="absolute -top-24 left-1/2 h-72 w-[40rem] -translate-x-1/2 rounded-full bg-brand-blue/25 blur-3xl"></div>
            <div class="absolute -bottom-24 right-0 h-72 w-[32rem] rounded-full bg-brand-yellow/20 blur-3xl"></div>
        </div>
        <div class="relative mx-auto grid w-[95%] gap-8 px-4 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:items-center lg:px-8">
            <div>
                <nav class="text-xs font-extrabold uppercase tracking-wide text-white/80">
                    <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a>
                    <span class="mx-2 text-white/40">/</span>
                    <span class="text-white/90">{{ $post->title }}</span>
                </nav>
                <p class="mt-5 text-xs font-extrabold uppercase tracking-[0.28em] text-brand-yellow">Guide local toiture</p>
                <h1 class="mt-3 max-w-5xl text-4xl font-black leading-[1.02] tracking-tight sm:text-5xl lg:text-6xl">{{ $post->title }}</h1>
                @if (trim((string) $post->excerpt) !== '')
                    <p class="mt-5 max-w-3xl text-base leading-8 text-white/85 sm:text-lg">{{ $post->excerpt }}</p>
                @endif
                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-bold text-white/80">
                    @if ($post->published_at)
                        <span class="rounded-full bg-white/10 px-3 py-1">Publié le {{ $post->published_at->format('d/m/Y') }}</span>
                    @endif
                    <span class="rounded-full bg-white/10 px-3 py-1">Conseils rénovation</span>
                    <span class="rounded-full bg-white/10 px-3 py-1">Photos de chantier réelles</span>
                </div>
                @if ($keywordBadges->isNotEmpty())
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($keywordBadges as $badge)
                            <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-white/90">{{ $badge }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('contact.page') }}#devis" class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">Demander un devis</a>
                    <a href="{{ route('simulateur.start') }}" class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-white/15">Lancer le simulateur</a>
                </div>
            </div>
            <div class="overflow-hidden rounded-[28px] border border-white/10 bg-white/10 shadow-2xl backdrop-blur-sm">
                <img src="{{ $img }}" alt="{{ $imgAlt }}" class="aspect-[4/3] w-full object-cover" loading="eager" decoding="async">
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-white to-slate-50 py-14 sm:py-18">
        <div class="mx-auto grid w-[95%] gap-12 px-4 sm:px-6 lg:grid-cols-[1fr_360px] lg:gap-14 lg:px-8">
            {{-- Contenu (landing-like) --}}
            <article class="min-w-0">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-12">
                    <div class="mb-12 grid gap-5 rounded-[30px] border border-slate-200 bg-slate-50 p-6 sm:grid-cols-[1.1fr_0.9fr] sm:p-7">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-[0.24em] text-slate-500">Ce que vous allez trouver</p>
                            <h2 class="mt-3 text-2xl font-black tracking-tight text-brand-dark sm:text-[2rem]">Des conseils concrets pour décider les bons travaux</h2>
                            <p class="mt-4 text-sm leading-7 text-slate-700">Nous avons réuni ici des exemples de chantiers, les points à surveiller sur un toit et les solutions les plus pertinentes selon l'état de la couverture.</p>
                        </div>
                        <div class="grid gap-3.5">
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-bold leading-6 text-slate-700">Exemples avant / après de réalisations</div>
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-bold leading-6 text-slate-700">Repères utiles pour diagnostiquer le toit</div>
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-bold leading-6 text-slate-700">Accès direct au devis et au simulateur</div>
                        </div>
                    </div>
                    <div class="prose prose-slate max-w-none prose-p:my-0 prose-p:mb-6 prose-p:max-w-none prose-p:text-[1.02rem] prose-p:leading-8 prose-p:text-slate-700 prose-h2:mt-14 prose-h2:mb-5 prose-h2:border-l-4 prose-h2:border-brand-blue prose-h2:pl-4 prose-h2:text-3xl prose-h2:font-black prose-h2:tracking-tight prose-h3:mt-8 prose-h3:mb-3 prose-h3:text-xl prose-h3:font-black prose-a:text-brand-blue prose-a:font-bold prose-figure:my-0 prose-img:rounded-2xl prose-img:shadow-soft">
                        {!! $post->content_html !!}
                    </div>
                </div>
            </article>

            {{-- Sidebar conversion --}}
            <aside class="lg:sticky lg:top-24">
                {{-- Partage + Like --}}
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Partager</p>
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a href="{{ $shareFacebook }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-700 hover:border-brand-blue/40 hover:text-brand-blue">Facebook</a>
                        <a href="{{ $shareLinkedin }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-700 hover:border-brand-blue/40 hover:text-brand-blue">LinkedIn</a>
                        <a href="{{ $shareX }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-700 hover:border-brand-blue/40 hover:text-brand-blue">X</a>
                        <a href="{{ $shareWhatsapp }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-700 hover:border-brand-blue/40 hover:text-brand-blue">WhatsApp</a>
                    </div>
                </div>

                {{-- Devis --}}
                <div class="mt-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Besoin d'un devis ?</p>
                    <p class="mt-2 text-xl font-black text-brand-dark">Parlons de votre projet</p>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Un conseiller vous rappelle pour affiner le chiffrage et vérifier les aides.</p>
                    <div class="mt-5 flex flex-col gap-2">
                        <a href="{{ route('contact.page') }}#devis" class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">Demander un devis</a>
                        <a href="{{ route('simulateur.start') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-slate-200 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark transition hover:border-brand-blue/40">Lancer le simulateur</a>
                    </div>
                    <div class="mt-5 grid gap-2 text-xs font-bold text-slate-600">
                        <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-brand-yellow"></span> Réponse sous 48h en général</div>
                        <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-brand-blue"></span> Sans engagement</div>
                        <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Entreprise RGE</div>
                    </div>
                </div>

                {{-- Derniers articles --}}
                @if (isset($latestPosts) && $latestPosts->count())
                    <div class="mt-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">À lire aussi</p>
                        <ul class="mt-4 space-y-3">
                            @foreach ($latestPosts as $lp)
                                <li>
                                    <a href="{{ route('blog.show', $lp->slug) }}" class="group block rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-800 hover:border-brand-blue/40 hover:text-brand-blue">
                                        <span class="line-clamp-2">{{ $lp->title }}</span>
                                        <span class="mt-1 block text-[11px] font-bold text-slate-500 group-hover:text-brand-blue/80">{{ optional($lp->published_at)->format('d/m/Y') }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('blog.index') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-xl border-2 border-slate-200 bg-white px-4 py-2.5 text-xs font-extrabold text-brand-dark hover:border-brand-blue/40">
                            Voir tous les articles
                        </a>
                    </div>
                @endif
            </aside>
        </div>
    </section>

    <script type="application/ld+json">{!! json_encode($articleLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

</main>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
