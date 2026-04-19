@php
    use App\Services\Legacy\LegacyUrlContext;
    $h            = $home ?? app(\App\Services\HomePageService::class)->merged();
    $ctx          = $context ?? LegacyUrlContext::fromPath($requestedPath ?? '');
    $h1           = $ctx['h1'] ?? 'Expert en Rénovation';
    $metaTitle    = $ctx['metaTitle'] ?? 'Normes Rénovation – Expert en rénovation';
    $metaDesc     = $ctx['metaDescription'] ?? '';
    $city         = $ctx['city'] ?? null;
    $svcLabel     = $ctx['serviceLabel'] ?? null;
    $svcEmoji     = $ctx['serviceEmoji'] ?? '🏠';
    $canonicalUrl = url('/');
    $currentUrl   = url('/' . ltrim($requestedPath ?? '', '/'));
    $faqItems     = LegacyUrlContext::getFaq($ctx);
    $phone        = trim((string) data_get($h, 'header.phone', ''));
    $phoneHref    = 'tel:' . preg_replace('/[^\d+]/', '', $phone);
    $serviceCards = collect((array) data_get($h, 'services.cards', []))
        ->filter(fn ($i) => is_array($i))->take(6)->values()->all();
    $heroSlide    = data_get($h, 'hero.slides.0', []);
    $heroBg       = \App\Support\HomeView::url(data_get($heroSlide, 'image', 'slide/toiture.png'));

    // Context-aware subtitle
    $subtitle = match (true) {
        ($svcLabel !== null && $city !== null) =>
            "Expert local certifié RGE en {$svcLabel} à {$city}. Devis gratuit sous 48h, financement MaPrimeRénov' possible.",
        ($svcLabel !== null) =>
            "Spécialiste certifié RGE en {$svcLabel}. Plus de 5 000 chantiers réalisés en Bourgogne-Franche-Comté & Bretagne.",
        default =>
            'Votre expert local certifié RGE. Toiture, isolation, façade, VMC, électrique. Devis gratuit sous 48h.',
    };
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home'         => $h,
    'title'        => $metaTitle,
    'description'  => $metaDesc,
    'canonicalUrl' => $canonicalUrl,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     HERO — H1 contextuel + formulaire rapide
     ═══════════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[560px] overflow-hidden sm:min-h-[640px]" aria-label="Introduction">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image:linear-gradient(110deg,rgba(47,66,81,.88),rgba(47,66,81,.50)),url('{{ $heroBg }}')">
    </div>

    <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[560px] flex-col gap-10 py-16 sm:min-h-[640px] lg:flex-row lg:items-center lg:gap-16 lg:py-20">

            {{-- ── Bloc texte ───────────────────────────────────── --}}
            <div class="flex-1 text-white">
                {{-- Fil d'Ariane --}}
                <nav class="mb-5 flex flex-wrap items-center gap-1.5 text-xs text-white/55" aria-label="Fil d'Ariane">
                    <a href="/" class="transition hover:text-white">Accueil</a>
                    @if ($svcLabel)
                        <span aria-hidden="true">/</span>
                        <span class="text-white/75">{{ $svcLabel }}</span>
                        @if ($city)
                            <span aria-hidden="true">/</span>
                            <span class="text-white">{{ $city }}</span>
                        @endif
                    @else
                        <span aria-hidden="true">/</span>
                        <span class="text-white/75">Rénovation</span>
                    @endif
                </nav>

                <h1 class="text-4xl font-black leading-[1.05] drop-shadow-md sm:text-5xl lg:text-6xl">
                    {{ $h1 }}
                </h1>
                <p class="mt-4 max-w-xl text-lg font-medium leading-relaxed text-slate-100/90 sm:text-xl">
                    {{ $subtitle }}
                </p>

                {{-- Badges de confiance --}}
                <div class="mt-5 flex flex-wrap gap-2" role="list" aria-label="Certifications">
                    @foreach ([
                        ['★ 5/5 Google', 'text-yellow-300'],
                        ['✅ Certifié RGE', 'text-emerald-300'],
                        ['🏠 +5 000 chantiers', 'text-sky-300'],
                        ['💶 Devis gratuit', 'text-white'],
                    ] as [$badge, $col])
                        <span role="listitem" class="inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-bold backdrop-blur-sm {{ $col }}">
                            {{ $badge }}
                        </span>
                    @endforeach
                </div>

                {{-- CTA principaux --}}
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#devis"
                       class="inline-flex items-center gap-2 rounded-xl bg-brand-yellow px-6 py-3.5 text-sm font-extrabold text-brand-dark shadow-lg transition hover:-translate-y-0.5 hover:bg-yellow-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/></svg>
                        Devis gratuit & rapide
                    </a>
                    @if ($phone !== '')
                        <a href="{{ $phoneHref }}"
                           class="inline-flex items-center gap-2 rounded-xl border-2 border-white/40 bg-transparent px-6 py-3.5 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:border-white hover:bg-white/10">
                            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            Appeler maintenant
                        </a>
                    @endif
                    <a href="/simulateur"
                       class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-6 py-3.5 text-sm font-extrabold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-sky-400">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm2.25-4.5h.008v.008H10.5v-.008Zm0 2.25h.008v.008H10.5V13.5Zm0 2.25h.008v.008H10.5v-.008Zm2.25-4.5h.008v.008H12.75v-.008Zm0 2.25h.008v.008H12.75V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z"/></svg>
                        Estimer mon projet
                    </a>
                </div>
            </div>

            {{-- ── Formulaire rapide ────────────────────────────── --}}
            <div class="w-full shrink-0 rounded-2xl border border-white/20 bg-white/96 p-6 shadow-2xl backdrop-blur-md sm:p-7 lg:max-w-[360px]">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.2em] text-brand-blue">Gratuit & sans engagement</p>
                <h2 class="text-xl font-black text-brand-dark sm:text-2xl">Votre devis en 48h</h2>
                <p class="mt-1 mb-5 text-xs text-slate-500">Un expert vous rappelle rapidement.</p>

                <form action="{{ route('contact.page') }}" method="get" class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="prenom" placeholder="Prénom" autocomplete="given-name"
                               class="col-span-1 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20">
                        <input type="text" name="nom" placeholder="Nom" autocomplete="family-name"
                               class="col-span-1 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20">
                    </div>
                    <input type="tel" name="telephone" placeholder="Téléphone *" autocomplete="tel" required
                           class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20">
                    <input type="text" name="code_postal" placeholder="Code postal" autocomplete="postal-code" inputmode="numeric" maxlength="10"
                           class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20">
                    @if (!empty($serviceCards))
                        <select name="service" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20">
                            <option value="">Votre projet…</option>
                            @foreach ($serviceCards as $svc)
                                @php $svcTitle = data_get($svc, 'title', ''); @endphp
                                <option value="{{ $svcTitle }}"
                                    {{ $svcLabel && mb_stripos($svcTitle, $svcLabel) !== false ? 'selected' : '' }}>
                                    {{ $svcTitle }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    <button type="submit"
                            class="w-full rounded-xl bg-brand-yellow px-4 py-3 text-sm font-extrabold text-brand-dark shadow-md transition hover:-translate-y-0.5 hover:bg-yellow-300">
                        Demander mon devis →
                    </button>
                    <p class="text-center text-[10px] text-slate-400">🔒 Gratuit · Sans engagement · Réponse sous 48h</p>
                </form>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BANDE DE RÉASSURANCE
     ═══════════════════════════════════════════════════════════════ --}}
