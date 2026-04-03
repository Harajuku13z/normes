@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $fp = data_get($h, 'franchise_page', []);
    if (! is_array($fp)) { $fp = []; }
    $f = data_get($h, 'footer', []);
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');

    $metaTitle = trim((string) data_get($fp, 'meta_title', ''));
    if ($metaTitle === '') { $metaTitle = 'Franchise | Devenez franchisé | '.$siteName; }
    $metaDescription = trim((string) data_get($fp, 'meta_description', 'Devenez franchisé Normes Rénovation.'));
    $metaKeywords = trim((string) data_get($fp, 'meta_keywords', ''));
    $ogImageRaw = trim((string) data_get($fp, 'og_image', ''));
    $ogImage = $ogImageRaw !== '' ? $ogImageRaw : trim((string) data_get($h, 'meta.og_image', 'logo.png'));
    $canonicalUrl = route('franchise.page');

    $heroBgRaw = trim((string) data_get($fp, 'hero_bg', ''));
    $heroBg = HomeView::url($heroBgRaw !== '' ? $heroBgRaw : (string) data_get($h, 'styles.footer_bg', 'slide/toiture.png'));
    $preloadImages = [$heroBg];
    $agencesHref = route('home', [], false).'#agences';

    $heroKicker = trim((string) data_get($fp, 'hero_kicker', 'Franchise 100 % rentable'));
    $heroH1Line1 = trim((string) data_get($fp, 'hero_h1_line1', 'Devenez franchisé'));
    $heroH1Accent = trim((string) data_get($fp, 'hero_h1_accent', 'Normes Rénovation'));
    $heroIntro = trim((string) data_get($fp, 'hero_intro', ''));
    $heroCtaPrimary = trim((string) data_get($fp, 'hero_cta_primary', 'Commencer mon dossier'));
    $heroCtaSecondary = trim((string) data_get($fp, 'hero_cta_secondary', 'Voir nos agences'));

    $pillarsKicker = trim((string) data_get($fp, 'pillars_kicker', 'Pourquoi ?'));
    $pillarsTitle = trim((string) data_get($fp, 'pillars_title', 'Pourquoi choisir Normes Rénovation ?'));
    $pillarsSubtitle = trim((string) data_get($fp, 'pillars_subtitle', ''));
    $pillars = (array) data_get($fp, 'pillars', []);

    $implTitle1 = trim((string) data_get($fp, 'implantation_title_line1', 'Déjà présents en'));
    $implAccent1 = trim((string) data_get($fp, 'implantation_title_accent1', 'Bourgogne'));
    $implAccent2 = trim((string) data_get($fp, 'implantation_title_accent2', 'Bretagne'));
    $implText = trim((string) data_get($fp, 'implantation_text', ''));
    $implCta = trim((string) data_get($fp, 'implantation_cta', 'Voir nos agences'));
    $stats = (array) data_get($fp, 'stats', []);

    $networkTitle = trim((string) data_get($fp, 'network_title', 'Nos franchisés'));
    $networkIntro = trim((string) data_get($fp, 'network_intro', ''));
    $networkItems = (array) data_get($fp, 'network_items', []);
    $testimonialText = trim((string) data_get($fp, 'testimonial_text', ''));
    $testimonialAuthor = trim((string) data_get($fp, 'testimonial_author', ''));

    $stepsTitle = trim((string) data_get($fp, 'steps_title', 'Comment faire ?'));
    $stepsSubtitle = trim((string) data_get($fp, 'steps_subtitle', 'Les étapes pour nous rejoindre'));
    $steps = (array) data_get($fp, 'steps', []);

    $faqTitle = trim((string) data_get($fp, 'faq_title', 'Ce qu\'il faut savoir (F.A.Q.)'));
    $faqItems = (array) data_get($fp, 'faq', []);

    $formKicker = trim((string) data_get($fp, 'form_kicker', 'C\'est à vous'));
    $formTitle = trim((string) data_get($fp, 'form_title', 'Commencer votre dossier'));
    $formIntro = trim((string) data_get($fp, 'form_intro', ''));
    $formSubmit = trim((string) data_get($fp, 'form_submit', 'Envoyer ma candidature'));
    $formRgpd = trim((string) data_get($fp, 'form_rgpd', ''));

    $footerEmail = trim((string) data_get($f, 'email', 'bourgogne-agence@normesrenovation.fr'));
    $footerPhone = trim((string) data_get($f, 'phone', '03 85 41 98 86'));
    $footerPhoneHref = trim((string) data_get($f, 'phone_href', 'tel:+33385419886'));
    $hqLines = data_get($f, 'address_lines', []);
    if (! is_array($hqLines)) { $hqLines = []; }
    $hqAddress = $hqLines !== [] ? implode(', ', array_map('strval', $hqLines)) : '6 rue Pierre de Coubertin, 71100 Chalon-sur-Saône';

    $iconMap = [
        'shield-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>',
        'academic-cap' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>',
        'arrow-trending-up' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>',
        'light-bulb' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>',
        'user-group' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
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
    'preloadImages' => $preloadImages,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
<a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[2000] focus:rounded-xl focus:bg-white focus:px-4 focus:py-3 focus:text-sm focus:font-extrabold focus:text-brand-dark focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-blue">Aller au contenu</a>
@include('home.header', ['home' => $h])

{{-- ═══ HERO ═══ --}}
<section id="top" class="relative min-h-[440px] overflow-hidden sm:min-h-[500px]">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}');" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[440px] w-[95%] flex-col justify-end gap-5 px-4 py-8 sm:min-h-[500px] sm:px-6 sm:py-10 lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                @if ($heroKicker !== '')
                    <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">{{ $heroKicker }}</p>
                @endif
                <h1 class="mb-4 text-2xl font-black leading-[1.06] tracking-tight drop-shadow-md sm:text-4xl lg:text-5xl">
                    <span>{{ $heroH1Line1 }}</span>
                    @if ($heroH1Accent !== '')
                        <span class="text-brand-blue"> {{ $heroH1Accent }}</span>
                    @endif
                </h1>
                @if ($heroIntro !== '')
                    <p class="max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">{{ $heroIntro }}</p>
                @endif
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#candidature" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        {{ $heroCtaPrimary }}
                    </a>
                    <a href="{{ $agencesHref }}" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        {{ $heroCtaSecondary }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">

    {{-- ═══ PILIERS ═══ --}}
    @if ($pillars !== [])
    <section class="border-b border-slate-200 bg-white py-16 sm:py-20" aria-labelledby="pourquoi-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                @if ($pillarsKicker !== '')
                    <p id="pourquoi-heading" class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">{{ $pillarsKicker }}</p>
                @endif
                @if ($pillarsTitle !== '')
                    <h2 class="mt-3 text-2xl font-black tracking-tight text-brand-dark sm:text-3xl lg:text-4xl">{{ $pillarsTitle }}</h2>
                @endif
                @if ($pillarsSubtitle !== '')
                    <p class="mt-4 text-base text-slate-600 sm:text-lg">{{ $pillarsSubtitle }}</p>
                @endif
            </div>
            <ul class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @foreach ($pillars as $idx => $pillar)
                    @php
                        $iconKey = trim((string) data_get($pillar, 'icon', ''));
                        $iconSvg = $iconMap[$iconKey] ?? $iconMap['shield-check'];
                        $colors = ['bg-sky-50 text-brand-blue', 'bg-amber-50 text-amber-600', 'bg-emerald-50 text-emerald-600', 'bg-violet-50 text-violet-600', 'bg-rose-50 text-rose-600'];
                        $color = $colors[$idx % count($colors)];
                    @endphp
                    <li class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl {{ $color }} transition group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">{!! $iconSvg !!}</svg>
                        </span>
                        <h3 class="mt-4 text-base font-extrabold text-brand-dark">{{ data_get($pillar, 'title', '') }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ data_get($pillar, 'text', '') }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif

    {{-- ═══ IMPLANTATION + CHIFFRES ═══ --}}
    <section class="bg-slate-50 py-16 sm:py-20" aria-labelledby="implantation-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-16">
                <div>
                    <h2 id="implantation-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl lg:text-4xl">
                        {{ $implTitle1 }} <span class="text-brand-blue">{{ $implAccent1 }}</span> et <span class="text-brand-blue">{{ $implAccent2 }}</span>
                    </h2>
                    @if ($implText !== '')
                        <p class="mt-5 text-base leading-relaxed text-slate-600 lg:text-lg">{{ $implText }}</p>
                    @endif
                    <a href="{{ $agencesHref }}" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-brand-dark px-5 py-3 text-sm font-extrabold text-white shadow-md transition hover:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        {{ $implCta }}
                    </a>
                </div>
                @if ($stats !== [])
                    <div class="grid gap-4 sm:grid-cols-3">
                        @foreach ($stats as $stat)
                            <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm transition hover:shadow-md">
                                <p class="text-3xl font-black text-brand-blue">{{ data_get($stat, 'value', '') }}</p>
                                <p class="mt-1 text-xs font-extrabold uppercase tracking-wide text-slate-500">{{ data_get($stat, 'label', '') }}</p>
                                <p class="mt-2 text-sm text-slate-600">{{ data_get($stat, 'text', '') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ RÉSEAU FRANCHISÉS ═══ --}}
    @if ($networkItems !== [])
    <section class="bg-white py-16 sm:py-20" aria-labelledby="franchises-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 id="franchises-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl lg:text-4xl">{{ $networkTitle }}</h2>
                @if ($networkIntro !== '')
                    <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">{{ $networkIntro }}</p>
                @endif
            </div>
            <ul class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($networkItems as $idx => $item)
                    <li class="relative overflow-hidden rounded-2xl border border-slate-200/80 bg-gradient-to-br from-slate-50 to-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <span class="absolute -right-2 -top-2 text-[4rem] font-black leading-none text-slate-100/60">{{ $idx + 1 }}</span>
                        <div class="relative">
                            <h3 class="text-base font-extrabold text-brand-dark">{{ data_get($item, 'title', '') }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ data_get($item, 'text', '') }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($testimonialText !== '')
                <figure class="mx-auto mt-14 max-w-3xl rounded-2xl border border-brand-blue/15 bg-gradient-to-br from-sky-50/60 to-white p-8 shadow-sm sm:p-10">
                    <svg class="mb-4 h-8 w-8 text-brand-blue/30" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>
                    <blockquote class="text-lg font-medium leading-relaxed text-brand-dark">{{ $testimonialText }}</blockquote>
                    @if ($testimonialAuthor !== '')
                        <figcaption class="mt-5 text-sm font-bold text-brand-blue">{{ $testimonialAuthor }}</figcaption>
                    @endif
                </figure>
            @endif
        </div>
    </section>
    @endif

    {{-- ═══ ÉTAPES TIMELINE ═══ --}}
    @if ($steps !== [])
    <section class="border-t border-slate-200 bg-slate-50 py-16 sm:py-20" aria-labelledby="etapes-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 id="etapes-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl lg:text-4xl">{{ $stepsTitle }}</h2>
                @if ($stepsSubtitle !== '')
                    <p class="mt-3 text-base text-slate-600 sm:text-lg">{{ $stepsSubtitle }}</p>
                @endif
            </div>
            <ol class="relative mx-auto mt-14 max-w-4xl">
                <div class="absolute left-6 top-0 hidden h-full w-0.5 bg-gradient-to-b from-brand-blue via-brand-blue/40 to-slate-200 sm:block" aria-hidden="true"></div>
                @foreach ($steps as $idx => $step)
                    <li class="relative mb-10 pl-0 sm:pl-16 last:mb-0">
                        <span class="absolute left-0 top-0 hidden h-12 w-12 items-center justify-center rounded-full border-4 border-white bg-brand-blue text-sm font-black text-white shadow-md sm:inline-flex">{{ $idx + 1 }}</span>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md sm:p-7">
                            <span class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-yellow text-xs font-black text-brand-dark sm:hidden">{{ $idx + 1 }}</span>
                            <h3 class="text-base font-extrabold text-brand-dark sm:text-lg">{{ data_get($step, 'title', '') }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">{{ data_get($step, 'text', '') }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
    @endif

    {{-- ═══ FAQ + AVIS (section unique 3 colonnes) ═══ --}}
    @php
        $testimonials = collect((array) data_get($h, 'avis.testimonials', []))
            ->filter(fn ($t) => is_array($t))
            ->take(5)
            ->values()
            ->all();
    @endphp
    <section id="avis-clients" class="border-t border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-16 sm:py-20" aria-labelledby="faq-heading">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3 lg:items-stretch">

                {{-- ── Colonne 1 : FAQ ── --}}
                <div class="flex min-w-0 flex-col">
                    <h2 id="faq-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">{{ $faqTitle }}</h2>
                    @if ($faqItems !== [])
                        <div class="mt-6 flex-1 divide-y divide-slate-200 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            @foreach ($faqItems as $item)
                                <details class="group">
                                    <summary class="flex cursor-pointer items-center justify-between gap-3 px-5 py-4 text-left text-sm font-extrabold text-brand-dark transition hover:bg-slate-50 [&::-webkit-details-marker]:hidden">
                                        <span>{{ data_get($item, 'q', '') }}</span>
                                        <svg class="h-4 w-4 shrink-0 text-slate-400 transition group-open:rotate-45" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    </summary>
                                    <div class="px-5 pb-4 text-sm leading-relaxed text-slate-600">{{ data_get($item, 'a', '') }}</div>
                                </details>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- ── Colonne 2 : Carousel avis ── --}}
                <div class="flex min-w-0 flex-col gap-4">
                    <div>
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-brand-blue/10 px-4 py-2 text-xs font-extrabold uppercase tracking-wide text-brand-blue">
                            Avis multi-plateformes
                        </div>
                        <h3 class="break-words text-2xl font-extrabold leading-tight text-brand-dark sm:text-3xl">
                            <span class="text-brand-blue">{{ data_get($h, 'avis.title_accent', 'Avis') }}</span>{{ data_get($h, 'avis.title_rest', 'clients') }}
                        </h3>
                        <p class="mt-2 break-words text-sm text-slate-600">{{ data_get($h, 'avis.intro', '') }}</p>
                        <a href="{{ data_get($h, 'avis.google_url', '#') }}" target="_blank" rel="noopener noreferrer"
                           class="mt-4 inline-flex w-fit items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-brand-blue/40 hover:text-brand-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            {{ data_get($h, 'avis.google_button', 'Voir la fiche') }}
                        </a>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <p class="min-w-0 flex-1 text-xs font-semibold text-slate-500">Des retours concrets, provenant de plusieurs plateformes.</p>
                        <div class="flex shrink-0 gap-1.5">
                            <button id="avisPrev" type="button" aria-label="Avis précédent" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-95">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                            </button>
                            <button id="avisNext" type="button" aria-label="Avis suivant" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-95">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 rounded-2xl border border-slate-200 bg-white">
                        <div id="avisStack" style="display:grid">
                            @foreach ($testimonials as $t)
                                @php
                                    $platform    = (string) data_get($t, 'platform', 'google');
                                    $reviewCount = (string) data_get($t, 'review_count', '+100 avis');
                                    $author      = (string) data_get($t, 'author', '');
                                    $text        = (string) data_get($t, 'text', '');
                                    $countClass  = ($loop->iteration % 2 === 1) ? 'text-brand-blue' : 'text-brand-yellow';
                                @endphp
                                <article class="avis-card w-full p-5" style="grid-area:1/1; opacity:0; pointer-events:none; transition:opacity .45s ease" aria-hidden="true">
                                    <div class="mb-3 flex items-start justify-between gap-3">
                                        <div>
                                            @if ($platform === 'google')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" aria-label="Google">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                                </svg>
                                            @else
                                                <span class="inline-flex h-7 items-center rounded-full bg-slate-100 px-3 text-xs font-extrabold text-brand-blue">{{ $platform }}</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-yellow-500" aria-label="5 sur 5">★★★★★</p>
                                    </div>
                                    <p class="mb-4 break-words text-sm leading-relaxed text-slate-700">{{ $text }}</p>
                                    <div class="flex items-center justify-between gap-3 border-t border-slate-100 pt-3">
                                        <span class="text-xs font-extrabold {{ $countClass }}">{{ $reviewCount }}</span>
                                        <p class="text-sm font-extrabold text-brand-dark">{{ $author }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div id="avisDots" class="flex justify-center gap-2 px-4 pb-3 pt-1">
                            @foreach ($testimonials as $t)
                                <button type="button" data-idx="{{ $loop->index }}" class="avis-dot h-2 w-2 rounded-full bg-slate-200 transition-all duration-300" aria-label="Avis {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ── Colonne 3 : Image « Clients satisfaits » ── --}}
                <div class="relative hidden min-h-[280px] overflow-hidden rounded-2xl lg:block">
                    <img
                        src="{{ \App\Support\HomeView::url('/nous/equipe.jpeg') }}"
                        alt="Équipe Normes & Rénovation"
                        class="absolute inset-0 h-full w-full object-cover"
                        loading="lazy"
                        decoding="async"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/50 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">Clients satisfaits</p>
                        <h3 class="mt-2 text-xl font-extrabold leading-tight text-white sm:text-2xl">
                            Une équipe au top pour des clients satisfaits.
                        </h3>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
    (function () {
        var cards = Array.from(document.querySelectorAll('.avis-card'));
        var dots = Array.from(document.querySelectorAll('.avis-dot'));
        var prev = document.getElementById('avisPrev');
        var next = document.getElementById('avisNext');
        var n = cards.length;
        if (!n) return;
        var current = 0, timer = null;
        var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        function show(idx) {
            current = ((idx % n) + n) % n;
            cards.forEach(function (c, i) { var a = i === current; c.style.opacity = a ? '1' : '0'; c.style.pointerEvents = a ? 'auto' : 'none'; c.setAttribute('aria-hidden', a ? 'false' : 'true'); });
            dots.forEach(function (d, i) { var a = i === current; d.classList.toggle('bg-brand-blue', a); d.classList.toggle('w-6', a); d.classList.toggle('bg-slate-200', !a); d.classList.toggle('w-2', !a); });
        }
        function startAuto() { if (reduced || timer) return; timer = setInterval(function () { show(current + 1); }, 5200); }
        function stopAuto() { if (!timer) return; clearInterval(timer); timer = null; }
        var section = document.getElementById('avis-clients');
        var initialized = false;
        function init() { if (initialized) return; initialized = true; show(0); startAuto(); }
        if (prev) prev.addEventListener('click', function () { stopAuto(); show(current - 1); startAuto(); });
        if (next) next.addEventListener('click', function () { stopAuto(); show(current + 1); startAuto(); });
        dots.forEach(function (d) { d.addEventListener('click', function () { stopAuto(); show(Number(d.dataset.idx)); startAuto(); }); });
        if (section) { section.addEventListener('mouseenter', stopAuto); section.addEventListener('mouseleave', startAuto); }
        if ('IntersectionObserver' in window && section) {
            new IntersectionObserver(function (e, o) { e.forEach(function (entry) { if (entry.isIntersecting) { init(); o.disconnect(); } }); }, { threshold: 0.25 }).observe(section);
        } else { init(); }
    })();
    </script>

    {{-- ═══ FORMULAIRE CANDIDATURE ═══ --}}
    <section id="candidature" class="scroll-mt-24 bg-brand-dark py-16 text-white sm:py-20">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-[1fr_1.15fr] lg:gap-16">
                <div class="flex flex-col justify-center">
                    @if ($formKicker !== '')
                        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">{{ $formKicker }}</p>
                    @endif
                    <h2 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                        <span class="text-brand-blue">{{ $formTitle }}</span>
                    </h2>
                    @if ($formIntro !== '')
                        <p class="mt-4 text-sm leading-relaxed text-white/85 sm:text-base">{{ $formIntro }}</p>
                    @endif
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
                        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900" role="status">
                            <svg class="h-5 w-5 shrink-0 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
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
                                <input id="fr_name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div>
                                <label for="fr_phone" class="mb-1 block text-sm font-semibold">Téléphone <span class="text-red-600">*</span></label>
                                <input id="fr_phone" name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div>
                                <label for="fr_email" class="mb-1 block text-sm font-semibold">E-mail <span class="text-red-600">*</span></label>
                                <input id="fr_email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div>
                                <label for="fr_cp" class="mb-1 block text-sm font-semibold">Code postal <span class="text-red-600">*</span></label>
                                <input id="fr_cp" name="postal_code" type="text" inputmode="numeric" maxlength="10" autocomplete="postal-code" value="{{ old('postal_code') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div>
                                <label for="fr_indep" class="mb-1 block text-sm font-semibold">Activité en indépendant ? <span class="text-red-600">*</span></label>
                                @php $oldIndep = (string) old('has_independent_activity', ''); @endphp
                                <select id="fr_indep" name="has_independent_activity" required class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                                    <option value="" {{ $oldIndep === '' ? 'selected' : '' }}>Sélectionner</option>
                                    <option value="1" {{ in_array($oldIndep, ['1', 'oui', 'yes'], true) ? 'selected' : '' }}>Oui</option>
                                    <option value="0" {{ in_array($oldIndep, ['0', 'non', 'no'], true) ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_sector" class="mb-1 block text-sm font-semibold">Secteur géographique visé <span class="text-red-600">*</span></label>
                                <input id="fr_sector" name="geographic_sector" type="text" value="{{ old('geographic_sector') }}" placeholder="Ville, département ou région" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_apport" class="mb-1 block text-sm font-semibold">Apport personnel envisagé (€)</label>
                                <input id="fr_apport" name="personal_contribution" type="text" value="{{ old('personal_contribution') }}" inputmode="decimal" placeholder="Ex. 30 000" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="fr_msg" class="mb-1 block text-sm font-semibold">Message</label>
                                <textarea id="fr_msg" name="message" rows="4" placeholder="Parlez-nous de votre projet, de votre expérience et de vos disponibilités." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-brand-blue px-4 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 sm:text-base">
                            {{ $formSubmit }}
                        </button>
                        @if ($formRgpd !== '')
                            <p class="text-center text-xs text-slate-500">{{ $formRgpd }}</p>
                        @endif
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
        'isPartOf' => ['@type' => 'WebSite', 'name' => $siteName, 'url' => url('/')],
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Franchise', 'item' => $canonicalUrl],
            ],
        ],
    ];
    $faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($faqItems)->map(fn ($item) => ['@type' => 'Question', 'name' => data_get($item, 'q', ''), 'acceptedAnswer' => ['@type' => 'Answer', 'text' => data_get($item, 'a', '')]])->values()->all()];
@endphp
<script type="application/ld+json">{!! json_encode($franchiseLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@if ($faqItems !== [])
<script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
