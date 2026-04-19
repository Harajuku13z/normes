@php
    use App\Services\Legacy\LegacyUrlContext;
    $h            = $home ?? app(\App\Services\HomePageService::class)->merged();
    $ctx          = $context ?? LegacyUrlContext::fromPath($requestedPath ?? '');
    $pageTitle    = filled($page->meta_title)       ? $page->meta_title       : ($ctx['metaTitle']       ?? $page->title . ' – Normes Rénovation');
    $pageDesc     = filled($page->meta_description) ? $page->meta_description : ($ctx['metaDescription'] ?? $page->excerpt ?? '');
    $canonicalUrl = filled($page->canonical_url)    ? $page->canonical_url    : url('/' . ltrim($requestedPath ?? '', '/'));
    $h1Text       = filled($page->h1)               ? $page->h1               : $page->title;
    $excerpt      = trim((string) $page->excerpt);
    $hasContent   = trim(strip_tags((string) $page->content_html)) !== '';
    $faqItems     = LegacyUrlContext::getFaq($ctx);
    $phone        = trim((string) data_get($h, 'header.phone', ''));
    $phoneHref    = 'tel:' . preg_replace('/[^\d+]/', '', $phone);
    $svcLabel     = $ctx['serviceLabel'] ?? null;
    $city         = $ctx['city'] ?? null;
    $serviceCards = collect((array) data_get($h, 'services.cards', []))
        ->filter(fn ($i) => is_array($i))->take(6)->values()->all();
    $heroBg       = \App\Support\HomeView::url(data_get($h, 'hero.slides.0.image', 'slide/toiture.png'));
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home'         => $h,
    'title'        => $pageTitle,
    'description'  => $pageDesc,
    'canonicalUrl' => $canonicalUrl,
    'ogImage'      => $page->og_image,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

{{-- ═══════════════════════════════════════════════════════════════
     HERO BARRE — Titre + fil d'Ariane
     ═══════════════════════════════════════════════════════════════ --}}
<header class="relative overflow-hidden bg-brand-dark py-12 sm:py-16" role="banner">
    <div class="absolute inset-0 bg-cover bg-center opacity-20"
         style="background-image:url('{{ $heroBg }}')"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-brand-dark via-brand-dark/95 to-brand-dark/80"></div>
    <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <nav class="mb-4 flex flex-wrap items-center gap-1.5 text-xs text-white/50" aria-label="Fil d'Ariane">
            <a href="/" class="transition hover:text-white">Accueil</a>
            @if ($svcLabel)
                <span aria-hidden="true">/</span>
                <span class="text-white/70">{{ $svcLabel }}</span>
            @endif
            <span aria-hidden="true">/</span>
            <span class="max-w-xs truncate text-white/90">{{ $h1Text }}</span>
        </nav>
        <h1 class="max-w-4xl text-3xl font-black leading-tight text-white drop-shadow-md sm:text-4xl lg:text-5xl">
            {{ $h1Text }}
        </h1>
        @if ($excerpt !== '')
            <p class="mt-4 max-w-3xl text-base font-medium leading-relaxed text-slate-200/90 sm:text-lg">
                {{ $excerpt }}
            </p>
        @endif
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="#devis"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow transition hover:-translate-y-0.5 hover:bg-yellow-300">
                Devis gratuit →
            </a>
            @if ($phone !== '')
                <a href="{{ $phoneHref }}"
                   class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 px-5 py-3 text-sm font-extrabold text-white transition hover:border-white hover:bg-white/10">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                    {{ $phone }}
                </a>
            @endif
        </div>
    </div>
</header>

{{-- ═══════════════════════════════════════════════════════════════
     CONTENU PRINCIPAL + SIDEBAR
     ═══════════════════════════════════════════════════════════════ --}}
