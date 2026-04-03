@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $ap = data_get($h, 'about_page', []);
    if (! is_array($ap)) {
        $ap = [];
    }
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = trim((string) data_get($ap, 'meta_title', ''));
    if ($metaTitle === '') {
        $metaTitle = 'À propos | '.$siteName;
    }
    $metaDescription = trim((string) data_get($ap, 'meta_description', ''));
    if ($metaDescription === '') {
        $metaDescription = 'Normes et Rénovation : rénovation de maison, humidité, efficacité énergétique et durabilité. Expertise technique et accompagnement sur mesure.';
    }
    $metaKeywords = trim((string) data_get($ap, 'meta_keywords', ''));
    $ogImage = trim((string) data_get($ap, 'og_image', data_get($h, 'meta.og_image', 'logo.png')));
    $canonicalUrl = route('about.page', [], false);
    $heroBg = HomeView::url((string) data_get($ap, 'hero_bg', 'slide/toiture.png'));
    $contactHref = route('contact.page', [], false).'#devis';
    $servicesHref = route('services.index', [], false);

    $heroKicker = trim((string) data_get($ap, 'hero_kicker', 'Notre entreprise'));
    $heroTitle = trim((string) data_get($ap, 'hero_title', 'Construisez avec nous, bâtissez l\'avenir'));
    $heroIntro = trim((string) data_get($ap, 'hero_intro', 'Normes et Rénovation est une entreprise spécialisée dans la rénovation de maison, offrant des solutions complètes pour traiter l\'humidité, améliorer l\'efficacité énergétique et assurer la durabilité de votre habitation.'));

    $companyStoryKicker = trim((string) data_get($ap, 'company_story_kicker', 'Qui sommes-nous'));
    $companyStoryHeading = trim((string) data_get($ap, 'company_story_heading', 'Normes et Rénovation, votre partenaire rénovation'));
    $companyStoryBody = trim((string) data_get($ap, 'company_story_body', ''));
    $companyStoryImageRaw = trim((string) data_get($ap, 'company_story_image', ''));
    $companyStoryImageAlt = trim((string) data_get($ap, 'company_story_image_alt', ''));
    $companyStoryImage = $companyStoryImageRaw !== '' ? HomeView::url($companyStoryImageRaw) : '';
    $showCompanyStory = $companyStoryHeading !== '' || $companyStoryBody !== '' || $companyStoryImage !== '';

    $pillarsKicker = trim((string) data_get($ap, 'pillars_kicker', 'Expertise et durabilité'));
    $pillarsTitle = trim((string) data_get($ap, 'pillars_title', 'Un partenaire fiable|à chaque étape'));
    $pillars = data_get($ap, 'pillars', []);
    if (! is_array($pillars) || $pillars === []) {
        $pillars = [
            ['title' => 'Expertise technique', 'text' => 'Diagnostics et interventions conformes aux normes en vigueur.'],
            ['title' => 'Solutions personnalisées', 'text' => 'Des réponses adaptées à votre logement et à votre budget.'],
            ['title' => 'Innovation et technologies modernes', 'text' => 'Matériaux et équipements performants pour durer.'],
            ['title' => 'Service client exceptionnel', 'text' => 'Écoute, transparence et suivi tout au long du chantier.'],
        ];
    }

    $expertiseTitle = trim((string) data_get($ap, 'expertise_title', 'Expertise complète en rénovation'));
    $expertiseText = trim((string) data_get($ap, 'expertise_text', 'Normes et Rénovation se spécialise dans une gamme étendue de services de rénovation, incluant la gestion de l\'humidité, l\'amélioration de l\'efficacité énergétique et la sécurité des installations électriques. Nous offrons des solutions sur mesure pour répondre aux besoins spécifiques de chaque projet.'));
    $expertiseImage = HomeView::url((string) data_get($ap, 'expertise_image', '/slide/toiture.png'));

    $ecoTitle = trim((string) data_get($ap, 'eco_title', 'Solutions écologiques|et durables'));
    $ecoText = trim((string) data_get($ap, 'eco_text', 'Nous privilégions des solutions respectueuses de l\'environnement, telles que les traitements hydrofuges pour façades et les systèmes de ventilation innovants. Nous nous engageons à utiliser des technologies durables qui améliorent le confort tout en réduisant l\'empreinte écologique.'));
    $ecoImage = HomeView::url((string) data_get($ap, 'eco_image', '/nous/equipe.jpeg'));

    $mediationText = trim((string) data_get($ap, 'mediation_text', 'Conformément à la réglementation, notre établissement a désigné le Centre de la Médiation de la Consommation de Conciliateurs de Justice (CM2C) comme médiateur de la consommation. En cas de réclamation non résolue, vous pouvez le contacter directement à l\'adresse https://www.cm2c.net.'));

    $f = data_get($h, 'footer', []);
    if (! is_array($f)) {
        $f = [];
    }
    $footerPhone = trim((string) data_get($f, 'phone', ''));
    $footerPhoneHref = trim((string) data_get($f, 'phone_href', ''));
    $footerEmail = trim((string) data_get($f, 'email', ''));
    $footerCompany = trim((string) data_get($f, 'company', ''));
    $footerAddressLines = data_get($f, 'address_lines', []);
    if (! is_array($footerAddressLines)) {
        $footerAddressLines = [];
    }

    $avisKicker = trim((string) data_get($ap, 'avis_section_kicker', 'VOS AVIS'));
    $avisTitle = trim((string) data_get($ap, 'avis_section_title', 'Ce que disent|nos clients'));
    $googleReviewsLabel = trim((string) data_get($ap, 'google_reviews_label', ''));
    $googleUrl = trim((string) data_get($ap, 'google_url', ''));
    if ($googleUrl === '') {
        $googleUrl = trim((string) data_get($h, 'avis.google_url', data_get($h, 'floating.google_url', '')));
    }

    $testimonials = data_get($ap, 'testimonials');
    if (! is_array($testimonials) || $testimonials === []) {
        $testimonials = require base_path('app/Support/about_testimonials_defaults.php');
    }

    $satisfactionTitle = trim((string) data_get($ap, 'satisfaction_title', 'Votre satisfaction|est notre priorité'));
    $satisfactionImgVal = data_get($ap, 'satisfaction_image', '');
    if (! is_string($satisfactionImgVal)) {
        $satisfactionImgVal = '';
    }
    $satisfactionImageRaw = trim($satisfactionImgVal);
    $satisfactionImageAltVal = data_get($ap, 'satisfaction_image_alt', '');
    $satisfactionImageAlt = is_string($satisfactionImageAltVal) ? trim($satisfactionImageAltVal) : '';
    $satisfactionImage = $satisfactionImageRaw !== '' ? HomeView::url($satisfactionImageRaw) : '';
    $satisfactionImageForCard = $satisfactionImage !== '' ? $satisfactionImage : $expertiseImage;

    $aboutTripleFeatures = [
        [
            'heading_id' => 'expertise-heading',
            'kicker' => 'Savoir-faire',
            'kicker_class' => 'inline-block rounded-full bg-brand-blue/10 px-3.5 py-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-blue',
            'title' => $expertiseTitle,
            'body' => $expertiseText,
            'image' => $expertiseImage,
            'image_alt' => 'Rénovation de toiture — expertise Normes et Rénovation',
            'ctas' => [
                [
                    'href' => $servicesHref,
                    'label' => 'Découvrir nos services',
                    'class' => 'inline-flex items-center gap-2 rounded-xl bg-brand-blue px-4 py-2.5 text-sm font-extrabold text-white shadow-md transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2',
                    'external' => false,
                ],
            ],
        ],
        [
            'heading_id' => 'eco-heading',
            'kicker' => 'Environnement',
            'kicker_class' => 'inline-block rounded-full bg-emerald-50 px-3.5 py-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-emerald-700',
            'title' => $ecoTitle,
            'body' => $ecoText,
            'image' => $ecoImage,
            'image_alt' => 'Équipe Normes et Rénovation — solutions durables',
            'ctas' => [
                [
                    'href' => $contactHref,
                    'label' => 'Demander un devis',
                    'class' => 'inline-flex items-center gap-2 rounded-xl bg-brand-dark px-4 py-2.5 text-sm font-extrabold text-white shadow-md transition hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2',
                    'external' => false,
                ],
            ],
        ],
        [
            'heading_id' => 'satisfaction-heading',
            'kicker' => 'Satisfaction',
            'kicker_class' => 'inline-block rounded-full bg-brand-blue/10 px-3.5 py-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-blue',
            'title' => $satisfactionTitle,
            'body' => $mediationText,
            'image' => $satisfactionImageForCard,
            'image_alt' => $satisfactionImageAlt !== '' ? $satisfactionImageAlt : 'Satisfaction client et médiation Normes et Rénovation',
            'ctas' => [
                [
                    'href' => $contactHref,
                    'label' => 'Demander un devis',
                    'class' => 'inline-flex items-center gap-2 rounded-xl bg-brand-dark px-4 py-2.5 text-sm font-extrabold text-white shadow-md transition hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2',
                    'external' => false,
                ],
                [
                    'href' => 'https://www.cm2c.net',
                    'label' => 'Site du médiateur CM2C',
                    'class' => 'inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-brand-blue/30 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue focus-visible:ring-offset-2',
                    'external' => true,
                ],
            ],
        ],
    ];

    $legal = data_get($ap, 'legal', []);
    if (! is_array($legal)) {
        $legal = [];
    }
    $showLegal = (bool) data_get($legal, 'show', true);
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

