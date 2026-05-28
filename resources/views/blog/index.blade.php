@php
    $h = app(\App\Services\HomePageService::class)->merged();
    $title = 'Blog — Normes & Rénovation';
    $description = 'Conseils rénovation, travaux, toiture, isolation et performance énergétique : retrouvez nos articles et guides.';
    $canonicalUrl = url('/blog');
    $heroBg = \App\Support\HomeView::url('/slide/toiture.png');
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'title' => $title,
    'description' => $description,
    'canonicalUrl' => $canonicalUrl,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<section id="top" class="relative min-h-[440px] overflow-hidden sm:min-h-[500px]">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $heroBg }}');" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[440px] w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:min-h-[500px] sm:px-6 sm:py-10 lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">Conseils</p>
                            <h1 class="mb-4 text-2xl font-black leading-[1.06] tracking-tight drop-shadow-md sm:text-4xl lg:text-5xl">
                    <span>Le</span> <span class="text-brand-blue">blog toiture</span>
                </h1>
                <p class="max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                    Des conseils concrets, des photos de chantier et des contenus pensés pour les recherches autour du couvreur à Chalon-sur-Saône, de la rénovation de toiture et de l'entretien du toit.
                </p>
                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-white/90">Couvreur à Chalon-sur-Saône</span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-white/90">Rénovation toiture</span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-white/90">Réparation toiture</span>
                </div>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#articles" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Voir les articles
                    </a>
                    <a href="{{ route('contact.page') }}#devis" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Demander un devis
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">
    <section id="articles" class="scroll-mt-24 bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            @if ($posts->count() === 0)
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                    <p class="text-base font-bold text-slate-700">Aucun article publié pour le moment.</p>
                    <p class="mt-2 text-sm text-slate-500">Revenez bientôt, nous préparons de nouveaux contenus.</p>
                </div>
            @else
                <div class="text-center">
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">Articles</p>
                    <h2 class="mx-auto mt-3 max-w-2xl text-2xl font-black leading-tight tracking-tight text-brand-dark sm:text-3xl">
                        <span class="text-brand-blue">Guides</span> &amp; conseils
                    </h2>
                    <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-brand-blue"></div>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-x-8 md:gap-y-10 lg:gap-x-10">
                    @foreach ($posts as $post)
                        @php
                            $img = trim((string) $post->featured_image) !== '' ? \App\Support\HomeView::url($post->featured_image) : \App\Support\HomeView::url('/slide/toiture.png');
                            $postUrl = route('blog.show', $post->slug);
                            $metaTitle = trim((string) $post->meta_title) !== '' ? $post->meta_title : $post->title;
                            $excerpt = trim((string) $post->excerpt);
                            $imgAlt = trim((string) $post->title) !== ''
                                ? 'Photo chantier couvreur à Chalon-sur-Saône : '.$post->title
                                : 'Illustration article Normes Rénovation';
                        @endphp
                        <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:p-8">
                            <div class="relative overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200/80">
                                <img src="{{ $img }}" alt="{{ $imgAlt }}" class="aspect-[16/9] w-full object-cover" loading="lazy" decoding="async">
                            </div>
                            <p class="mt-5 text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                {{ optional($post->published_at)->format('d/m/Y') }}
                            </p>
                            <h2 class="mt-2 text-xl font-black tracking-tight text-brand-dark sm:text-2xl">
                                {{ $metaTitle }}
                            </h2>
                            @if ($excerpt !== '')
                                <p class="mt-3 text-base leading-relaxed text-slate-600">
                                    {{ $excerpt }}
                                </p>
                            @endif
                            <div class="mt-6 mt-auto">
                                <a href="{{ $postUrl }}" class="inline-flex items-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2">
                                    Lire l'article
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
</main>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
