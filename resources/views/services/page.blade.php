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
    $hasPeriode = str_contains((string) $page->slug, 'demouss') || str_contains((string) $page->slug, 'démouss');
@endphp

<div class="sticky top-[84px] z-40 border-b border-slate-200/70 bg-white/85 backdrop-blur supports-[backdrop-filter]:bg-white/75">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 py-3" aria-label="Navigation de la page service">
            @if ($hasRole)
                <a href="#role" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-brand-dark transition hover:border-slate-300 hover:bg-slate-50">
                    Rôle
                </a>
            @endif
            @if ($hasPeriode)
                <a href="#periode" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-brand-dark transition hover:border-slate-300 hover:bg-slate-50">
                    Période idéale
                </a>
            @endif
            @if ($hasEtapes)
                <a href="#etapes" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-brand-dark transition hover:border-slate-300 hover:bg-slate-50">
                    Étapes
                </a>
            @endif
            <a href="#cout" class="inline-flex items-center rounded-xl bg-brand-blue px-4 py-2 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                Coût
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

    $realsRaw = is_array($page->realisations ?? null) ? $page->realisations : [];
    $reals = collect($realsRaw)
        ->filter(fn ($c) => is_array($c) && !empty(data_get($c, 'before')) && !empty(data_get($c, 'after')))
        ->values()
        ->all();
@endphp

<section class="scroll-mt-24 bg-slate-50/70 py-12 sm:py-16">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        {{-- Bloc “Découvrez …” (intro + visuel), dans l’esprit Technitoit --}}
        @php
            $discoverTitle = trim((string) ($page->title ?? ''));
            $discoverKicker = 'Découvrez';
            $discoverText = trim((string) ($page->meta_description ?? ''));
            $discoverImage = trim((string) ($page->featured_image ?? ''));
            $discoverImage = $discoverImage !== '' ? HomeView::url($discoverImage) : ($bg ?: HomeView::url('slide/toiture.png'));
        @endphp
        @if ($discoverTitle !== '' && $discoverText !== '')
            <div class="mb-8 grid gap-6 lg:grid-cols-2 lg:items-stretch">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $discoverKicker }}</p>
                    <h2 class="mt-2 break-words text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                        {{ $discoverTitle }}
                    </h2>
                    <p class="mt-3 text-base leading-relaxed text-slate-700 sm:text-lg">
                        {{ $discoverText }}
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ $secondaryHref }}" class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                            Diagnostic gratuit
                        </a>
                        <a href="{{ $secondaryHref }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                            Devis gratuit
                        </a>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 shadow-soft">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $discoverImage }}')" aria-hidden="true"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent" aria-hidden="true"></div>
                </div>
            </div>
        @endif

        @php
            $bodyRaw = trim((string) ($page->body ?? ''));
            $bodyLooksHtml = $bodyRaw !== '' && preg_match('/<[a-z][\s\S]*>/i', $bodyRaw) === 1;
        @endphp

        {{-- Description du service : toujours avant les sous-services --}}
        @if ($bodyRaw !== '' || $hasPeriode)
            <div class="grid gap-6 {{ ($bodyRaw !== '' && $hasPeriode) ? 'lg:grid-cols-2' : '' }}">
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

                @if ($hasPeriode)
                    <div id="periode" class="scroll-mt-32 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
                        <p class="mb-4 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Période idéale</p>
                        <div class="max-w-none text-base leading-relaxed text-slate-700 sm:text-lg">
                            <p class="mb-3">
                                Pour un traitement de démoussage, l’idéal est d’intervenir lorsque les températures sont modérées et que la toiture est sèche, afin d’optimiser l’adhérence et l’efficacité du traitement.
                            </p>
                            <p class="mb-0">
                                Évitez les périodes de gel, de fortes chaleurs et les épisodes très pluvieux. Un diagnostic sur place permet de valider la meilleure fenêtre d’intervention selon votre couverture et l’exposition.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if ($subServices !== [])
            @php
                $sectionHeading = trim((string) ($page->sub_services_section_title ?? ''));
                $accent = 'Sous';
                $rest = 'prestations';
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
                    <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
                        {{ $page->sub_services_section_intro }}
                    </p>
                @endif
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (array_slice($subServices, 0, 9) as $s)
                    @php
                        $title = (string) data_get($s, 'title', '');
                        $sub = trim((string) data_get($s, 'subtitle', ''));
                        $img = HomeView::url((string) data_get($s, 'image', ''));
                    @endphp
                    <article class="service-card relative min-h-[300px] overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 transition hover:-translate-y-0.5 sm:min-h-[320px]">
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
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="scroll-mt-24 bg-white py-14 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="break-words text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                <span class="text-brand-blue">Réalisations</span> avant / après
            </h2>
            <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">Faites glisser le curseur pour comparer.</p>
        </div>

        @if ($reals !== [])
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                                Avant
                            </div>
                            <div class="pointer-events-none absolute right-3 top-3 z-10 rounded-lg bg-brand-blue/85 px-2.5 py-1 text-xs font-extrabold uppercase tracking-wide text-white">
                                Après
                            </div>
                            <input
                                type="range"
                                min="0"
                                max="100"
                                value="50"
                                class="ba-range absolute bottom-3 left-3 right-3 z-20 h-3 w-auto cursor-ew-resize accent-brand-blue"
                                aria-label="Comparer avant et après — {{ $cardLabel }}"
                            >
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-slate-600">
                Aucun chantier avant/après n'a encore été ajouté pour cette page.
            </div>
        @endif
    </div>
</section>

<section class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
    <div id="cout" class="mx-auto w-[95%] scroll-mt-32 px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="min-w-0">
                @include('services.avis_only', ['home' => $h])
            </div>

            @php
                $ctaCardBgPath = trim((string) (data_get($page, 'cta_card_background') ?? ''));
                $ctaCardBg = $ctaCardBgPath !== '' ? HomeView::url($ctaCardBgPath) : HomeView::url('slide/toiture.png');
            @endphp
            <div class="relative h-full min-h-[280px] overflow-hidden rounded-2xl border border-white/20 shadow-soft ring-1 ring-black/5 sm:min-h-[320px]">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ $ctaCardBg }}');"
                    aria-hidden="true"
                ></div>
                <div class="absolute inset-0 bg-gradient-to-br from-brand-dark/90 via-brand-dark/75 to-brand-dark/60" aria-hidden="true"></div>

                <div class="relative z-10 flex min-h-[280px] flex-col p-6 sm:min-h-[320px] sm:p-8">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-yellow">Un projet de rénovation ?</p>
                        <h2 class="mt-2 break-words text-3xl font-extrabold leading-tight text-white sm:text-4xl">
                            Démarrez dès maintenant
                        </h2>
                        <p class="mt-3 text-base leading-relaxed text-slate-100/95">
                            Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.
                        </p>
                    </div>

                    <div class="mt-auto grid gap-3 pt-6 sm:grid-cols-1">
                        <a
                            href="{{ route('home').'#simulateur-devis' }}"
                            class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500"
                        >
                            Ouvrir le simulateur de devis
                        </a>
                        <a
                            href="{{ route('contact.page') }}"
                            class="inline-flex items-center justify-center rounded-xl border-2 border-white/45 bg-white/10 px-5 py-3 text-sm font-extrabold text-white shadow-sm backdrop-blur-sm transition hover:bg-white/20"
                        >
                            Accéder au formulaire de contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.footer', ['home' => $h])

@include('home.scripts', ['home' => $h])
</body>
</html>

