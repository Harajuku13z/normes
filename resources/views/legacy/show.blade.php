@php
    use App\Services\Legacy\LegacyUrlContext;

    $h = $home ?? app(\App\Services\HomePageService::class)->merged();
    $ctx = $context ?? LegacyUrlContext::fromPath($requestedPath ?? '');

    $title = trim((string) ($page->title ?? ($ctx['h1'] ?? 'Normes Rénovation')));
    $h1 = trim((string) ($page->h1 ?: $title));
    $excerpt = trim((string) ($page->excerpt ?? ''));
    $contentHtml = (string) ($page->content_html ?? '');

    $metaTitle = trim((string) ($page->meta_title ?: ($ctx['metaTitle'] ?? $title)));
    $metaDescription = trim((string) ($page->meta_description ?: ($ctx['metaDescription'] ?? $excerpt)));
    $canonicalUrl = trim((string) ($page->canonical_url ?: url('/' . ltrim($requestedPath ?? '', '/'))));
    $ogImage = trim((string) ($page->og_image ?? ''));

    $serviceLabel = $ctx['serviceLabel'] ?? null;
    $city = $ctx['city'] ?? null;
    $phone = trim((string) data_get($h, 'header.phone', data_get($h, 'footer.phone', '')));
    $phoneHref = $phone !== '' ? 'tel:' . preg_replace('/[^\d+]/', '', $phone) : '';

    $ctaHref = route('contact.page', [], false) . '#devis';
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'title' => $metaTitle,
    'description' => $metaDescription,
    'canonicalUrl' => $canonicalUrl,
    'ogImage' => $ogImage,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<main>
    <section class="relative overflow-hidden bg-brand-dark text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(96,180,249,0.22),transparent_38%),linear-gradient(135deg,rgba(47,66,81,1),rgba(30,41,59,1))]"></div>
        <div class="relative mx-auto w-[95%] px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
            <nav class="mb-6 flex flex-wrap items-center gap-2 text-xs font-semibold text-white/70" aria-label="Fil d'Ariane">
                <a href="{{ route('home', [], false) }}" class="transition hover:text-white">Accueil</a>
                <span>/</span>
                @if ($serviceLabel)
                    <span>{{ $serviceLabel }}</span>
                    @if ($city)
                        <span>/</span>
                        <span>{{ $city }}</span>
                    @endif
                @else
                    <span>Page d'information</span>
                @endif
            </nav>

            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] lg:items-start">
                <div class="max-w-3xl">
                    <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-yellow">
                        Normes Rénovation
                    </p>
                    <h1 class="text-4xl font-black leading-tight sm:text-5xl">
                        {{ $h1 }}
                    </h1>
                    @if ($excerpt !== '')
                        <p class="mt-5 max-w-2xl text-lg leading-relaxed text-white/85">
                            {{ $excerpt }}
                        </p>
                    @elseif ($metaDescription !== '')
                        <p class="mt-5 max-w-2xl text-lg leading-relaxed text-white/85">
                            {{ $metaDescription }}
                        </p>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ $ctaHref }}" class="inline-flex items-center rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">
                            Demander un devis
                        </a>
                        @if ($phoneHref !== '')
                            <a href="{{ $phoneHref }}" class="inline-flex items-center rounded-xl border border-white/25 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-white/10">
                                {{ $phone }}
                            </a>
                        @endif
                    </div>
                </div>

                <aside class="rounded-3xl border border-white/15 bg-white/10 p-6 shadow-2xl backdrop-blur">
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-yellow">Pourquoi nous choisir</p>
                    <ul class="mt-4 space-y-3 text-sm text-white/90">
                        <li class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">Entreprise certifiée RGE</li>
                        <li class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">Devis gratuit sous 48h</li>
                        <li class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">Accompagnement sur les aides</li>
                    </ul>
                    <a href="{{ $ctaHref }}" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white transition hover:bg-sky-500">
                        Être rappelé
                    </a>
                </aside>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-12 sm:py-16">
        <div class="mx-auto grid w-[95%] gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_320px] lg:px-8">
            <article class="rounded-3xl bg-white p-6 shadow-soft sm:p-8">
                <div class="prose prose-slate max-w-none prose-headings:text-brand-dark prose-a:text-brand-blue">
                    {!! $contentHtml !== '' ? $contentHtml : '<p>Cette page d\'information est en cours de finalisation. Notre équipe reste disponible pour étudier votre projet et vous proposer un devis gratuit.</p>' !!}
                </div>
            </article>

            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-soft">
                    <p class="text-sm font-extrabold uppercase tracking-wide text-brand-blue">Besoin d’un conseil ?</p>
                    <h2 class="mt-2 text-2xl font-black text-brand-dark">Parlons de votre projet</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Toiture, isolation, façade, VMC ou rénovation globale : nous vous guidons vers la solution adaptée.
                    </p>
                    <div class="mt-5 flex flex-col gap-3">
                        <a href="{{ $ctaHref }}" class="inline-flex items-center justify-center rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark transition hover:bg-yellow-300">
                            Demander un devis
                        </a>
                        @if ($phoneHref !== '')
                            <a href="{{ $phoneHref }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50">
                                {{ $phone }}
                            </a>
                        @endif
                    </div>
                </div>

                @if ($serviceLabel || $city)
                    <div class="rounded-3xl border border-brand-blue/15 bg-brand-blue/5 p-6">
                        <p class="text-sm font-extrabold text-brand-dark">Contexte de la page</p>
                        <ul class="mt-4 space-y-2 text-sm text-slate-600">
                            @if ($serviceLabel)
                                <li>Service : {{ $serviceLabel }}</li>
                            @endif
                            @if ($city)
                                <li>Zone : {{ $city }}</li>
                            @endif
                            <li>URL : /{{ ltrim($requestedPath ?? '', '/') }}</li>
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>

    @include('home.services', ['home' => $h])
    @include('home.avis', ['home' => $h])
    @include('home.devis', ['home' => $h])
</main>

@include('home.footer', ['home' => $h])
@include('home.popup_simulateur', ['home' => $h])
@include('home.cookie_consent', ['home' => $h])
@include('home.countup_script')
@include('home.scripts', ['home' => $h])
</body>
</html>
