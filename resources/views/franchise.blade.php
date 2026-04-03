@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $f = data_get($h, 'footer', []);
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = 'Franchise | Devenez franchisé | '.$siteName;
    $metaDescription = 'Devenez franchisé Normes Rénovation : marque reconnue, formation, accompagnement et réseau en Bourgogne et Bretagne. Déposez votre candidature en ligne.';
    $metaKeywords = 'franchise, franchisé, Normes Rénovation, agence, rénovation, Bourgogne, Bretagne';
    $ogImage = trim((string) data_get($h, 'meta.og_image', 'logo.png'));
    $canonicalUrl = route('franchise.page');
    $heroBg = HomeView::url((string) data_get($h, 'styles.footer_bg', 'slide/toiture.png'));
    $agencesHref = route('home', [], false).'#agences';
    $footerEmail = trim((string) data_get($f, 'email', 'bourgogne-agence@normesrenovation.fr'));
    $footerPhone = trim((string) data_get($f, 'phone', '03 85 41 98 86'));
    $footerPhoneHref = trim((string) data_get($f, 'phone_href', 'tel:+33385419886'));
    $hqLines = data_get($f, 'address_lines', []);
    if (! is_array($hqLines)) {
        $hqLines = [];
    }
    $hqAddress = $hqLines !== [] ? implode(', ', array_map('strval', $hqLines)) : '6 rue Pierre de Coubertin, 71100 Chalon-sur-Saône';

    $faqItems = [
        [
            'q' => 'Quels sont les coûts associés à la franchise Normes Rénovation ?',
            'a' => 'Les coûts varient selon la localisation, la taille du territoire et le projet d’implantation. Nous vous fournissons une estimation personnalisée après analyse de votre dossier et entretien avec notre équipe.',
        ],
        [
            'q' => 'Quel soutien puis-je attendre de Normes en tant que franchisé ?',
            'a' => 'Formation initiale et continue, méthodes commerciales et techniques, outils de pilotage, communication de marque, appui juridique et commercial, et mise en relation avec le réseau d’agences.',
        ],
        [
            'q' => 'Quelles sont les qualifications requises pour devenir franchisé Normes ?',
            'a' => 'Vous devez avoir un profil entrepreneurial, une capacité d’investissement adaptée, l’envie de développer une équipe locale sur le long terme, et partager nos exigences de qualité et de conformité RGE.',
        ],
        [
            'q' => 'Comment se déroule le processus de franchise avec Normes ?',
            'a' => 'Après envoi du formulaire, nous vous recontactons pour un entretien de qualification, l’analyse du territoire, la validation du business plan, puis la signature des documents et le planning de formation / ouverture.',
        ],
    ];

    $steps = [
        ['title' => 'Envoyez votre candidature', 'text' => 'Remplissez le formulaire en ligne : nous étudions votre profil et votre secteur géographique.'],
        ['title' => 'Entretien & analyse', 'text' => 'Échanges avec notre équipe pour valider l’adéquation du territoire et du projet.'],
        ['title' => 'Proposition & formation', 'text' => 'Remise des engagements, planning de formation et mise à disposition des outils réseau.'],
        ['title' => 'Ouverture & suivi', 'text' => 'Lancement de votre agence avec accompagnement continu et reporting.'],
    ];

    $pillars = [
        ['title' => 'Marque reconnue', 'text' => 'Bénéficiez de la notoriété et de la confiance associées à Normes Rénovation.'],
        ['title' => 'Soutien continu', 'text' => 'Formation complète, accompagnement personnalisé et outils de gestion adaptés au terrain.'],
        ['title' => 'Opportunité de croissance', 'text' => 'Un marché de la rénovation et de la performance énergétique en fort développement.'],
        ['title' => 'Innovation et qualité', 'text' => 'Process et offres alignées sur les normes et les attentes des clients.'],
        ['title' => 'Réseau solidaire', 'text' => 'Échanges entre franchisés, bonnes pratiques et entraide au quotidien.'],
    ];
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

