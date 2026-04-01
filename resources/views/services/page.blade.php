@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $bg = HomeView::url($page->image ?? '');
    $contactHref = route('contact.page').'#devis';
    $ctaHref = $page->cta_href
        ? (str_starts_with((string) $page->cta_href, 'http') ? (string) $page->cta_href : (string) $page->cta_href)
        : $contactHref;

    $secondaryHref = $contactHref;
    $secondaryText = 'Devis gratuit';
    $ov = is_array($page->content_overrides ?? null) ? $page->content_overrides : [];

    $introKicker = trim((string) data_get($ov, 'intro.kicker', 'En bref'));
    $introBadges = collect((array) data_get($ov, 'intro.badges', []))
        ->map(fn ($v) => trim((string) $v))
        ->filter(fn ($v) => $v !== '')
        ->values()
        ->all();
    if ($introBadges === []) {
        $introBadges = ['Sans engagement', 'Réponse sous 48h', 'Devis gratuit'];
    }
    $expertiseKicker = trim((string) data_get($ov, 'intro.expertise_kicker', 'Expertise'));
    $expertiseText = trim((string) data_get($ov, 'intro.expertise_text', 'Intervention soignée · Matériaux protégés · Finitions propres'));

    $navLabels = [
        'services' => trim((string) data_get($ov, 'subnav.services', 'Services')),
        'realisations' => trim((string) data_get($ov, 'subnav.realisations', 'Réalisations')),
        'avis' => trim((string) data_get($ov, 'subnav.avis', 'Avis')),
        'contact' => trim((string) data_get($ov, 'subnav.contact', 'Contact')),
    ];

    $processOverrides = is_array(data_get($ov, 'process')) ? data_get($ov, 'process') : [];
    $realisationsOverrides = is_array(data_get($ov, 'realisations')) ? data_get($ov, 'realisations') : [];
    $ctaCardOverrides = is_array(data_get($ov, 'cta_card')) ? data_get($ov, 'cta_card') : [];
    $subServiceCtaText = trim((string) data_get($ov, 'sub_services.cta_text', 'C’EST CE QU’IL ME FAUT'));
    $subServiceDocText = trim((string) data_get($ov, 'sub_services.doc_text', 'DOC TECHNIQUE'));
    $subServiceCardHeight = trim((string) data_get($ov, 'sub_services.card_height', 'normal'));
    $subServiceCardModel = trim((string) data_get($ov, 'sub_services.card_model', 'overlay'));
    if (! in_array($subServiceCardModel, ['overlay', 'split'], true)) {
        $subServiceCardModel = 'overlay';
    }
    $subServiceCardClass = $subServiceCardHeight === 'tall'
        ? 'service-card relative min-h-[450px] overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 transition hover:-translate-y-0.5 sm:min-h-[480px]'
        : 'service-card relative min-h-[300px] overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 transition hover:-translate-y-0.5 sm:min-h-[320px]';
    $subServiceSplitImageClass = $subServiceCardHeight === 'tall'
        ? 'h-56 w-full object-cover sm:h-64'
        : 'h-44 w-full object-cover sm:h-48';
    $statsHeadingText = trim((string) data_get($ov, 'stats.heading', 'Chiffres clés'));
    $statsLinkText = trim((string) data_get($ov, 'stats.link_text', 'Voir les avis'));
    $partnersHeadingText = trim((string) data_get($ov, 'partners.heading', 'Partenaires associés'));
    $partnersLinkText = trim((string) data_get($ov, 'partners.link_text', 'Nous contacter'));
    $avisOverrides = is_array(data_get($ov, 'avis')) ? data_get($ov, 'avis') : [];

    $metaTitle = trim((string) ($page->meta_title ?? ''));
    if ($metaTitle === '') {
        $metaTitle = trim((string) ($page->title ?? '')).' | '.(string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    }
    $metaDescription = trim((string) ($page->meta_description ?? ''));
    if ($metaDescription === '') {
        $metaDescription = trim((string) ($page->intro ?? data_get($h, 'meta.description', '')));
    }
    $metaKeywords = trim((string) ($page->meta_keywords ?? ''));
    $canonicalUrl = route('service.page', $page->slug);
    $ogImage = trim((string) ($page->image ?? data_get($h, 'meta.og_image', 'logo.png')));
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
        id="serviceHeroBg"
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $bg ?: HomeView::url('slide/toiture.png') }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto flex min-h-[520px] w-[95%] flex-col justify-end gap-6 px-4 py-10 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                @if (!empty($page->subtitle))
                    <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">
                        {{ $page->subtitle }}
                    </p>
                @endif
                <h1 class="mb-4 text-4xl font-black leading-[1.02] tracking-tight drop-shadow sm:text-5xl">
                    {{ $page->title }}
                </h1>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if (!empty($page->cta_text))
                        <a href="{{ $ctaHref }}"
                           class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                            {{ $page->cta_text }}
                        </a>
                    @endif
                    <a href="{{ $secondaryHref }}"
                       class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300">
                        {{ $secondaryText }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    // Navigation “à la Technitoit” : ancres vers les sections clés de la page.
    // On affiche toujours la nav, et on rend certains onglets optionnels selon le contenu disponible.
    $hasRole = trim((string) ($page->body ?? '')) !== '' || trim((string) ($page->intro ?? '')) !== '';
    $hasEtapes = is_array($page->sub_services ?? null) && $page->sub_services !== [];
@endphp

{{-- Intro + image mise en avant + CTA (juste après le hero) --}}
@php
    $introText = trim((string) ($page->intro ?? ''));
    if ($introText === '') {
        $introText = trim((string) ($page->meta_description ?? ''));
    }
    $featured = trim((string) ($page->featured_image ?? ''));
    $featuredUrl = $featured !== '' ? HomeView::url($featured) : ($bg ?: HomeView::url('slide/toiture.png'));
@endphp
@if ($introText !== '')
    <section class="bg-white py-10 sm:py-14">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft ring-1 ring-slate-100 lg:grid lg:grid-cols-[1.05fr_0.95fr]">
                <div class="p-6 sm:p-8 lg:p-10">
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">{{ $introKicker }}</p>
                    <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">
                        {{ $introText }}
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        @if (!empty($page->cta_text))
                            <a href="{{ $ctaHref }}" class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                                {{ $page->cta_text }}
                            </a>
                        @endif
                        <a href="{{ $secondaryHref }}" class="inline-flex items-center justify-center rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300">
                            {{ $secondaryText }}
                        </a>
                    </div>

                    <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2">
                        @foreach ($introBadges as $badge)
                            <span class="flex items-center gap-1.5 text-xs text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $badge }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="relative min-h-[260px] lg:min-h-full">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $featuredUrl }}')" aria-hidden="true"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-dark/85 via-brand-dark/35 to-transparent" aria-hidden="true"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                        <div class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 text-white backdrop-blur ring-1 ring-white/15">
                            <span class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">{{ $expertiseKicker }}</span>
                            <span class="text-sm font-bold text-white/95">{{ $expertiseText }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@php
    $bodyForNav = trim((string) ($page->body ?? ''));
    $subForNav = collect(is_array($page->sub_services ?? null) ? $page->sub_services : [])
        ->filter(fn ($s) => is_array($s) && !empty(data_get($s, 'title')) && !empty(data_get($s, 'image')))
        ->values()
        ->all();
    $navServicesAnchor = $bodyForNav !== '' ? '#role' : ($subForNav !== [] ? '#etapes' : '#top');
    $subNavLinkClass = 'inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-brand-dark transition hover:border-slate-300 hover:bg-slate-50';
@endphp

{{-- Ordre des liens = ordre vertical de la page ; pas de barre fixe (scroll avec le contenu) --}}
<div class="border-b border-slate-200/80 bg-white">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 py-3" aria-label="Navigation de la page service">
            <a href="{{ $navServicesAnchor }}" class="{{ $subNavLinkClass }}">
                {{ $navLabels['services'] !== '' ? $navLabels['services'] : 'Services' }}
            </a>
            <a href="#realisations" class="{{ $subNavLinkClass }}">
                {{ $navLabels['realisations'] !== '' ? $navLabels['realisations'] : 'Réalisations' }}
            </a>
            <a href="#avis" class="{{ $subNavLinkClass }}">
                {{ $navLabels['avis'] !== '' ? $navLabels['avis'] : 'Avis' }}
            </a>
            <a href="#devis" class="{{ $subNavLinkClass }}">
                {{ $navLabels['contact'] !== '' ? $navLabels['contact'] : 'Contact' }}
            </a>
        </nav>
    </div>
</div>

@php
    $subServicesRaw = is_array($page->sub_services ?? null) ? $page->sub_services : [];
    $subServices = collect($subServicesRaw)
        ->filter(fn ($s) => is_array($s) && !empty(data_get($s, 'title')) && !empty(data_get($s, 'image')))
        ->values()
        ->all();
    $serviceOptionsPreferred = collect($subServicesRaw)
        ->map(fn ($s) => trim((string) data_get($s, 'title', '')))
        ->filter(fn ($title) => $title !== '')
        ->unique()
        ->values()
        ->all();

    $realsRaw = is_array($page->realisations ?? null) ? $page->realisations : [];
    $reals = collect($realsRaw)
        ->filter(fn ($c) => is_array($c) && !empty(data_get($c, 'before')) && !empty(data_get($c, 'after')))
        ->values()
        ->all();
@endphp

<section class="scroll-mt-24 bg-slate-50/70 py-12 sm:py-16">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        @php
            $bodyRaw = trim((string) ($page->body ?? ''));
            $bodyLooksHtml = $bodyRaw !== '' && preg_match('/<[a-z][\s\S]*>/i', $bodyRaw) === 1;
        @endphp

        {{-- Description du service : toujours avant les sous-services --}}
        @php
            $servicePartners = is_array($page->service_partners ?? null) ? $page->service_partners : [];
            $servicePartnersPhrase = trim((string) data_get($servicePartners, 'phrase', ''));
            $servicePartnersLogos = collect((array) data_get($servicePartners, 'logos', []))
                ->filter(fn ($v) => is_string($v) && trim($v) !== '')
                ->values()
                ->all();

            $stats = is_array($page->service_stats ?? null) ? $page->service_stats : [];
            $statsItems = collect((array) data_get($stats, 'items', []))
                ->filter(fn ($it) => is_array($it) && trim((string) data_get($it, 'label')) !== '' && trim((string) data_get($it, 'value')) !== '')
                ->values()
                ->all();

            if ($statsItems === []) {
                $statsItems = [
                    ['label' => 'Avis', 'value' => (string) data_get($h, 'sidebar_avis.score', '5.0/5'), 'text' => (string) data_get($h, 'sidebar_avis.text', '+100 avis')],
                    ['label' => 'Délai', 'value' => '48h', 'text' => 'Réponse en général'],
                    ['label' => 'Devis', 'value' => '0€', 'text' => 'Sans engagement'],
                ];
            }
        @endphp

        @if ($bodyRaw !== '')
            <div class="grid gap-6 lg:grid-cols-2">
                @if ($bodyRaw !== '')
                    <div id="role" class="scroll-mt-32 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
                        <div
                            class="service-page-body max-w-none text-base leading-relaxed text-slate-700 sm:text-lg
                                [&_p]:mb-3 [&_p:last-child]:mb-0
                                [&_ul]:my-3 [&_ul]:list-disc [&_ul]:pl-6
                                [&_ol]:my-3 [&_ol]:list-decimal [&_ol]:pl-6
                                [&_li]:my-1
                                [&_strong]:font-bold [&_b]:font-bold
                                [&_a]:font-semibold [&_a]:text-brand-blue [&_a]:underline
                                [&_h2]:mt-6 [&_h2]:text-2xl [&_h2]:font-extrabold [&_h2]:text-brand-dark
                                [&_h3]:mt-5 [&_h3]:text-xl [&_h3]:font-extrabold [&_h3]:text-brand-dark
                            "
                        >
                            @if ($bodyLooksHtml)
                                {!! $bodyRaw !!}
                            @else
                                {!! nl2br(e($bodyRaw)) !!}
                            @endif
                        </div>
                    </div>
                @endif

                <div class="grid gap-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                        <div class="flex flex-wrap items-end justify-between gap-3">
                            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $statsHeadingText !== '' ? $statsHeadingText : 'Chiffres clés' }}</p>
                            <a href="#avis" class="text-xs font-extrabold text-brand-blue hover:underline">{{ $statsLinkText !== '' ? $statsLinkText : 'Voir les avis' }}</a>
                        </div>
                        <div class="mt-5 grid gap-4 sm:grid-cols-3">
                            @foreach (array_slice($statsItems, 0, 3) as $it)
                                <div class="group rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-4 transition hover:shadow-sm">
                                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-slate-500">{{ data_get($it, 'label') }}</p>
                                    <p class="mt-2 text-2xl font-black text-brand-dark">{{ data_get($it, 'value') }}</p>
                                    @if (trim((string) data_get($it, 'text')) !== '')
                                        <p class="mt-1 text-sm font-semibold text-slate-600">{{ data_get($it, 'text') }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($servicePartnersLogos !== [])
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                            <div class="flex flex-wrap items-end justify-between gap-3">
                                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $partnersHeadingText !== '' ? $partnersHeadingText : 'Partenaires associés' }}</p>
                                <a href="#devis" class="text-xs font-extrabold text-brand-blue hover:underline">{{ $partnersLinkText !== '' ? $partnersLinkText : 'Nous contacter' }}</a>
                            </div>
                            @if ($servicePartnersPhrase !== '')
                                <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">{{ $servicePartnersPhrase }}</p>
                            @endif
                            <div class="mt-5 grid grid-cols-2 gap-2 sm:gap-3 sm:grid-cols-3">
                                @foreach (array_slice($servicePartnersLogos, 0, 6) as $src)
                                    <div class="flex min-w-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-sm sm:p-3">
                                        <img
                                            src="{{ HomeView::url($src) }}"
                                            alt="Logo partenaire"
                                            class="h-9 w-full max-w-full object-contain sm:h-10"
                                            width="200"
                                            height="80"
                                            loading="lazy"
                                            decoding="async"
                                        >
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if ($subServices !== [])
            @php
                $sectionHeading = trim((string) ($page->sub_services_section_title ?? ''));
                $accent = 'Sous';
                $rest = 'prestations';
                $subCount = count($subServices);
                $forcedDesktopCols = trim((string) data_get($ov, 'sub_services.columns_desktop', 'auto'));
                if (in_array($forcedDesktopCols, ['2', '3', '4'], true)) {
                    $subServicesGridClass = 'grid gap-6 sm:grid-cols-2 lg:grid-cols-'.$forcedDesktopCols;
                } else {
                    $subServicesGridClass = $subCount === 4
                        ? 'grid gap-6 sm:grid-cols-2 lg:grid-cols-4'
                        : ($subCount === 6
                            ? 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3'
                            : ($subCount > 4
                                ? 'grid gap-6 sm:grid-cols-2 lg:grid-cols-2'
                                : 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3'));
                }
                if ($sectionHeading !== '') {
                    $parts = preg_split('/\s+/', $sectionHeading, 2, PREG_SPLIT_NO_EMPTY);
                    $accent = $parts[0] ?? $sectionHeading;
                    $rest = isset($parts[1]) ? $parts[1] : '';
                }
            @endphp
            <div id="etapes" class="{{ $bodyRaw !== '' ? 'mt-10' : '' }} mb-6 scroll-mt-32">
                <h2 class="break-words text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                    <span class="text-brand-blue">{{ $accent }}</span>{{ $rest !== '' ? ' '.$rest : '' }}
                </h2>
                @if (!empty(trim((string) ($page->sub_services_section_intro ?? ''))))
                    <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg lg:max-w-none lg:whitespace-nowrap">
                        {{ $page->sub_services_section_intro }}
                    </p>
                @endif
            </div>

            <div class="{{ $subServicesGridClass }}">
                @foreach (array_slice($subServices, 0, 9) as $s)
                    @php
                        $title = (string) data_get($s, 'title', '');
                        $sub = trim((string) data_get($s, 'subtitle', ''));
                        $img = HomeView::url((string) data_get($s, 'image', ''));
                        $techDocs = collect([
                            trim((string) data_get($s, 'technical_doc', '')),
                            ...collect((array) data_get($s, 'technical_docs', []))
                                ->map(fn ($doc) => trim((string) $doc))
                                ->all(),
                        ])->filter(fn ($doc) => $doc !== '')
                            ->unique()
                            ->take(4)
                            ->values()
                            ->all();
                    @endphp
                    @if ($subServiceCardModel === 'split')
                        <article class="service-card overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-md">
                            <img
                                src="{{ $img }}"
                                alt="{{ $title }}"
                                class="{{ $subServiceSplitImageClass }}"
                                loading="lazy"
                                decoding="async"
                            >
                            <div class="p-5 sm:p-6">
                                <h3 class="break-words text-2xl font-black leading-snug text-brand-dark sm:text-3xl">
                                    {{ $title }}
                                </h3>
                                @if ($sub !== '')
                                    <p class="mt-2 break-words text-sm leading-relaxed text-slate-600 sm:text-base">
                                        {{ $sub }}
                                    </p>
                                @endif
                                <div class="mt-5 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="#devis"
                                        class="inline-flex w-fit items-center gap-2 rounded-xl bg-brand-blue px-4 py-2.5 text-sm font-extrabold text-white transition hover:bg-sky-500"
                                    >
                                        {{ $subServiceCtaText !== '' ? $subServiceCtaText : 'C’EST CE QU’IL ME FAUT' }} <span aria-hidden="true">⟶</span>
                                    </a>
                                    @if ($techDocs !== [])
                                        @foreach ($techDocs as $docIndex => $docPath)
                                            <a
                                                href="{{ HomeView::url($docPath) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex w-fit items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-extrabold text-brand-dark transition hover:bg-slate-50"
                                            >
                                                {{ $subServiceDocText !== '' ? $subServiceDocText : 'DOC TECHNIQUE' }}{{ count($techDocs) > 1 ? ' '.($docIndex + 1) : '' }} <span aria-hidden="true">↗</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </article>
                    @else
                        <article class="{{ $subServiceCardClass }}">
                            <div class="absolute inset-0">
                                <img
                                    src="{{ $img }}"
                                    alt="{{ $title }}"
                                    class="h-full w-full object-cover transition duration-300"
                                    loading="lazy"
                                    decoding="async"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/95 via-brand-dark/65 to-transparent"></div>
                            </div>
                            <div class="absolute inset-x-0 bottom-0 z-10 p-6">
                                <h3 class="break-words text-2xl font-black leading-snug text-white sm:text-3xl">
                                    {{ $title }}
                                </h3>
                                @if ($sub !== '')
                                    <p class="mt-2 break-words text-sm leading-relaxed text-white/90 sm:text-base">
                                        {{ $sub }}
                                    </p>
                                @endif
                                <div class="mt-5 flex flex-wrap items-center gap-2.5">
                                    <a
                                        href="#devis"
                                        class="inline-flex w-fit items-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-extrabold text-white ring-1 ring-white/20 backdrop-blur transition hover:bg-white/15 hover:ring-white/35"
                                    >
                                        {{ $subServiceCtaText !== '' ? $subServiceCtaText : 'C’EST CE QU’IL ME FAUT' }} <span aria-hidden="true">⟶</span>
                                    </a>
                                    @if ($techDocs !== [])
                                        @foreach ($techDocs as $docIndex => $docPath)
                                            <a
                                                href="{{ HomeView::url($docPath) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex w-fit items-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-extrabold text-white ring-1 ring-white/20 backdrop-blur transition hover:bg-white/15 hover:ring-white/35"
                                            >
                                                {{ $subServiceDocText !== '' ? $subServiceDocText : 'DOC TECHNIQUE' }}{{ count($techDocs) > 1 ? ' '.($docIndex + 1) : '' }} <span aria-hidden="true">↗</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Processus de prise en charge (après les sous-services) --}}
        @php
            $proc = data_get($h, 'processus', []);
            $procSteps = collect((array) data_get($processOverrides, 'steps', []))
                ->map(function ($s, $idx) {
                    return [
                        'num' => trim((string) data_get($s, 'num', (string) ($idx + 1))),
                        'title' => trim((string) data_get($s, 'title', '')),
                        'text' => trim((string) data_get($s, 'text', '')),
                    ];
                })
                ->filter(fn ($s) => $s['title'] !== '' || $s['text'] !== '')
                ->values()
                ->all();
            if ($procSteps === []) {
                $procSteps = (array) data_get($proc, 'steps', []);
            }
            $processKicker = trim((string) data_get($processOverrides, 'kicker', 'Processus'));
            $processTitleAccent = trim((string) data_get($processOverrides, 'title_accent', data_get($proc, 'title_accent', 'Prise en charge')));
            $processTitleRest = trim((string) data_get($processOverrides, 'title_rest', data_get($proc, 'title_rest', 'en 4 étapes')));
            $processIntro = trim((string) data_get($processOverrides, 'intro', data_get($proc, 'intro', '')));
            $processCtaText = trim((string) data_get($processOverrides, 'cta_text', 'Demander un devis'));
        @endphp
        @if (is_array($procSteps) && $procSteps !== [])
            <div class="{{ $subServices !== [] ? 'mt-12' : '' }} rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $processKicker !== '' ? $processKicker : 'Processus' }}</p>
                        <h2 class="mt-2 break-words text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                            {{ $processTitleAccent !== '' ? $processTitleAccent : 'Prise en charge' }}
                            <span class="text-brand-blue">{{ ' '.($processTitleRest !== '' ? $processTitleRest : 'en 4 étapes') }}</span>
                        </h2>
                        @if ($processIntro !== '')
                            <p class="mt-3 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">{{ $processIntro }}</p>
                        @endif
                    </div>
                    <a href="#devis" class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                        {{ $processCtaText !== '' ? $processCtaText : 'Demander un devis' }}
                    </a>
                </div>

                <ol class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($procSteps as $step)
                        <li class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/60 p-5 transition hover:bg-white hover:shadow-sm">
                            <div class="flex items-start gap-3">
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-dark text-sm font-black text-brand-yellow shadow-sm">
                                    {{ data_get($step, 'num', $loop->iteration) }}
                                </span>
                                <div class="min-w-0">
                                    <h3 class="break-words text-base font-extrabold text-brand-dark">{{ data_get($step, 'title') }}</h3>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ data_get($step, 'text') }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
