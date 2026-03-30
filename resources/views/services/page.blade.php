@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $bg = HomeView::url($page->image ?? '');
    $ctaHref = $page->cta_href
        ? (str_starts_with((string) $page->cta_href, 'http') ? (string) $page->cta_href : (string) $page->cta_href)
        : '#devis';

    $secondaryHref = '#devis';
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

<section class="scroll-mt-24 bg-slate-50/70 py-12 sm:py-16">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        @if (!empty($page->body))
            <div class="rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($page->body)) !!}
                </div>
            </div>
        @endif
    </div>
</section>

@include('home.footer', ['home' => $h])

@include('home.scripts', ['home' => $h])
</body>
</html>