<section id="top" class="relative min-h-[420px] overflow-hidden sm:min-h-[480px]">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}');" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/92 via-brand-dark/55 to-brand-dark/25" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[420px] w-[95%] flex-col justify-end gap-4 px-4 py-10 sm:min-h-[480px] sm:px-6 sm:py-12 lg:px-8">
        <div class="max-w-4xl text-white">
            <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">Franchise 100 % rentable</p>
            <h1 class="text-3xl font-black leading-[1.08] tracking-tight drop-shadow-md sm:text-4xl lg:text-5xl">
                Devenez franchisé <span class="text-brand-blue">Normes Rénovation</span>
            </h1>
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                Lancez votre entreprise avec une marque structurée, un marché porteur et un accompagnement de bout en bout — de la formation à la croissance de votre agence.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#candidature" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                    Commencer mon dossier
                </a>
                <a href="{{ $agencesHref }}" class="rounded-xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-extrabold text-white backdrop-blur-sm transition hover:bg-white/15 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                    Voir nos agences
                </a>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">
    <section class="border-b border-slate-200 bg-white py-14 sm:py-16" aria-labelledby="pourquoi-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 id="pourquoi-heading" class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">Pourquoi ?</h2>
                <p class="mt-3 text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">Pourquoi choisir Normes Rénovation ?</p>
                <p class="mt-4 text-base text-slate-600 sm:text-lg">Notoriété et confiance · Formation et accompagnement · Croissance et opportunités</p>
            </div>
            <ul class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($pillars as $pillar)
                    <li class="rounded-2xl border border-slate-200/90 bg-slate-50/80 p-6 shadow-sm">
                        <h3 class="text-lg font-extrabold text-brand-dark">{{ $pillar['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $pillar['text'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="bg-slate-50 py-14 sm:py-16" aria-labelledby="implantation-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-14">
                <div>
                    <h2 id="implantation-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">
                        Déjà présents en <span class="text-brand-blue">Bourgogne</span> et <span class="text-brand-blue">Bretagne</span>
                    </h2>
                    <p class="mt-4 text-base leading-relaxed text-slate-600">
                        Normes Rénovation est implanté en Bourgogne-Franche-Comté et en Bretagne, avec des solutions de rénovation et de performance énergétique pour les particuliers et les professionnels. En rejoignant le réseau, vous capitalisez sur une expertise locale et une marque déjà identifiée sur ces territoires.
                    </p>
                    <a href="{{ $agencesHref }}" class="mt-6 inline-flex rounded-xl bg-brand-dark px-5 py-3 text-sm font-extrabold text-white shadow-md transition hover:bg-slate-800">
                        Voir nos agences
                    </a>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                        <p class="text-3xl font-black text-brand-blue">+3</p>
                        <p class="mt-1 text-xs font-extrabold uppercase tracking-wide text-slate-500">Agences</p>
                        <p class="mt-2 text-sm text-slate-600">Réseau en développement sur la France</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                        <p class="text-3xl font-black text-brand-blue">99%</p>
                        <p class="mt-1 text-xs font-extrabold uppercase tracking-wide text-slate-500">Satisfaction</p>
                        <p class="mt-2 text-sm text-slate-600">Objectif qualité sur le terrain</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm sm:col-span-3 lg:col-span-1">
                        <p class="text-2xl font-black text-brand-blue">Ambition</p>
                        <p class="mt-1 text-xs font-extrabold uppercase tracking-wide text-slate-500">CA / agence</p>
                        <p class="mt-2 text-sm text-slate-600">Potentiel lié au territoire et au pilotage commercial</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-14 sm:py-16" aria-labelledby="franchises-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h2 id="franchises-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">Nos franchisés</h2>
            <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600">
                Rejoignez un réseau dynamique sur un marché à fort potentiel. Bénéficiez de notre expertise, de notre accompagnement et de notre marque pour structurer votre développement.
            </p>
            <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                    <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-blue text-sm font-black text-white">1</span>
                    <div><strong class="text-brand-dark">Réseau national</strong><p class="mt-1 text-sm text-slate-600">Plusieurs agences actives — objectif de déploiement maîtrisé.</p></div>
                </li>
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                    <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-blue text-sm font-black text-white">2</span>
                    <div><strong class="text-brand-dark">Satisfaction réseau</strong><p class="mt-1 text-sm text-slate-600">Un suivi qualitatif et des process communs pour sécuriser l’expérience client.</p></div>
                </li>
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                    <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-blue text-sm font-black text-white">3</span>
                    <div><strong class="text-brand-dark">Croissance</strong><p class="mt-1 text-sm text-slate-600">Vision long terme : développement commercial et renfort des équipes.</p></div>
                </li>
                <li class="flex gap-3 rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                    <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-blue text-sm font-black text-white">4</span>
                    <div><strong class="text-brand-dark">Formation</strong><p class="mt-1 text-sm text-slate-600">Centaines d’heures de formation et d’accompagnement personnalisé par an pour les équipes.</p></div>
                </li>
            </ul>
            <figure class="mt-10 rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-8 shadow-sm">
                <blockquote class="text-lg font-medium leading-relaxed text-brand-dark">
                    « Devenir agence Normes a été un tournant : le soutien et les outils du réseau m’ont permis d’accélérer le développement tout en gardant le cap sur la qualité. »
                </blockquote>
                <figcaption class="mt-4 text-sm font-bold text-brand-blue">Fiona — Normes Rénovation Bretagne</figcaption>
            </figure>
        </div>
    </section>

    <section class="border-t border-slate-200 bg-slate-50 py-14 sm:py-16" aria-labelledby="etapes-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <h2 id="etapes-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">Comment faire ?</h2>
            <p class="mt-2 text-slate-600">Les étapes pour nous rejoindre</p>
            <ol class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as $idx => $step)
                    <li class="relative rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <span class="absolute -top-3 left-4 inline-flex rounded-full bg-brand-yellow px-2.5 py-0.5 text-xs font-black text-brand-dark">{{ $idx + 1 }}</span>
                        <h3 class="mt-2 text-base font-extrabold text-brand-dark">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="bg-white py-14 sm:py-16" aria-labelledby="faq-heading">
        <div class="mx-auto w-[95%] max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 id="faq-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">Ce qu’il faut savoir (F.A.Q.)</h2>
            <div class="mt-8 space-y-3">
                @foreach ($faqItems as $item)
                    <details class="group rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 open:bg-white open:shadow-sm">
                        <summary class="cursor-pointer list-none text-sm font-extrabold text-brand-dark after:float-right after:content-['+'] group-open:after:content-['−']">
                            {{ $item['q'] }}
                        </summary>
                        <p class="mt-3 border-t border-slate-200 pt-3 text-sm leading-relaxed text-slate-600">{{ $item['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    @include('home.avis', ['home' => $h])

    <section id="candidature" class="scroll-mt-24 border-t border-slate-200 bg-brand-dark py-14 text-white sm:py-20">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-[1fr_1.15fr] lg:gap-14">
                <div>
                    <h2 class="text-3xl font-black tracking-tight sm:text-4xl"><span class="text-brand-blue">C’est à vous</span> — commencer votre dossier</h2>
                    <p class="mt-4 text-sm leading-relaxed text-white/85 sm:text-base">
                        Décrivez votre projet en quelques lignes : un expert Normes Rénovation vous recontacte pour un échange structuré et confidentiel.
                    </p>
                    <div class="mt-10 space-y-5 rounded-2xl border border-white/15 bg-white/5 p-6 backdrop-blur-sm">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">Adresse</p>
                            <p class="mt-1 text-sm text-white/90">{{ $hqAddress }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">E-mail</p>
                            <a href="mailto:{{ $footerEmail }}" class="mt-1 text-sm text-brand-blue hover:underline">{{ $footerEmail }}</a>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">Téléphone</p>
                            <a href="{{ $footerPhoneHref !== '' ? $footerPhoneHref : 'tel:'.$footerPhone }}" class="mt-1 text-sm text-brand-blue hover:underline">{{ $footerPhone }}</a>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/20 bg-white p-6 text-brand-dark shadow-xl sm:p-8">
                    @if (session('franchise_status'))
                        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900" role="status">
                            {{ session('franchise_status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900" role="alert">
                            <p class="font-extrabold">Veuillez corriger les champs ci-dessous.</p>
                            <ul class="mt-2 list-inside list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('franchise.store') }}" class="space-y-4">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="fr_name" class="mb-1 block text-sm font-semibold">Nom complet <span class="text-red-600">*</span></label>
                                <input id="fr_name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div>
                                <label for="fr_phone" class="mb-1 block text-sm font-semibold">Téléphone <span class="text-red-600">*</span></label>
                                <input id="fr_phone" name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div>
                                <label for="fr_email" class="mb-1 block text-sm font-semibold">E-mail <span class="text-red-600">*</span></label>
                                <input id="fr_email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_cp" class="mb-1 block text-sm font-semibold">Code postal <span class="text-red-600">*</span></label>
                                <input id="fr_cp" name="postal_code" type="text" inputmode="numeric" maxlength="10" autocomplete="postal-code" value="{{ old('postal_code') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_indep" class="mb-1 block text-sm font-semibold">Avez-vous déjà exercé une activité en indépendant ? <span class="text-red-600">*</span></label>
                                <select id="fr_indep" name="has_independent_activity" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                                    @php $oldIndep = (string) old('has_independent_activity', ''); @endphp
                                    <option value="" {{ $oldIndep === '' ? 'selected' : '' }}>Sélectionner</option>
                                    <option value="1" {{ in_array($oldIndep, ['1', 'oui', 'yes'], true) ? 'selected' : '' }}>Oui</option>
                                    <option value="0" {{ in_array($oldIndep, ['0', 'non', 'no'], true) ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_sector" class="mb-1 block text-sm font-semibold">Secteur géographique visé <span class="text-red-600">*</span></label>
                                <input id="fr_sector" name="geographic_sector" type="text" value="{{ old('geographic_sector') }}" placeholder="Ville, département ou région" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_apport" class="mb-1 block text-sm font-semibold">Apport personnel envisagé (€)</label>
                                <input id="fr_apport" name="personal_contribution" type="text" value="{{ old('personal_contribution') }}" inputmode="decimal" placeholder="Ex. 30 000" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_msg" class="mb-1 block text-sm font-semibold">Message</label>
                                <textarea id="fr_msg" name="message" rows="5" placeholder="Parlez-nous de votre projet, de votre expérience et de vos disponibilités." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-brand-blue px-4 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 sm:text-base">
                            Envoyer ma candidature
                        </button>
                        <p class="text-center text-xs text-slate-500">Les informations transmises sont destinées à l’étude de votre dossier. Vous pouvez solliciter l’accès, la rectification ou la suppression de vos données conformément au RGPD.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@php
    $franchiseLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $metaTitle,
        'description' => $metaDescription,
        'url' => $canonicalUrl,
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => url('/'),
        ],
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Franchise', 'item' => $canonicalUrl],
            ],
        ],
    ];
    $faqLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($faqItems)->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
        ])->values()->all(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($franchiseLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