<div class="border-b border-slate-100 bg-white py-5 shadow-sm">
    <div class="mx-auto flex w-[95%] flex-wrap items-center justify-center gap-6 px-4 sm:gap-10 sm:px-6 lg:px-8">
        @foreach ([
            ['🏆', 'Certifié RGE', 'Reconnu Garant de l\'Environnement'],
            ['⭐', 'Note 5/5', 'Sur Google – Avis vérifiés'],
            ['🏠', '+5 000 chantiers', 'Réalisés en France'],
            ['⚡', 'Réponse 48h', 'Devis gratuit & rapide'],
            ['💶', 'Aides disponibles', 'MaPrimeRénov\' & CEE'],
        ] as [$ico, $title, $sub])
            <div class="flex items-center gap-3">
                <span class="text-2xl leading-none" aria-hidden="true">{{ $ico }}</span>
                <div>
                    <p class="text-sm font-extrabold text-brand-dark">{{ $title }}</p>
                    <p class="text-xs text-slate-500">{{ $sub }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     NOS SERVICES
     ═══════════════════════════════════════════════════════════════ --}}
@include('home.services', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     POURQUOI NORMES / PROCESSUS
     ═══════════════════════════════════════════════════════════════ --}}
@include('home.pourquoi_processus', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     STATS
     ═══════════════════════════════════════════════════════════════ --}}
@include('home.stats', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     AVIS CLIENTS
     ═══════════════════════════════════════════════════════════════ --}}
@include('home.avis', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     FAQ (générée selon le service détecté)
     ═══════════════════════════════════════════════════════════════ --}}