<section id="top" class="relative min-h-[440px] overflow-hidden sm:min-h-[500px]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $heroBg }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/95 via-brand-dark/50 to-brand-dark/20" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-brand-dark/40 to-transparent" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto flex min-h-[440px] w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:min-h-[500px] sm:px-6 sm:py-10 lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="relative rounded-3xl border border-white/20 bg-brand-dark/45 p-6 shadow-[0_28px_60px_-18px_rgba(0,0,0,0.55)] backdrop-blur-xl ring-1 ring-white/10 sm:p-8">
                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-brand-yellow/15 blur-2xl" aria-hidden="true"></div>
                @if ($heroKicker !== '')
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-yellow backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-yellow shadow-[0_0_8px_rgba(250,204,21,0.9)]" aria-hidden="true"></span>
                        {{ mb_strtoupper($heroKicker, 'UTF-8') }}
                    </p>
                @endif
                @include('about._heading-two-tone', [
                    'title' => $heroTitle,
                    'as' => 'h1',
                    'class' => 'mb-4 text-2xl font-black leading-[1.08] tracking-tight text-white drop-shadow-md sm:text-3xl lg:text-4xl',
                    'variant' => 'hero',
                ])
                <p class="mb-2 max-w-2xl text-base leading-relaxed text-white/88 sm:text-lg">
                    {{ $heroIntro }}
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ $servicesHref }}" class="inline-flex rounded-2xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-[0_12px_28px_-6px_rgba(14,165,233,0.5)] transition hover:-translate-y-0.5 hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Nos solutions
                    </a>
                    <a href="{{ $contactHref }}" class="inline-flex rounded-2xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-lg transition hover:-translate-y-0.5 hover:brightness-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Devis gratuit
                    </a>
                    <a href="#devis" class="inline-flex rounded-2xl border border-white/35 bg-white/10 px-5 py-3 text-sm font-extrabold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:bg-white/18 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">

    {{-- ═══ PRÉSENTATION ENTREPRISE (après hero) ═══ --}}
    @if ($showCompanyStory)
        <section
            id="qui-sommes-nous"
            class="scroll-mt-24 border-b border-slate-200/90 bg-white py-10 sm:py-14"
            @if ($companyStoryHeading !== '') aria-labelledby="company-story-heading" @else aria-label="{{ $companyStoryKicker !== '' ? $companyStoryKicker : 'Présentation de l’entreprise' }}" @endif
        >
            <div @class([
                'mx-auto w-[95%] px-4 sm:px-6 lg:px-8',
                'grid items-center gap-8 lg:grid-cols-2 lg:gap-12' => $companyStoryImage !== '',
                'max-w-3xl' => $companyStoryImage === '',
            ])>
                <div @class(['order-2 lg:order-1', 'mx-auto text-center lg:text-left' => $companyStoryImage === ''])>
                    @if ($companyStoryKicker !== '')
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ mb_strtoupper($companyStoryKicker, 'UTF-8') }}</p>
                    @endif
                    @if ($companyStoryHeading !== '')
                        @include('about._heading-two-tone', [
                            'title' => $companyStoryHeading,
                            'as' => 'h2',
                            'id' => 'company-story-heading',
                            'class' => 'mt-3 text-2xl font-black leading-tight tracking-tight text-brand-dark sm:text-3xl',
                            'variant' => 'light',
                        ])
                    @endif
                    @if ($companyStoryBody !== '')
                        <div class="mt-5 max-w-none space-y-3 text-left text-base leading-relaxed text-slate-600 sm:text-base">
                            {!! nl2br(e($companyStoryBody)) !!}
                        </div>
                    @endif
                    <div @class(['mt-8 flex flex-wrap gap-3', 'justify-center lg:justify-start' => $companyStoryImage === ''])>
                        <a href="{{ $servicesHref }}" class="inline-flex rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-extrabold text-white shadow-md transition hover:-translate-y-0.5 hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2">
                            Découvrir nos prestations
                        </a>
                        <a href="{{ $contactHref }}" class="inline-flex rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-brand-blue/30 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue focus-visible:ring-offset-2">
                            Nous contacter
                        </a>
                    </div>
                </div>
                @if ($companyStoryImage !== '')
                    <div class="order-1 lg:order-2">
                        <figure class="overflow-hidden rounded-2xl shadow-xl shadow-slate-900/10 ring-1 ring-slate-200/80">
                            <img
                                src="{{ $companyStoryImage }}"
                                alt="{{ $companyStoryImageAlt !== '' ? $companyStoryImageAlt : $companyStoryHeading }}"
                                class="aspect-[4/3] w-full object-cover sm:aspect-[5/4] lg:min-h-[240px]"
                                width="960"
                                height="768"
                                loading="eager"
                                fetchpriority="high"
                                decoding="async"
                            >
                        </figure>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- Reels vidéo (Vimeo) : réactiver en incluant about._reels + vars reels* dans le @php ci-dessus --}}

    {{-- ═══ PILIERS ═══ --}}
    <section class="bg-white py-12 sm:py-16" aria-labelledby="pillars-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                @if ($pillarsKicker !== '')
                    <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-brand-blue">{{ mb_strtoupper($pillarsKicker, 'UTF-8') }}</p>
                @endif
                @include('about._heading-two-tone', [
                    'title' => $pillarsTitle,
                    'as' => 'h2',
                    'id' => 'pillars-heading',
                    'class' => 'mx-auto mt-3 max-w-2xl text-2xl font-black leading-tight tracking-tight text-brand-dark sm:text-3xl',
                    'variant' => 'light',
                ])
                <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-brand-blue"></div>
            </div>

            @php
                $pillarIcons = [
                    '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
                    '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>',
                    '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                    '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                ];
            @endphp

            <div class="mt-9 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($pillars as $idx => $p)
                    @if (is_array($p))
                        <div class="group relative rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-blue/5">
                            <div class="absolute inset-x-0 top-0 h-0.5 rounded-t-2xl bg-gradient-to-r from-brand-blue to-sky-400 opacity-0 transition-opacity group-hover:opacity-100" aria-hidden="true"></div>
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-brand-blue/10 text-brand-blue transition-colors group-hover:bg-brand-blue group-hover:text-white">
                                {!! $pillarIcons[$idx] ?? $pillarIcons[0] !!}
                            </div>
                            <h3 class="text-lg font-extrabold text-brand-dark">{{ data_get($p, 'title') }}</h3>
                            @if (trim((string) data_get($p, 'text')) !== '')
                                <p class="mt-2.5 text-sm leading-relaxed text-slate-500">{{ data_get($p, 'text') }}</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ SAVOIR-FAIRE + ENVIRONNEMENT + SATISFACTION (3 col., type sous-services « split » : image haut, texte bas) ═══ --}}
    <section class="bg-slate-50 py-12 sm:py-16" aria-label="Savoir-faire, environnement et satisfaction client">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($aboutTripleFeatures as $feat)
                    <article
                        class="feature-split-card flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-md"
                        aria-labelledby="{{ $feat['heading_id'] }}"
                    >
                        <div class="relative w-full min-h-[14rem] shrink-0 overflow-hidden bg-slate-100 sm:min-h-[16rem]">
                            <img
                                src="{{ $feat['image'] }}"
                                alt="{{ $feat['image_alt'] }}"
                                class="absolute inset-0 h-full w-full object-cover object-center"
                                width="800"
                                height="600"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <p class="{{ $feat['kicker_class'] }}">{{ $feat['kicker'] }}</p>
                            @include('about._heading-two-tone', [
                                'title' => $feat['title'],
                                'as' => 'h3',
                                'id' => $feat['heading_id'],
                                'class' => 'mt-3 text-xl font-black leading-snug tracking-tight text-brand-dark sm:text-2xl',
                                'variant' => 'light',
                            ])
                            <div class="mt-3 flex-1 text-sm leading-relaxed text-slate-600 sm:text-[0.9375rem]">
                                {!! nl2br(e($feat['body'])) !!}
                            </div>
                            <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                                @foreach ($feat['ctas'] as $cta)
                                    <a
                                        href="{{ $cta['href'] }}"
                                        class="{{ $cta['class'] }}"
                                        @if (! empty($cta['external'])) target="_blank" rel="noopener noreferrer" @endif
                                    >
                                        {{ $cta['label'] }} <span aria-hidden="true">&rarr;</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ AVIS (juste avant mentions légales) ═══ --}}
    @include('about._reviews', [
        'avisKicker' => $avisKicker,
        'avisTitle' => $avisTitle,
        'googleReviewsLabel' => $googleReviewsLabel,
        'googleUrl' => $googleUrl,
        'testimonials' => $testimonials,
    ])

    {{-- ═══ MENTIONS LÉGALES ═══ --}}
    @if ($showLegal)
        <section class="bg-slate-50 py-12 sm:py-16" aria-labelledby="legal-heading">
            <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="h-7 w-1 rounded-full bg-brand-blue"></div>
                    @include('about._heading-two-tone', [
                        'title' => trim((string) data_get($legal, 'title', 'Mentions légales')),
                        'as' => 'h2',
                        'id' => 'legal-heading',
                        'class' => 'text-xl font-black tracking-tight text-brand-dark sm:text-2xl',
                        'variant' => 'light',
                    ])
                </div>

                <div class="mt-7 grid gap-5 sm:grid-cols-2">
                    {{-- Siège --}}
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-7">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-blue/10 text-brand-blue">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="text-xs font-extrabold uppercase tracking-[0.15em] text-slate-400">
                                {{ trim((string) data_get($legal, 'siege_title', 'Siège social')) }}
                            </h3>
                        </div>
                        @if ($footerCompany !== '')
                            <p class="mt-5 text-base font-bold text-brand-dark">{{ $footerCompany }}</p>
                        @endif
                        @if ($footerAddressLines !== [])
                            <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                @foreach ($footerAddressLines as $line)
                                    {{ $line }}@if (! $loop->last)<br>@endif
                                @endforeach
                            </p>
                        @endif
                    </div>

                    {{-- Contact --}}
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-7">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-blue/10 text-brand-blue">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-xs font-extrabold uppercase tracking-[0.15em] text-slate-400">
                                {{ trim((string) data_get($legal, 'contact_title', 'Contact')) }}
                            </h3>
                        </div>
                        @if ($footerPhone !== '')
                            <p class="mt-5 text-xs font-semibold uppercase tracking-wide text-slate-400">Téléphone</p>
                            <a href="{{ $footerPhoneHref !== '' ? 'tel:'.preg_replace('#^tel:#i', '', $footerPhoneHref) : '#' }}" class="text-lg font-extrabold text-brand-blue transition hover:text-sky-600">{{ $footerPhone }}</a>
                        @endif
                        @if ($footerEmail !== '')
                            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-slate-400">E-mail</p>
                            <a href="mailto:{{ $footerEmail }}" class="break-all text-sm font-bold text-brand-dark transition hover:text-brand-blue">{{ $footerEmail }}</a>
                        @endif
                    </div>
                </div>

                {{-- Représentant + identifiants --}}
                <div class="mt-5 rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-blue/10 text-brand-blue">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-xs font-extrabold uppercase tracking-[0.15em] text-slate-400">
                            {{ trim((string) data_get($legal, 'representative_title', 'Représentant légal')) }}
                        </h3>
                    </div>
                    @if (trim((string) data_get($legal, 'representative_text')) !== '')
                        <p class="mt-4 text-sm text-slate-600">{{ data_get($legal, 'representative_text') }}</p>
                    @endif
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @if (trim((string) data_get($legal, 'rcs_label')) !== '' && trim((string) data_get($legal, 'rcs_number')) !== '')
                            <div class="rounded-xl bg-slate-50 px-4 py-3">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ data_get($legal, 'rcs_label') }}</p>
                                <p class="mt-1 font-mono text-sm text-brand-dark">{{ data_get($legal, 'rcs_number') }}</p>
                            </div>
                        @endif
                        @if (trim((string) data_get($legal, 'siren_label')) !== '' && trim((string) data_get($legal, 'siren')) !== '')
                            <div class="rounded-xl bg-slate-50 px-4 py-3">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ data_get($legal, 'siren_label') }}</p>
                                <p class="mt-1 font-mono text-sm text-brand-dark">{{ data_get($legal, 'siren') }}</p>
                            </div>
                        @endif
                        @if (trim((string) data_get($legal, 'siret_label')) !== '' && trim((string) data_get($legal, 'siret')) !== '')
                            <div class="rounded-xl bg-slate-50 px-4 py-3">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ data_get($legal, 'siret_label') }}</p>
                                <p class="mt-1 font-mono text-sm text-brand-dark">{{ data_get($legal, 'siret') }}</p>
                            </div>
                        @endif
                        @if (trim((string) data_get($legal, 'tva_label')) !== '' && trim((string) data_get($legal, 'tva')) !== '')
                            <div class="rounded-xl bg-slate-50 px-4 py-3">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ data_get($legal, 'tva_label') }}</p>
                                <p class="mt-1 font-mono text-sm text-brand-dark">{{ data_get($legal, 'tva') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ Bloc contact / devis (identique à l’accueil : formulaire complet) ═══ --}}
</main>

@include('home.devis', ['home' => $h])

@php
    $aboutLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $metaTitle,
        'description' => $metaDescription,
        'url' => url($canonicalUrl),
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
                    'name' => 'À propos',
                    'item' => url($canonicalUrl),
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($aboutLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
