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

    $contactStripTitle = trim((string) data_get($ap, 'contact_strip_title', 'NOUS CONTACTEZ'));
    $contactStripCompactTitle = trim((string) data_get($ap, 'contact_strip_compact_title', $contactStripTitle));

    $avisKicker = trim((string) data_get($ap, 'avis_section_kicker', 'VOS AVIS'));
    $avisTitle = trim((string) data_get($ap, 'avis_section_title', 'Ce que disent nos clients'));
    $googleReviewsLabel = trim((string) data_get($ap, 'google_reviews_label', ''));
    $googleUrl = trim((string) data_get($ap, 'google_url', ''));
    if ($googleUrl === '') {
        $googleUrl = trim((string) data_get($h, 'avis.google_url', data_get($h, 'floating.google_url', '')));
    }

    $testimonials = data_get($ap, 'testimonials');
    if (! is_array($testimonials) || $testimonials === []) {
        $testimonials = require base_path('app/Support/about_testimonials_defaults.php');
    }

    $satisfactionTitle = trim((string) data_get($ap, 'satisfaction_title', 'Votre satisfaction est notre priorité'));

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

<section id="top" class="relative min-h-[520px] overflow-hidden sm:min-h-[620px]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $heroBg }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/95 via-brand-dark/50 to-brand-dark/20" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-brand-dark/40 to-transparent" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto flex min-h-[520px] w-[95%] max-w-6xl flex-col justify-end gap-6 px-4 py-10 sm:min-h-[620px] sm:px-6 lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="relative rounded-3xl border border-white/20 bg-brand-dark/45 p-6 shadow-[0_28px_60px_-18px_rgba(0,0,0,0.55)] backdrop-blur-xl ring-1 ring-white/10 sm:p-8">
                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-brand-yellow/15 blur-2xl" aria-hidden="true"></div>
                @if ($heroKicker !== '')
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-yellow backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-yellow shadow-[0_0_8px_rgba(250,204,21,0.9)]" aria-hidden="true"></span>
                        {{ mb_strtoupper($heroKicker, 'UTF-8') }}
                    </p>
                @endif
                <h1 class="mb-4 text-3xl font-black leading-[1.06] tracking-tight text-white drop-shadow-md sm:text-4xl lg:text-[2.75rem]">
                    {{ $heroTitle }}
                </h1>
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
                    <a href="#nous-contacter" class="inline-flex rounded-2xl border border-white/35 bg-white/10 px-5 py-3 text-sm font-extrabold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:bg-white/18 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">
    <section class="relative bg-white py-16 sm:py-24" aria-labelledby="pillars-heading">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-full max-h-[420px] bg-[radial-gradient(ellipse_80%_60%_at_50%_-10%,rgba(14,165,233,0.08),transparent)]" aria-hidden="true"></div>
        <div class="relative mx-auto w-[95%] max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($pillarsKicker !== '')
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ mb_strtoupper($pillarsKicker, 'UTF-8') }}</p>
            @endif
            <h2 id="pillars-heading" class="mt-3 max-w-3xl text-3xl font-black leading-tight tracking-tight text-brand-dark sm:text-4xl">
                {{ $pillarsTitle }}
            </h2>
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($pillars as $p)
                    @if (is_array($p))
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm ring-1 ring-slate-100 transition duration-300 hover:-translate-y-1 hover:border-brand-blue/25 hover:shadow-lg">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-brand-blue via-sky-400 to-brand-yellow opacity-90 transition group-hover:opacity-100" aria-hidden="true"></div>
                            <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-brand-blue/12 to-sky-500/10 text-sm font-black tabular-nums text-brand-blue ring-1 ring-brand-blue/10">
                                {{ $loop->iteration }}
                            </div>
                            <h3 class="text-lg font-extrabold leading-snug text-brand-dark">{{ data_get($p, 'title') }}</h3>
                            @if (trim((string) data_get($p, 'text')) !== '')
                                <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ data_get($p, 'text') }}</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    @include('about._contact-strip', [
        'stripTitle' => $contactStripTitle,
        'phone' => $footerPhone,
        'phoneHref' => $footerPhoneHref,
        'email' => $footerEmail,
        'contactHref' => $contactHref,
        'compact' => false,
    ])

    <section class="border-t border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-16 sm:py-24" aria-labelledby="expertise-heading">
        <div class="mx-auto grid w-[95%] max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:gap-16 lg:px-8">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 rounded-full bg-brand-blue/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-brand-blue">Savoir-faire</div>
                <h2 id="expertise-heading" class="mt-4 text-3xl font-black leading-tight tracking-tight text-brand-dark sm:text-4xl">
                    {{ $expertiseTitle }}
                </h2>
                <p class="mt-5 text-base leading-relaxed text-slate-600 sm:text-lg">{{ $expertiseText }}</p>
            </div>
            <div class="order-1 lg:order-2">
                <div class="relative">
                    <div class="absolute -inset-3 rounded-[1.7rem] bg-gradient-to-br from-brand-blue/20 via-transparent to-brand-yellow/15 blur-sm" aria-hidden="true"></div>
                    <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 shadow-[0_24px_50px_-12px_rgba(15,23,42,0.18)] ring-1 ring-slate-200/60">
                        <img src="{{ $expertiseImage }}" alt="Rénovation de toiture et habitat — expertise Normes et Rénovation" class="aspect-[4/3] h-full w-full object-cover" width="800" height="600" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 sm:py-24" aria-labelledby="eco-heading">
        <div class="mx-auto grid w-[95%] max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:gap-16 lg:px-8">
            <div>
                <div class="relative">
                    <div class="absolute -inset-3 rounded-[1.7rem] bg-gradient-to-tr from-emerald-400/15 via-transparent to-brand-blue/15 blur-sm" aria-hidden="true"></div>
                    <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 shadow-[0_24px_50px_-12px_rgba(15,23,42,0.18)] ring-1 ring-slate-200/60">
                        <img src="{{ $ecoImage }}" alt="Équipe et engagements Normes et Rénovation" class="aspect-[4/3] h-full w-full object-cover" width="800" height="600" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-emerald-800">Environnement</div>
                <h2 id="eco-heading" class="mt-4 text-3xl font-black leading-tight tracking-tight text-brand-dark sm:text-4xl">
                    {{ $ecoTitle }}
                </h2>
                <p class="mt-5 text-base leading-relaxed text-slate-600 sm:text-lg">{{ $ecoText }}</p>
            </div>
        </div>
    </section>

    @include('about._reviews', [
        'avisKicker' => $avisKicker,
        'avisTitle' => $avisTitle,
        'googleReviewsLabel' => $googleReviewsLabel,
        'googleUrl' => $googleUrl,
        'testimonials' => $testimonials,
    ])

    <section class="border-t border-slate-200/80 bg-slate-50/80 py-14 sm:py-20" aria-labelledby="satisfaction-heading">
        <div class="mx-auto w-[95%] max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl border border-slate-200/90 bg-white p-6 shadow-[0_20px_45px_-18px_rgba(15,23,42,0.12)] ring-1 ring-slate-100 sm:p-10">
                <div class="pointer-events-none absolute -right-16 top-1/2 h-48 w-48 -translate-y-1/2 rounded-full bg-brand-blue/[0.06] blur-3xl" aria-hidden="true"></div>
                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start sm:gap-8">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-blue to-sky-600 text-white shadow-lg" aria-hidden="true">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 id="satisfaction-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">
                            {{ $satisfactionTitle }}
                        </h2>
                        <p class="mt-4 max-w-3xl text-sm leading-relaxed text-slate-600 sm:text-base">
                            {!! nl2br(e($mediationText)) !!}
                        </p>
                        <a href="https://www.cm2c.net" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-blue px-4 py-2.5 text-sm font-extrabold text-white shadow-md transition hover:-translate-y-0.5 hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2" target="_blank" rel="noopener noreferrer">
                            Consulter le site du médiateur CM2C
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($showLegal)
        <section class="border-t border-slate-200/80 bg-white py-16 sm:py-20" aria-labelledby="legal-heading">
            <div class="mx-auto w-[95%] max-w-6xl px-4 sm:px-6 lg:px-8">
                <h2 id="legal-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">
                    {{ trim((string) data_get($legal, 'title', 'Mentions légales')) }}
                </h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:gap-8">
                    <div class="rounded-2xl border border-slate-200/90 bg-slate-50/80 p-6 ring-1 ring-slate-100 sm:p-8">
                        <h3 class="text-xs font-extrabold uppercase tracking-[0.15em] text-brand-blue">
                            {{ trim((string) data_get($legal, 'siege_title', 'Siège social')) }}
                        </h3>
                        @if ($footerCompany !== '')
                            <p class="mt-4 text-lg font-bold text-brand-dark">{{ $footerCompany }}</p>
                        @endif
                        @if ($footerAddressLines !== [])
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                @foreach ($footerAddressLines as $line)
                                    {{ $line }}@if (! $loop->last)<br>@endif
                                @endforeach
                            </p>
                        @endif
                    </div>
                    <div class="rounded-2xl border border-slate-200/90 bg-slate-50/80 p-6 ring-1 ring-slate-100 sm:p-8">
                        <h3 class="text-xs font-extrabold uppercase tracking-[0.15em] text-brand-blue">
                            {{ trim((string) data_get($legal, 'contact_title', 'Contact')) }}
                        </h3>
                        @if ($footerPhone !== '')
                            <p class="mt-4 text-sm text-slate-600">Téléphone</p>
                            <a href="{{ $footerPhoneHref !== '' ? 'tel:'.preg_replace('#^tel:#i', '', $footerPhoneHref) : '#' }}" class="mt-1 inline-block text-lg font-extrabold text-brand-blue transition hover:text-sky-600">{{ $footerPhone }}</a>
                        @endif
                        @if ($footerEmail !== '')
                            <p class="mt-4 text-sm text-slate-600">E-mail</p>
                            <a href="mailto:{{ $footerEmail }}" class="mt-1 inline-block break-all text-sm font-semibold text-brand-dark underline-offset-2 transition hover:text-brand-blue hover:underline">{{ $footerEmail }}</a>
                        @endif
                    </div>
                </div>
                <div class="mt-8 rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm ring-1 ring-slate-100 sm:p-8">
                    <h3 class="text-xs font-extrabold uppercase tracking-[0.15em] text-brand-blue">
                        {{ trim((string) data_get($legal, 'representative_title', 'Représentant légal')) }}
                    </h3>
                    @if (trim((string) data_get($legal, 'representative_text')) !== '')
                        <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ data_get($legal, 'representative_text') }}</p>
                    @endif
                    <ul class="mt-6 grid gap-3 text-sm leading-relaxed text-slate-600 sm:grid-cols-1 lg:grid-cols-2">
                        @if (trim((string) data_get($legal, 'rcs_label')) !== '' && trim((string) data_get($legal, 'rcs_number')) !== '')
                            <li class="rounded-xl bg-slate-50/90 px-4 py-3 ring-1 ring-slate-100"><span class="font-bold text-brand-dark">{{ data_get($legal, 'rcs_label') }}</span><span class="mt-1 block text-slate-600">N° d’inscription : {{ data_get($legal, 'rcs_number') }}</span></li>
                        @endif
                        @if (trim((string) data_get($legal, 'siren_label')) !== '' && trim((string) data_get($legal, 'siren')) !== '')
                            <li class="rounded-xl bg-slate-50/90 px-4 py-3 ring-1 ring-slate-100"><span class="font-bold text-brand-dark">{{ data_get($legal, 'siren_label') }}</span><span class="mt-1 block font-mono text-slate-700">{{ data_get($legal, 'siren') }}</span></li>
                        @endif
                        @if (trim((string) data_get($legal, 'siret_label')) !== '' && trim((string) data_get($legal, 'siret')) !== '')
                            <li class="rounded-xl bg-slate-50/90 px-4 py-3 ring-1 ring-slate-100"><span class="font-bold text-brand-dark">{{ data_get($legal, 'siret_label') }}</span><span class="mt-1 block font-mono text-slate-700">{{ data_get($legal, 'siret') }}</span></li>
                        @endif
                        @if (trim((string) data_get($legal, 'tva_label')) !== '' && trim((string) data_get($legal, 'tva')) !== '')
                            <li class="rounded-xl bg-slate-50/90 px-4 py-3 ring-1 ring-slate-100 lg:col-span-2"><span class="font-bold text-brand-dark">{{ data_get($legal, 'tva_label') }}</span><span class="mt-1 block font-mono text-slate-700">TVA intracommunautaire : {{ data_get($legal, 'tva') }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>
    @endif

    @include('about._contact-strip', [
        'stripTitle' => $contactStripCompactTitle,
        'phone' => $footerPhone,
        'phoneHref' => $footerPhoneHref,
        'email' => $footerEmail,
        'contactHref' => $contactHref,
        'compact' => true,
    ])

    @if ($taglineBottom !== '')
        <section class="relative overflow-hidden bg-gradient-to-br from-brand-dark via-brand-dark to-slate-900 py-12 text-center text-white sm:py-14">
            <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(105deg,transparent_40%,rgba(14,165,233,0.07)_50%,transparent_60%)]" aria-hidden="true"></div>
            <p class="relative mx-auto max-w-3xl px-4 text-sm font-semibold leading-relaxed text-white/92 sm:text-base">
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
