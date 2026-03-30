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
@endphp

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', ['home' => $h])
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
                @if (!empty($page->intro))
                    <p class="text-lg font-semibold text-slate-100/95 drop-shadow sm:text-xl">
                        {{ $page->intro }}
                    </p>
                @endif

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

    $firstReal = $reals[0] ?? null;
    $beforeUrl = $firstReal ? HomeView::url((string) data_get($firstReal, 'before')) : '';
    $afterUrl = $firstReal ? HomeView::url((string) data_get($firstReal, 'after')) : '';
@endphp

<section class="scroll-mt-24 bg-slate-50/70 py-12 sm:py-16">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
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
            <div class="mb-6">
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

        @if (!empty($page->body))
            <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($page->body)) !!}
                </div>
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
            <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
                Faites défiler les chantiers et comparez directement le résultat final.
            </p>
        </div>

        @if ($reals !== [])
            <div class="rounded-3xl border border-slate-200 bg-white p-5 sm:p-6">
                <div class="flex flex-wrap gap-2">
                    @foreach ($reals as $idx => $c)
                        @php
                            $btnLabel = (string) data_get($c, 'label', 'Chantier '.($idx + 1));
                            $isFirst = $idx === 0;
                        @endphp
                        <button
                            type="button"
                            class="ba-case-btn inline-flex items-center justify-center rounded-xl border px-3 py-2 text-sm font-extrabold transition
                                {{ $isFirst ? 'border-brand-dark bg-brand-dark text-white' : 'border-slate-300 bg-white text-slate-700' }}"
                            data-ba-case="{{ $idx + 1 }}"
                        >
                            {{ $btnLabel }}
                        </button>
                    @endforeach
                </div>

                <div class="relative mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                    <div id="beforeLayer" class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $beforeUrl }}')"></div>
                    <div
                        id="afterLayer"
                        class="absolute inset-0 bg-cover bg-center"
                        style="background-image:url('{{ $afterUrl }}'); clip-path: inset(0 0 0 50%);"
                    ></div>

                    <input
                        id="baRange"
                        type="range"
                        min="0"
                        max="100"
                        value="50"
                        class="absolute bottom-3 left-3 right-3 z-20 h-2 w-auto cursor-pointer accent-brand-blue"
                        aria-label="Comparer avant et après"
                    >
                </div>
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-slate-600">
                Aucun chantier avant/après n'a encore été ajouté pour cette page.
            </div>
        @endif
    </div>
</section>

<section class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="min-w-0">
                @include('services.avis_only', ['home' => $h])
            </div>

            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Un projet de rénovation ?</p>
                <h2 class="mt-2 break-words text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                    Démarrez dès maintenant
                </h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-1">
                    <a
                        href="{{ route('home').'#simulateur-devis' }}"
                        class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500"
                    >
                        Ouvrir le simulateur de devis
                    </a>
                    <a
                        href="{{ route('contact.page') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm transition hover:border-brand-blue/40 hover:text-brand-blue"
                    >
                        Accéder au formulaire de contact
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.footer', ['home' => $h])

@include('home.scripts', ['home' => $h])
</body>
</html>