</section>

@if ($reals !== [])
    <section id="realisations" class="scroll-mt-24 bg-white py-14 sm:py-20">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            @php
                $realisationsTitleAccent = trim((string) data_get($realisationsOverrides, 'title_accent', 'Réalisations'));
                $realisationsTitleRest = trim((string) data_get($realisationsOverrides, 'title_rest', 'avant / après'));
                $realisationsIntro = trim((string) data_get($realisationsOverrides, 'intro', 'Faites glisser le curseur pour comparer.'));
                $realisationsBeforeLabel = trim((string) data_get($realisationsOverrides, 'before_label', 'Avant'));
                $realisationsAfterLabel = trim((string) data_get($realisationsOverrides, 'after_label', 'Après'));
            @endphp
            <div class="mb-6">
                <h2 class="break-words text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                    <span class="text-brand-blue">{{ $realisationsTitleAccent !== '' ? $realisationsTitleAccent : 'Réalisations' }}</span> {{ $realisationsTitleRest !== '' ? $realisationsTitleRest : 'avant / après' }}
                </h2>
                <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">{{ $realisationsIntro }}</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($reals as $idx => $c)
                    @php
                        $cardLabel = (string) data_get($c, 'label', 'Chantier '.($idx + 1));
                        $before = HomeView::url((string) data_get($c, 'before'));
                        $after = HomeView::url((string) data_get($c, 'after'));
                    @endphp
                    <article class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 px-4 py-3">
                            <h3 class="break-words text-sm font-extrabold text-brand-dark sm:text-base">{{ $cardLabel }}</h3>
                        </div>
                        <div class="ba-compare relative w-full overflow-hidden bg-slate-900/5 aspect-[4/3]">
                            <div
                                class="ba-before absolute inset-0 z-0 bg-cover bg-center bg-slate-100"
                                style="background-image:url('{{ $before }}')"
                                role="img"
                                aria-label="Avant — {{ $cardLabel }}"
                            ></div>
                            <div
                                class="ba-after absolute inset-0 z-[1] bg-cover bg-center"
                                style="background-image:url('{{ $after }}'); clip-path: inset(0 0 0 50%);"
                                role="img"
                                aria-label="Après — {{ $cardLabel }}"
                            ></div>
                            <div class="pointer-events-none absolute left-3 top-3 z-10 rounded-lg bg-brand-dark/70 px-2.5 py-1 text-xs font-extrabold uppercase tracking-wide text-white">
                                {{ $realisationsBeforeLabel !== '' ? $realisationsBeforeLabel : 'Avant' }}
                            </div>
                            <div class="pointer-events-none absolute right-3 top-3 z-10 rounded-lg bg-brand-blue/85 px-2.5 py-1 text-xs font-extrabold uppercase tracking-wide text-white">
                                {{ $realisationsAfterLabel !== '' ? $realisationsAfterLabel : 'Après' }}
                            </div>
                            <input
                                type="range"
                                min="0"
                                max="100"
                                value="50"
                                class="ba-range absolute bottom-3 left-3 right-3 z-20 h-3 w-auto cursor-default accent-brand-blue sm:cursor-ew-resize"
                                aria-label="Comparer avant et après — {{ $cardLabel }}"
                            >
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section id="avis" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto w-[95%] scroll-mt-32 px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="min-w-0">
                @include('services.avis_only', ['home' => $h, 'avisOverrides' => $avisOverrides])
            </div>

            <div class="min-w-0">
                @php
                    $ctaCardBgPath = trim((string) (data_get($page, 'cta_card_background') ?? ''));
                    $ctaCardBg = $ctaCardBgPath !== '' ? HomeView::url($ctaCardBgPath) : HomeView::url('slide/toiture.png');
                    $ctaCardKicker = trim((string) data_get($ctaCardOverrides, 'kicker', 'Un projet de rénovation ?'));
                    $ctaCardTitle = trim((string) data_get($ctaCardOverrides, 'title', 'Démarrez dès maintenant'));
                    $ctaCardText = trim((string) data_get($ctaCardOverrides, 'text', 'Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.'));
                    $ctaCardPrimary = trim((string) data_get($ctaCardOverrides, 'simulateur_text', 'Ouvrir le simulateur de devis'));
                    $ctaCardSecondary = trim((string) data_get($ctaCardOverrides, 'contact_text', 'Accéder au formulaire de contact'));
                @endphp
                {{-- Fonds en absolute ; contenu en flux pour hauteur auto (mobile : plus de texte rogné) --}}
                <div class="relative overflow-hidden rounded-2xl border border-white/20 shadow-soft ring-1 ring-black/5 lg:flex lg:h-full lg:min-h-[20rem] lg:flex-col">
                    <div
                        class="absolute inset-0 bg-cover bg-center"
                        style="background-image: url('{{ $ctaCardBg }}');"
                        aria-hidden="true"
                    ></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-dark/90 via-brand-dark/75 to-brand-dark/60" aria-hidden="true"></div>

                    <div class="relative z-10 flex w-full flex-col items-center justify-center px-4 py-8 text-center sm:px-6 sm:py-10 lg:flex-1 lg:px-8 lg:py-10">
                        <div class="w-full max-w-md">
                            <p class="text-[0.7rem] font-extrabold uppercase leading-snug tracking-[0.12em] text-brand-yellow sm:text-xs sm:tracking-[0.2em]">
                                {{ $ctaCardKicker !== '' ? $ctaCardKicker : 'Un projet de rénovation ?' }}
                            </p>
                            <h2 class="mt-2 break-words text-2xl font-extrabold leading-snug text-white sm:text-3xl sm:leading-tight lg:text-4xl">
                                {{ $ctaCardTitle !== '' ? $ctaCardTitle : 'Démarrez dès maintenant' }}
                            </h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-100/95 sm:text-base">
                                {{ $ctaCardText !== '' ? $ctaCardText : 'Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.' }}
                            </p>
                            <div class="mt-6 grid w-full gap-3">
                                <a
                                    href="{{ route('simulateur.start', ['source' => request()->getPathInfo()]) }}"
                                    class="inline-flex w-full min-w-0 items-center justify-center rounded-xl bg-brand-blue px-4 py-3 text-center text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 sm:px-5"
                                >
                                    {{ $ctaCardPrimary !== '' ? $ctaCardPrimary : 'Ouvrir le simulateur de devis' }}
                                </a>
                                <a
                                    href="#formulaire-contact"
                                    class="inline-flex w-full min-w-0 items-center justify-center rounded-xl border-2 border-white/45 bg-white/10 px-4 py-3 text-center text-sm font-extrabold text-white shadow-sm backdrop-blur-sm transition hover:bg-white/20 sm:px-5"
                                >
                                    {{ $ctaCardSecondary !== '' ? $ctaCardSecondary : 'Accéder au formulaire de contact' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Section formulaire identique à la page d'accueil (source unique) --}}
@include('home.devis', [
    'home' => $h,
    'serviceOptionsPreferred' => $serviceOptionsPreferred ?? [],
])

{{-- Partenaires & certification (juste avant le footer) --}}
@if (is_array(data_get($h, 'partners.logos', [])) && data_get($h, 'partners.logos', []) !== [])
    @include('home.partners', ['home' => $h])
@endif

@include('home.footer', ['home' => $h])

@include('home.scripts', ['home' => $h])
</body>
</html>

