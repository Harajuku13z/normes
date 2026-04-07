@php
    $h = app(\\App\\Services\\HomePageService::class)->merged();
    $title = trim((string) $post->meta_title) !== '' ? $post->meta_title : $post->title.' — Blog';
    $description = trim((string) $post->meta_description) !== '' ? $post->meta_description : (trim((string) $post->excerpt) !== '' ? $post->excerpt : 'Article du blog Normes & Rénovation.');
    $canonicalUrl = trim((string) $post->canonical_url) !== '' ? $post->canonical_url : url('/blog/'.$post->slug);
    $ogImage = trim((string) $post->og_image) !== '' ? $post->og_image : $post->featured_image;
    $img = trim((string) $post->featured_image) !== '' ? \\App\\Support\\HomeView::url($post->featured_image) : \\App\\Support\\HomeView::url('/slide/toiture.png');

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
                'url' => \\App\\Support\\HomeView::url(data_get($h, 'meta.og_image', 'logo.png')),
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
    'canonicalUrl' => $canonicalUrl,
    'ogImage' => $ogImage,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<main>
    <section class="relative overflow-hidden bg-brand-dark py-16 text-white sm:py-20">
        <div class="absolute inset-0 opacity-70" aria-hidden="true">
            <img src="{{ $img }}" alt="" class="h-full w-full object-cover" loading="lazy" decoding="async">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-dark/95 via-brand-dark/75 to-brand-blue/30"></div>
        </div>
        <div class="relative mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <nav class="text-xs font-extrabold uppercase tracking-wide text-white/80">
                <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a>
                <span class="mx-2 text-white/40">/</span>
                <span class="text-white/90">{{ $post->title }}</span>
            </nav>
            <h1 class="mt-4 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl">{{ $post->title }}</h1>
            @if (trim((string) $post->excerpt) !== '')
                <p class="mt-5 max-w-3xl text-base leading-relaxed text-slate-100/90 sm:text-lg">{{ $post->excerpt }}</p>
            @endif
            <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-bold text-white/80">
                @if ($post->published_at)
                    <span class="rounded-full bg-white/10 px-3 py-1">Publié le {{ $post->published_at->format('d/m/Y') }}</span>
                @endif
                <span class="rounded-full bg-white/10 px-3 py-1">Conseils rénovation</span>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-white to-slate-50 py-12 sm:py-16">
        <div class="mx-auto grid w-[95%] gap-10 px-4 sm:px-6 lg:grid-cols-[1fr_360px] lg:gap-12 lg:px-8">
            {{-- Contenu (landing-like) --}}
            <article class="min-w-0">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-10">
                    <div class="prose prose-slate max-w-none prose-h2:mt-10 prose-h2:text-2xl prose-h2:font-black prose-h3:text-xl prose-a:text-brand-blue prose-a:font-bold prose-img:rounded-2xl prose-img:shadow-soft">
                        {!! $post->content_html !!}
                    </div>
                </div>
            </article>

            {{-- Sidebar conversion --}}
            <aside class="lg:sticky lg:top-24">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
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
            </aside>
        </div>
    </section>

    <script type="application/ld+json">{!! json_encode($articleLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</main>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>

