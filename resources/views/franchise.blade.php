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

    $brochurePdf = trim((string) data_get($fp, 'brochure_pdf', ''));
    $brochureLabel = trim((string) data_get($fp, 'brochure_label', 'Télécharger la brochure franchise'));

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

    $pillarGradients = [
        'from-sky-500 to-blue-600',
        'from-amber-400 to-orange-500',
        'from-emerald-500 to-teal-600',
        'from-violet-500 to-purple-600',
        'from-rose-500 to-pink-600',
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
<body class="overflow-x-hidden bg-slate-900 font-sans text-brand-dark antialiased">
<a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[2000] focus:rounded-xl focus:bg-white focus:px-4 focus:py-3 focus:text-sm focus:font-extrabold focus:text-brand-dark focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-blue">Aller au contenu</a>
@include('home.header', ['home' => $h])

{{-- ═══ HERO ═══ --}}
<section id="top" class="relative min-h-[520px] overflow-hidden sm:min-h-[580px] lg:min-h-[640px]">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}');" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-brand-dark/70 to-brand-blue/30" aria-hidden="true"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 80%, rgba(56,189,248,.4) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(250,204,21,.3) 0%, transparent 50%);" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[520px] w-[95%] flex-col justify-end gap-5 px-4 py-10 sm:min-h-[580px] sm:px-6 sm:py-14 lg:min-h-[640px] lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-7 shadow-2xl backdrop-blur-xl sm:p-10">
                @if ($heroKicker !== '')
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-brand-yellow/20 px-4 py-1.5 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
                        {{ $heroKicker }}
                    </p>
                @endif
                <h1 class="mb-5 text-3xl font-black leading-[1.05] tracking-tight sm:text-4xl lg:text-5xl xl:text-6xl">
                    <span>{{ $heroH1Line1 }}</span>
                    @if ($heroH1Accent !== '')
                        <br><span class="bg-gradient-to-r from-brand-blue to-sky-400 bg-clip-text text-transparent">{{ $heroH1Accent }}</span>
                    @endif
                </h1>
                @if ($heroIntro !== '')
                    <p class="max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">{{ $heroIntro }}</p>
                @endif
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#candidature" class="rounded-xl bg-gradient-to-r from-brand-blue to-sky-500 px-6 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-brand-blue/25 transition hover:shadow-xl hover:shadow-brand-blue/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        {{ $heroCtaPrimary }}
                    </a>
                    <a href="{{ $agencesHref }}" class="rounded-xl bg-brand-yellow px-6 py-3.5 text-sm font-extrabold text-brand-dark shadow-lg shadow-brand-yellow/20 transition hover:bg-yellow-300 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark">
                        {{ $heroCtaSecondary }}
                    </a>
                    @if ($brochurePdf !== '')
                        <a href="{{ $brochurePdf }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-6 py-3.5 text-sm font-extrabold text-white backdrop-blur-sm transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            {{ $brochureLabel }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<main id="contenu" class="scroll-mt-24">

    {{-- ═══ PILIERS ═══ --}}
    @if ($pillars !== [])
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-900 to-slate-800 py-20 sm:py-24" aria-labelledby="pourquoi-heading">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 50% 0%, rgba(56,189,248,.25) 0%, transparent 60%);" aria-hidden="true"></div>
        <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                @if ($pillarsKicker !== '')
                    <p id="pourquoi-heading" class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-blue">{{ $pillarsKicker }}</p>
                @endif
                @if ($pillarsTitle !== '')
                    <h2 class="mt-3 text-2xl font-black tracking-tight text-white sm:text-3xl lg:text-4xl">{{ $pillarsTitle }}</h2>
                @endif
                @if ($pillarsSubtitle !== '')
                    <p class="mt-4 text-base text-slate-400 sm:text-lg">{{ $pillarsSubtitle }}</p>
                @endif
            </div>
            <ul class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @foreach ($pillars as $idx => $pillar)
                    @php
                        $iconKey = trim((string) data_get($pillar, 'icon', ''));
                        $iconSvg = $iconMap[$iconKey] ?? $iconMap['shield-check'];
                        $gradient = $pillarGradients[$idx % count($pillarGradients)];
                    @endphp
                    <li class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm transition hover:-translate-y-1 hover:border-white/20 hover:bg-white/10">
                        <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-gradient-to-br {{ $gradient }} opacity-20 blur-xl transition group-hover:opacity-40" aria-hidden="true"></div>
                        <span class="relative inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br {{ $gradient }} shadow-lg transition group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-white">{!! $iconSvg !!}</svg>
                        </span>
                        <h3 class="relative mt-4 text-base font-extrabold text-white">{{ data_get($pillar, 'title', '') }}</h3>
                        <p class="relative mt-2 text-sm leading-relaxed text-slate-400">{{ data_get($pillar, 'text', '') }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif

    {{-- ═══ IMPLANTATION + CHIFFRES ═══ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-blue via-sky-600 to-blue-700 py-20 sm:py-24" aria-labelledby="implantation-heading">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 0% 100%, rgba(250,204,21,.4) 0%, transparent 50%), radial-gradient(circle at 100% 0%, rgba(255,255,255,.15) 0%, transparent 50%);" aria-hidden="true"></div>
        <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-16">
                <div>
                    <h2 id="implantation-heading" class="text-2xl font-black tracking-tight text-white sm:text-3xl lg:text-4xl">
                        {{ $implTitle1 }} <span class="text-brand-yellow">{{ $implAccent1 }}</span> et <span class="text-brand-yellow">{{ $implAccent2 }}</span>
                    </h2>
                    @if ($implText !== '')
                        <p class="mt-5 text-base leading-relaxed text-white/80 lg:text-lg">{{ $implText }}</p>
                    @endif
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ $agencesHref }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-extrabold text-brand-blue shadow-lg transition hover:bg-slate-50 hover:shadow-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            {{ $implCta }}
                        </a>
                        @if ($brochurePdf !== '')
                            <a href="{{ $brochurePdf }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 px-6 py-3 text-sm font-extrabold text-white transition hover:border-white/60 hover:bg-white/10">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                {{ $brochureLabel }}
                            </a>
                        @endif
                    </div>
                </div>
                @if ($stats !== [])
                    <div class="grid gap-4 sm:grid-cols-3">
                        @foreach ($stats as $idx => $stat)
                            <div class="group rounded-2xl border border-white/15 bg-white/10 p-6 text-center backdrop-blur-sm transition hover:bg-white/20">
                                <p class="text-3xl font-black text-brand-yellow transition group-hover:scale-110" data-countup="{{ data_get($stat, 'value', '') }}">0</p>
                                <p class="mt-1 text-xs font-extrabold uppercase tracking-wide text-white/70">{{ data_get($stat, 'label', '') }}</p>
                                <p class="mt-2 text-sm text-white/60">{{ data_get($stat, 'text', '') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ RÉSEAU FRANCHISÉS ═══ --}}
    @if ($networkItems !== [])
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white py-20 sm:py-24" aria-labelledby="franchises-heading">
        <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-brand-blue via-brand-yellow to-brand-blue" aria-hidden="true"></div>
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 id="franchises-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl lg:text-4xl">{{ $networkTitle }}</h2>
                @if ($networkIntro !== '')
                    <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">{{ $networkIntro }}</p>
                @endif
            </div>
            <ul class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $cardBgs = [
                        'from-sky-500 to-blue-600',
                        'from-amber-400 to-orange-500',
                        'from-emerald-500 to-teal-600',
                        'from-violet-500 to-purple-600',
                    ];
                @endphp
                @foreach ($networkItems as $idx => $item)
                    @php $bg = $cardBgs[$idx % count($cardBgs)]; @endphp
                    <li class="group relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $bg }} p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                        <span class="absolute -right-3 -top-3 text-[4.5rem] font-black leading-none text-white/10" data-countup="{{ $idx + 1 }}" data-countup-pad="2">0</span>
                        <div class="relative">
                            <h3 class="text-base font-extrabold text-white">{{ data_get($item, 'title', '') }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-white/80">{{ data_get($item, 'text', '') }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            
        </div>
    </section>
    @endif

    {{-- ═══ ÉTAPES TIMELINE ═══ --}}
    @if ($steps !== [])
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-800 to-slate-900 py-20 sm:py-24" aria-labelledby="etapes-heading">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 80 80%22 width=%2280%22 height=%2280%22><circle cx=%2240%22 cy=%2240%22 r=%221%22 fill=%22%23ffffff%22/></svg>');" aria-hidden="true"></div>
        <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 id="etapes-heading" class="text-2xl font-black tracking-tight text-white sm:text-3xl lg:text-4xl">{{ $stepsTitle }}</h2>
                @if ($stepsSubtitle !== '')
                    <p class="mt-3 text-base text-slate-400 sm:text-lg">{{ $stepsSubtitle }}</p>
                @endif
            </div>
            <ol class="relative mx-auto mt-14 max-w-4xl">
                <div class="absolute left-6 top-0 hidden h-full w-0.5 bg-gradient-to-b from-brand-blue via-brand-yellow to-brand-blue sm:block" aria-hidden="true"></div>
                @foreach ($steps as $idx => $step)
                    @php $isEven = $idx % 2 === 0; @endphp
                    <li class="relative mb-10 pl-0 sm:pl-16 last:mb-0">
                        <span class="absolute left-0 top-0 hidden h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br {{ $isEven ? 'from-brand-blue to-sky-500' : 'from-brand-yellow to-amber-400' }} text-sm font-black {{ $isEven ? 'text-white' : 'text-brand-dark' }} shadow-lg sm:inline-flex" data-countup="{{ $idx + 1 }}">0</span>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm transition hover:border-white/20 hover:bg-white/10 sm:p-7">
                            <span class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br {{ $isEven ? 'from-brand-blue to-sky-500' : 'from-brand-yellow to-amber-400' }} text-xs font-black {{ $isEven ? 'text-white' : 'text-brand-dark' }} sm:hidden" data-countup="{{ $idx + 1 }}">0</span>
                            <h3 class="text-base font-extrabold text-white sm:text-lg">{{ data_get($step, 'title', '') }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-400 sm:text-base">{{ data_get($step, 'text', '') }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
    @endif

    {{-- ═══ FAQ + CLIENTS SATISFAITS ═══ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-sky-50 via-white to-amber-50 py-20 sm:py-24" aria-labelledby="faq-heading">
        <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-brand-yellow via-brand-blue to-brand-yellow" aria-hidden="true"></div>
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[1.4fr_1fr] lg:items-stretch">

                {{-- ── Colonne 1 : FAQ ── --}}
                <div class="flex min-w-0 flex-col">
                    <h2 id="faq-heading" class="text-2xl font-black tracking-tight text-brand-dark sm:text-3xl">{{ $faqTitle }}</h2>
                    @if ($faqItems !== [])
                        <div class="mt-6 flex-1 divide-y divide-slate-200 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md">
                            @foreach ($faqItems as $item)
                                <details class="group">
                                    <summary class="flex cursor-pointer items-center justify-between gap-3 px-5 py-4 text-left text-sm font-extrabold text-brand-dark transition hover:bg-sky-50 [&::-webkit-details-marker]:hidden">
                                        <span>{{ data_get($item, 'q', '') }}</span>
                                        <svg class="h-4 w-4 shrink-0 text-brand-blue transition group-open:rotate-45" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    </summary>
                                    <div class="bg-sky-50/50 px-5 pb-4 text-sm leading-relaxed text-slate-600">{{ data_get($item, 'a', '') }}</div>
                                </details>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- ── Colonne 2 : Card « Clients satisfaits » + lien Google ── --}}
                <div class="flex min-w-0 flex-col gap-4">
                    <a href="{{ data_get($h, 'avis.google_url', '#') }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex w-fit items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-brand-blue/40 hover:text-brand-blue hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        {{ data_get($h, 'avis.google_button', 'Voir nos avis Google') }}
                    </a>
                    <div class="relative flex-1 overflow-hidden rounded-2xl shadow-xl">
                        <img
                            src="{{ \App\Support\HomeView::url('/nous/equipe.jpeg') }}"
                            alt="Équipe Normes & Rénovation"
                            class="absolute inset-0 h-full w-full object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/50 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                            <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">Clients satisfaits</p>
                            <h3 class="mt-2 text-xl font-extrabold leading-tight text-white sm:text-2xl">
                                Une équipe au top pour des clients satisfaits.
                            </h3>
                        </div>
                        <div class="relative min-h-[320px]"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ FORMULAIRE CANDIDATURE ═══ --}}
    <section id="candidature" class="relative scroll-mt-24 overflow-hidden bg-gradient-to-br from-slate-900 via-brand-dark to-slate-800 py-20 text-white sm:py-24">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 30% 70%, rgba(56,189,248,.3) 0%, transparent 50%), radial-gradient(circle at 80% 30%, rgba(250,204,21,.2) 0%, transparent 50%);" aria-hidden="true"></div>
        <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-[1fr_1.15fr] lg:gap-16">
                <div class="flex flex-col justify-center">
                    @if ($formKicker !== '')
                        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">{{ $formKicker }}</p>
                    @endif
                    <h2 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                        <span class="bg-gradient-to-r from-brand-blue to-sky-400 bg-clip-text text-transparent">{{ $formTitle }}</span>
                    </h2>
                    @if ($formIntro !== '')
                        <p class="mt-4 text-sm leading-relaxed text-white/80 sm:text-base">{{ $formIntro }}</p>
                    @endif

                    @if ($brochurePdf !== '')
                        <a href="{{ $brochurePdf }}" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex w-fit items-center gap-3 rounded-2xl border border-white/15 bg-white/5 p-5 backdrop-blur-sm transition hover:border-white/30 hover:bg-white/10">
                            <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-extrabold text-white">{{ $brochureLabel }}</p>
                                <p class="text-xs text-white/60">PDF — Informations complètes sur la franchise</p>
                            </div>
                        </a>
                    @endif

                    <div class="mt-8 space-y-5 rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">Adresse</p>
                            <p class="mt-1 text-sm text-white/80">{{ $hqAddress }}</p>
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

                <div class="rounded-2xl border border-white/20 bg-white p-6 text-brand-dark shadow-2xl sm:p-8">
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
                        @include('partials.form_spam_shield', ['form' => 'franchise'])
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
                                <input id="fr_cp" name="postal_code" type="text" inputmode="numeric" maxlength="5" pattern="[0-9]{5}" autocomplete="postal-code" value="{{ old('postal_code') }}" required class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm transition focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
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
                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-brand-blue to-sky-500 px-4 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-brand-blue/25 transition hover:shadow-xl sm:text-base">
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

@include('home.countup_script')

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