<main class="bg-slate-50/40 py-10 sm:py-14">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1fr_320px] xl:grid-cols-[1fr_360px]">

            {{-- ── Contenu principal ─────────────────────────── --}}
            <div>
                @if ($hasContent)
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
                        <div class="px-6 py-8 sm:px-10 sm:py-10">
                            <div class="prose prose-slate max-w-none
                                        prose-headings:font-extrabold prose-headings:text-brand-dark
                                        prose-h2:text-2xl prose-h3:text-xl
                                        prose-a:text-brand-blue prose-a:no-underline hover:prose-a:underline
                                        prose-strong:text-brand-dark
                                        prose-img:rounded-2xl prose-img:shadow-soft
                                        prose-blockquote:border-l-4 prose-blockquote:border-brand-blue prose-blockquote:text-slate-600">
                                {!! $page->content_html !!}
                            </div>
                        </div>
                    </article>
                @else
                    {{-- Pas encore de contenu : afficher intro contextuelle --}}
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-soft sm:p-10">
                        <p class="text-[11px] font-extrabold uppercase tracking-widest text-brand-blue">À propos</p>
                        <h2 class="mt-2 text-2xl font-extrabold text-brand-dark sm:text-3xl">
                            {{ $svcLabel ?? 'Rénovation énergétique' }}@if ($city) à {{ $city }}@endif
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">
                            Normes Rénovation est votre expert local certifié RGE en
                            {{ $svcLabel ? mb_strtolower($svcLabel) : 'rénovation énergétique' }}
                            @if ($city) à {{ $city }} et dans tout le secteur@endif.
                            Notre équipe réalise vos travaux dans les règles de l'art, avec des matériaux de qualité et dans le respect des délais.
                        </p>
                        <p class="mt-3 text-base leading-relaxed text-slate-600">
                            Profitez des aides de l'État disponibles en 2025 — MaPrimeRénov', CEE, éco-PTZ — pour financer jusqu'à 70% de vos travaux. Nous montons votre dossier gratuitement.
                        </p>
                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['🏆', 'Certifié RGE', 'Qualification officielle'],
                                ['⭐', '5/5 sur Google', 'Avis clients vérifiés'],
                                ['🏠', '+5 000 chantiers', 'Expérience terrain'],
                                ['💶', 'Devis gratuit', 'Réponse sous 48h'],
                            ] as [$ico, $t, $s])
                                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                                    <span class="text-2xl" aria-hidden="true">{{ $ico }}</span>
                                    <div>
                                        <p class="text-sm font-extrabold text-brand-dark">{{ $t }}</p>
                                        <p class="text-xs text-slate-500">{{ $s }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- FAQ contextuelle --}}
                @if (!empty($faqItems))
                    <section class="mt-8" aria-labelledby="faq-show-heading">
                        <h2 id="faq-show-heading" class="mb-5 text-2xl font-extrabold text-brand-dark">
                            Questions <span class="text-brand-blue">fréquentes</span>
                        </h2>
                        <div class="space-y-3" itemscope itemtype="https://schema.org/FAQPage">
                            @foreach ($faqItems as $faq)
                                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                                     itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <button type="button" class="faq-btn flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-slate-50">
                                        <span class="text-sm font-extrabold text-brand-dark" itemprop="name">{{ $faq['q'] }}</span>
                                        <svg class="faq-chevron h-5 w-5 shrink-0 text-brand-blue transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                    </button>
                                    <div class="faq-body hidden border-t border-slate-100 px-5 py-4"
                                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                        <p class="text-sm leading-relaxed text-slate-600" itemprop="text">{{ $faq['a'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- ── Sidebar CTA (sticky desktop) ─────────────── --}}
            <aside class="space-y-5" aria-label="Actions rapides">
                <div class="sticky top-24 space-y-5">

                    {{-- Devis rapide --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
                        <div class="bg-brand-dark px-5 py-4">
                            <p class="text-[10px] font-extrabold uppercase tracking-widest text-brand-yellow">Gratuit & sans engagement</p>
                            <p class="mt-0.5 text-lg font-black text-white">Votre devis en 48h</p>
                        </div>
                        <div class="space-y-2 p-5">
                            <a href="#devis"
                               class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-yellow px-4 py-3.5 text-sm font-extrabold text-brand-dark shadow transition hover:-translate-y-0.5 hover:bg-yellow-300">
                                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/></svg>
                                Demander un devis gratuit
                            </a>
                            @if ($phone !== '')
                                <a href="{{ $phoneHref }}"
                                   class="flex w-full items-center justify-center gap-2 rounded-xl border-2 border-brand-dark px-4 py-3 text-sm font-extrabold text-brand-dark transition hover:bg-brand-dark hover:text-white">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                                    {{ $phone }}
                                </a>
                            @endif
                            <a href="/simulateur"
                               class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-blue/10 px-4 py-3 text-sm font-extrabold text-brand-blue transition hover:bg-brand-blue hover:text-white">
                                Simulateur de devis →
                            </a>
                        </div>
                    </div>

                    {{-- Confiance --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                        <p class="mb-4 text-xs font-extrabold uppercase tracking-widest text-slate-400">Pourquoi nous choisir</p>
                        <ul class="space-y-3 text-sm">
                            @foreach ([
                                ['🏆', 'Certifié RGE', 'Ouvre droit aux aides de l\'État'],
                                ['⭐', '5/5 sur Google', '+98 avis clients vérifiés'],
                                ['🛡️', 'Garantie décennale', 'Travaux protégés 10 ans'],
                                ['⚡', 'Réponse sous 48h', 'Devis gratuit & rapide'],
                                ['💶', 'MaPrimeRénov\'', 'Jusqu\'à 70% de financement'],
                            ] as [$ico, $t, $s])
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 text-lg leading-none" aria-hidden="true">{{ $ico }}</span>
                                    <div>
                                        <p class="font-extrabold text-brand-dark">{{ $t }}</p>
                                        <p class="text-xs text-slate-500">{{ $s }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Services --}}
                    @if (!empty($serviceCards))
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                            <p class="mb-3 text-xs font-extrabold uppercase tracking-widest text-slate-400">Nos services</p>
                            <ul class="space-y-1">
                                @foreach (array_slice($serviceCards, 0, 5) as $svc)
                                    @php $href = trim((string) data_get($svc, 'href', '#devis')); @endphp
                                    <li>
                                        <a href="{{ $href }}"
                                           class="flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue">
                                            {{ data_get($svc, 'title') }}
                                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="/services" class="mt-3 flex items-center justify-center gap-1 text-xs font-bold text-brand-blue hover:underline">
                                Voir tous nos services
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</main>

@include('home.services', ['home' => $h])
@include('home.avis', ['home' => $h])
@include('home.devis', ['home' => $h])
@include('home.footer', ['home' => $h])
@include('home.popup_simulateur', ['home' => $h])
@include('home.cookie_consent', ['home' => $h])
@include('home.countup_script')
@include('home.scripts', ['home' => $h])

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": ["LocalBusiness","ProfessionalService"],
      "@id": "{{ url('/') }}#business",
      "name": "Normes Rénovation",
      "url": "{{ url('/') }}"
      @if ($phone !== ''),"telephone": "{{ $phone }}"@endif
    },
    {
      "@type": "Article",
      "headline": {{ json_encode($h1Text) }},
      @if ($excerpt !== '')"description": {{ json_encode($excerpt) }},@endif
      "url": "{{ $canonicalUrl }}",
      "publisher": { "@type": "Organization", "name": "Normes Rénovation", "url": "{{ url('/') }}" },
      "dateModified": "{{ $page->updated_at?->toIso8601String() ?? now()->toIso8601String() }}"
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ url('/') }}" }
        @if ($svcLabel),{ "@type": "ListItem", "position": 2, "name": {{ json_encode($svcLabel) }}, "item": "{{ $canonicalUrl }}" }@endif
        ,{ "@type": "ListItem", "position": {{ $svcLabel ? 3 : 2 }}, "name": {{ json_encode($h1Text) }}, "item": "{{ $canonicalUrl }}" }
      ]
    }
    @if (!empty($faqItems))
    ,{ "@type": "FAQPage", "mainEntity": [
      @foreach ($faqItems as $faq)
      { "@type": "Question", "name": {{ json_encode($faq['q']) }}, "acceptedAnswer": { "@type": "Answer", "text": {{ json_encode($faq['a']) }} } }{{ !$loop->last ? ',' : '' }}
      @endforeach
    ]}
    @endif
  ]
}
</script>
<script>
document.querySelectorAll('.faq-btn').forEach(function(btn){
    btn.addEventListener('click',function(){
        var b=this.nextElementSibling,c=this.querySelector('.faq-chevron'),o=!b.classList.contains('hidden');
        b.classList.toggle('hidden',o);c.style.transform=o?'':'rotate(180deg)';
        this.setAttribute('aria-expanded',String(!o));
    });btn.setAttribute('aria-expanded','false');
});
</script>
</body>
</html>
