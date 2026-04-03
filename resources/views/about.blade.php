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
    $heroTitle = trim((string) data_get($ap, 'hero_title', 'Construisez avec nous, bâtissez l’avenir'));
    $heroIntro = trim((string) data_get($ap, 'hero_intro', 'Normes et Rénovation est une entreprise spécialisée dans la rénovation de maison, offrant des solutions complètes pour traiter l’humidité, améliorer l’efficacité énergétique et assurer la durabilité de votre habitation.'));

    $pillarsKicker = trim((string) data_get($ap, 'pillars_kicker', 'Expertise et durabilité'));
    $pillarsTitle = trim((string) data_get($ap, 'pillars_title', 'Un partenaire fiable à chaque étape'));
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
    $expertiseText = trim((string) data_get($ap, 'expertise_text', 'Normes et Rénovation se spécialise dans une gamme étendue de services de rénovation, incluant la gestion de l’humidité, l’amélioration de l’efficacité énergétique et la sécurité des installations électriques. Nous offrons des solutions sur mesure pour répondre aux besoins spécifiques de chaque projet.'));
    $expertiseImage = HomeView::url((string) data_get($ap, 'expertise_image', '/slide/toiture.png'));

    $ecoTitle = trim((string) data_get($ap, 'eco_title', 'Solutions écologiques et durables'));
    $ecoText = trim((string) data_get($ap, 'eco_text', 'Nous privilégions des solutions respectueuses de l’environnement, telles que les traitements hydrofuges pour façades et les systèmes de ventilation innovants. Nous nous engageons à utiliser des technologies durables qui améliorent le confort tout en réduisant l’empreinte écologique.'));
    $ecoImage = HomeView::url((string) data_get($ap, 'eco_image', '/nous/equipe.jpeg'));

    $mediationText = trim((string) data_get($ap, 'mediation_text', 'Conformément à la réglementation, notre établissement a désigné le Centre de la Médiation de la Consommation de Conciliateurs de Justice (CM2C) comme médiateur de la consommation. En cas de réclamation non résolue, vous pouvez le contacter directement à l’adresse https://www.cm2c.net.'));

    $taglineBottom = trim((string) data_get($ap, 'tagline_bottom', 'Spécialiste en solutions de rénovation électrique, thermique et hygrométrique pour la maison.'));
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
                @if ($heroKicker !== '')
                    <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">{{ strtoupper($heroKicker) }}</p>
                @endif
                <h1 class="mb-4 text-3xl font-black leading-[1.06] tracking-tight drop-shadow sm:text-4xl lg:text-5xl">
                    {{ $heroTitle }}
                </h1>
                <p class="mb-2 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                    {{ $heroIntro }}
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ $servicesHref }}" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                        Nos solutions
                    </a>
                    <a href="{{ $contactHref }}" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300">
                        Devis gratuit
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">
    <section class="bg-white py-14 sm:py-20" aria-labelledby="pillars-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            @if ($pillarsKicker !== '')
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ strtoupper($pillarsKicker) }}</p>
            @endif
            <h2 id="pillars-heading" class="mt-2 max-w-3xl text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                {{ $pillarsTitle }}
            </h2>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($pillars as $p)
                    @if (is_array($p))
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm transition hover:border-brand-blue/30 hover:bg-white hover:shadow-soft">
                            <h3 class="text-lg font-extrabold text-brand-dark">{{ data_get($p, 'title') }}</h3>
                            @if (trim((string) data_get($p, 'text')) !== '')
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ data_get($p, 'text') }}</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-slate-200/80 bg-slate-50/70 py-14 sm:py-20" aria-labelledby="expertise-heading">
        <div class="mx-auto grid w-[95%] gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:gap-14 lg:px-8">
            <div class="order-2 lg:order-1">
                <h2 id="expertise-heading" class="text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                    {{ $expertiseTitle }}
                </h2>
                <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">{{ $expertiseText }}</p>
            </div>
            <div class="order-1 overflow-hidden rounded-3xl border border-slate-200 shadow-soft lg:order-2">
                <img src="{{ $expertiseImage }}" alt="" class="aspect-[4/3] h-full w-full object-cover" width="800" height="600" loading="lazy" decoding="async">
            </div>
        </div>
    </section>

    <section class="bg-white py-14 sm:py-20" aria-labelledby="eco-heading">
        <div class="mx-auto grid w-[95%] gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:gap-14 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200 shadow-soft">
                <img src="{{ $ecoImage }}" alt="Équipe et engagements Normes et Rénovation" class="aspect-[4/3] h-full w-full object-cover" width="800" height="600" loading="lazy" decoding="async">
            </div>
            <div>
                <h2 id="eco-heading" class="text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                    {{ $ecoTitle }}
                </h2>
                <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">{{ $ecoText }}</p>
            </div>
        </div>
    </section>

    @include('home.avis', ['home' => $h])

    <section class="border-t border-slate-200/80 bg-slate-50/70 py-12 sm:py-16" aria-labelledby="satisfaction-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h2 id="satisfaction-heading" class="text-2xl font-extrabold text-brand-dark sm:text-3xl">
                Votre satisfaction est notre priorité
            </h2>
            <p class="mt-4 max-w-3xl text-sm leading-relaxed text-slate-600 sm:text-base">
                {!! nl2br(e($mediationText)) !!}
                <br>
                <a href="https://www.cm2c.net" class="mt-2 inline-block font-semibold text-brand-blue underline-offset-2 hover:underline" target="_blank" rel="noopener noreferrer">Consulter le site du médiateur CM2C</a>
            </p>
        </div>
    </section>

    @if ($taglineBottom !== '')
        <section class="bg-brand-dark py-10 text-center text-white sm:py-12">
            <p class="mx-auto max-w-3xl text-sm font-semibold leading-relaxed text-white/90 sm:text-base">
                {{ $taglineBottom }}
            </p>
        </section>
    @endif
</main>

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