@if (!empty($faqItems))
<section class="bg-slate-50/70 py-14 sm:py-20" aria-labelledby="faq-heading">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl">
            <p class="mb-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-brand-blue">FAQ</p>
            <h2 id="faq-heading" class="mb-2 text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                Questions <span class="text-brand-blue">fréquentes</span>
            </h2>
            <p class="mb-8 text-base text-slate-600 sm:text-lg">
                Tout ce que vous devez savoir sur
                {{ $svcLabel ? mb_strtolower($svcLabel) : 'la rénovation énergétique' }}
            </p>

            <div class="space-y-3" itemscope itemtype="https://schema.org/FAQPage">
                @foreach ($faqItems as $faq)
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                         itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <button type="button" class="faq-btn flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-blue">
                            <span class="text-sm font-extrabold text-brand-dark sm:text-base" itemprop="name">{{ $faq['q'] }}</span>
                            <svg class="faq-chevron h-5 w-5 shrink-0 text-brand-blue transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden border-t border-slate-100 px-5 py-4"
                             itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <p class="text-sm leading-relaxed text-slate-600" itemprop="text">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 rounded-2xl border border-brand-blue/20 bg-brand-blue/5 p-6 text-center sm:p-8">
                <p class="text-base font-extrabold text-brand-dark sm:text-lg">Vous ne trouvez pas votre réponse ?</p>
                <p class="mt-2 text-sm text-slate-600">Notre équipe est disponible du lundi au vendredi, de 8h à 18h.</p>
                <div class="mt-4 flex flex-wrap justify-center gap-3">
                    <a href="#devis" class="rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-extrabold text-white transition hover:bg-sky-500">Nous contacter</a>
                    @if ($phone !== '')
                        <a href="{{ $phoneHref }}" class="rounded-xl border-2 border-brand-dark px-5 py-2.5 text-sm font-extrabold text-brand-dark transition hover:bg-brand-dark hover:text-white">{{ $phone }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     FORMULAIRE DE DEVIS (complet)
     ═══════════════════════════════════════════════════════════════ --}}
@include('home.devis', ['home' => $h])

@include('home.partners', ['home' => $h])
@include('home.footer', ['home' => $h])
@include('home.popup_simulateur', ['home' => $h])
@include('home.cookie_consent', ['home' => $h])
@include('home.countup_script')
@include('home.scripts', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     JSON-LD STRUCTURED DATA
     ═══════════════════════════════════════════════════════════════ --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": ["LocalBusiness", "ProfessionalService"],
      "@id": "{{ url('/') }}#business",
      "name": "Normes Rénovation",
      "description": "Spécialiste en rénovation énergétique : toiture, isolation des combles, ravalement de façade, VMC, climatisation, installation électrique et panneaux solaires.",
      "url": "{{ url('/') }}",
      @if ($phone !== '')
      "telephone": "{{ $phone }}",
      @endif
      "logo": {
        "@type": "ImageObject",
        "url": "{{ url('/logo.png') }}"
      },
      "image": "{{ $heroBg }}",
      "priceRange": "€€",
      "currenciesAccepted": "EUR",
      "paymentAccepted": "Chèque, Virement bancaire, Carte bancaire",
      "areaServed": [
        { "@type": "AdministrativeArea", "name": "Bourgogne-Franche-Comté" },
        { "@type": "AdministrativeArea", "name": "Saône-et-Loire" },
        { "@type": "AdministrativeArea", "name": "Côte-d'Or" },
        { "@type": "AdministrativeArea", "name": "Bretagne" }
      ],
      "knowsAbout": ["Toiture", "Isolation des combles", "Ravalement de façade", "VMC", "Climatisation", "Panneaux solaires", "Installation électrique"],
      "hasCredential": {
        "@type": "EducationalOccupationalCredential",
        "credentialCategory": "RGE – Reconnu Garant de l'Environnement"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
        "opens": "08:00",
        "closes": "18:00"
      }
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ url('/') }}" }
        @if ($svcLabel)
        ,{ "@type": "ListItem", "position": 2, "name": "{{ addslashes($svcLabel) }}", "item": "{{ $currentUrl }}" }
        @endif
        @if ($city)
        ,{ "@type": "ListItem", "position": 3, "name": "{{ addslashes($city) }}", "item": "{{ $currentUrl }}" }
        @endif
      ]
    }
    @if (!empty($faqItems))
    ,{
      "@type": "FAQPage",
      "mainEntity": [
        @foreach ($faqItems as $faq)
        {
          "@type": "Question",
          "name": {{ json_encode($faq['q']) }},
          "acceptedAnswer": {
            "@type": "Answer",
            "text": {{ json_encode($faq['a']) }}
          }
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
      ]
    }
    @endif
  ]
}
</script>

<script>
document.querySelectorAll('.faq-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var body    = this.nextElementSibling;
        var chevron = this.querySelector('.faq-chevron');
        var open    = !body.classList.contains('hidden');
        body.classList.toggle('hidden', open);
        chevron.style.transform = open ? '' : 'rotate(180deg)';
        this.setAttribute('aria-expanded', String(!open));
    });
    btn.setAttribute('aria-expanded', 'false');
});
</script>
</body>
</html>
