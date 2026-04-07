@php
    $h = app(\\App\\Services\\HomePageService::class)->merged();
    $title = 'Blog — Normes & Rénovation';
    $description = 'Conseils rénovation, travaux, toiture, isolation et performance énergétique : retrouvez nos articles et guides.';
    $canonicalUrl = url('/blog');
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

<main class="bg-gradient-to-b from-slate-50 to-white">
    <section class="relative overflow-hidden py-16 sm:py-20">
        <div class="absolute inset-0 opacity-60" aria-hidden="true">
            <div class="absolute -top-24 left-1/2 h-72 w-[40rem] -translate-x-1/2 rounded-full bg-brand-blue/25 blur-3xl"></div>
            <div class="absolute -bottom-24 right-0 h-72 w-[32rem] rounded-full bg-brand-yellow/25 blur-3xl"></div>
        </div>
        <div class="relative mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-black tracking-tight text-brand-dark sm:text-5xl">Le blog</h1>
            <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                Des conseils concrets et des retours terrain pour réussir votre rénovation, optimiser vos aides et gagner en confort.
            </p>
        </div>
    </section>

    <section class="pb-16 sm:pb-20">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            @if ($posts->count() === 0)
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                    <p class="text-base font-bold text-slate-700">Aucun article publié pour le moment.</p>
                    <p class="mt-2 text-sm text-slate-500">Revenez bientôt, nous préparons de nouveaux contenus.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        @php
                            $img = trim((string) $post->featured_image) !== '' ? \\App\\Support\\HomeView::url($post->featured_image) : \\App\\Support\\HomeView::url('/slide/toiture.png');
                            $postUrl = route('blog.show', $post->slug);
                            $metaTitle = trim((string) $post->meta_title) !== '' ? $post->meta_title : $post->title;
                            $excerpt = trim((string) $post->excerpt);
                        @endphp
                        <article class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-md">
                            <a href="{{ $postUrl }}" class="block">
                                <div class="relative h-48 overflow-hidden bg-slate-100">
                                    <img src="{{ $img }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy" decoding="async">
                                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/40 to-transparent"></div>
                                </div>
                                <div class="p-6">
                                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                        {{ optional($post->published_at)->format('d/m/Y') }}
                                    </p>
                                    <h2 class="mt-2 line-clamp-2 text-xl font-black text-brand-dark transition group-hover:text-brand-blue">
                                        {{ $metaTitle }}
                                    </h2>
                                    @if ($excerpt !== '')
                                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $excerpt }}</p>
                                    @endif
                                    <div class="mt-5 inline-flex items-center gap-2 rounded-xl bg-brand-dark px-5 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-soft transition group-hover:-translate-y-0.5 group-hover:bg-slate-900">
                                        Lire l'article <span aria-hidden="true">→</span>
                                    </div>
                                </div>
                            </a>
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

