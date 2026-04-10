@php
    $h = $home ?? [];
    $r = data_get($h, 'realisations', []);
    $promoHref = trim((string) data_get($r, 'promo_href', ''));
    if ($promoHref === '' || $promoHref === '#realisations') {
        $promoHref = route('realisations.page');
    }
    $cases = data_get($r, 'cases', []);
    $c0 = $cases[0] ?? [];
    $before0 = \App\Support\HomeView::url(data_get($c0, 'before'));
    $after0 = \App\Support\HomeView::url(data_get($c0, 'after'));
    $promoBg = \App\Support\HomeView::url(data_get($r, 'promo_bg'));
@endphp
<section id="realisations" class="scroll-mt-24 py-16 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        {{-- Carte À propos pleine largeur (sans Avant/Après) --}}
        <div id="a-propos" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft lg:p-8">
            @php
                $aboutTitle = (string) data_get($h, 'about.title');
                $accent = 'À propos';
                $rest = trim(str_replace($accent, '', $aboutTitle));
                // Si la title ne contient pas "À propos", on retombe sur une sortie unique.
                if ($rest === '' || $aboutTitle === $accent) {
                    $accent = $aboutTitle;
                    $rest = '';
                }
            @endphp
            <h2 class="mb-4 text-4xl font-extrabold leading-tight tracking-tight text-brand-dark sm:text-5xl">
                <span class="text-brand-blue">{{ $accent }}</span>{{ $rest ? ' ' . $rest : '' }}
            </h2>
            <p class="mb-5 text-base leading-relaxed text-slate-600 sm:text-lg">{{ data_get($h, 'about.body') }}</p>
            <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ data_get($h, 'about.commitments_heading') }}</p>
            @php
                $commitments = data_get($h, 'about.commitments', []);
                $left = array_slice($commitments, 0, 3);
                $right = array_slice($commitments, 3, 3);
            @endphp
            <div class="grid gap-x-10 gap-y-2 sm:grid-cols-2">
                <ul class="space-y-2 text-base text-slate-700">
                    @foreach ($left as $line)
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span>
                            <span>{{ $line }}</span>
                        </li>
                    @endforeach
                </ul>
                <ul class="space-y-2 text-base text-slate-700">
                    @foreach ($right as $line)
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span>
                            <span>{{ $line }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Deux colonnes : à gauche "Vous avez un projet", à droite "Réalisations" --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="flex min-h-0 flex-col gap-6 lg:h-full">
                <div class="flex-1 rounded-2xl border border-brand-dark/25 bg-gradient-to-br from-brand-dark via-brand-dark to-slate-900 p-5 shadow-lg sm:p-6">
                    <p class="break-words text-lg font-extrabold leading-snug text-white sm:text-xl">{{ data_get($r, 'cta_title') }}</p>
                    <p class="mt-2 break-words text-sm leading-relaxed text-slate-200 sm:text-base">{{ data_get($r, 'cta_text') }}</p>
                    <a
                        href="{{ data_get($r, 'cta_href', '#devis') }}"
                        class="mt-4 inline-flex rounded-xl bg-brand-yellow px-4 py-2.5 text-sm font-extrabold text-brand-dark shadow-md transition hover:bg-yellow-300"
                    >
                        {{ data_get($r, 'cta_button') }}
                    </a>
                </div>
            </div>

            <div class="flex min-h-0 flex-col gap-6 lg:h-full">
                <a
                    href="{{ $promoHref }}"
                    class="group relative block flex-1 overflow-hidden rounded-2xl border border-slate-200 shadow-soft"
                >
                    <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('{{ $promoBg }}')"></div>
                    <div class="relative flex h-full flex-col justify-end bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-5 py-5">
                        <p class="break-words text-xs font-bold uppercase tracking-wide text-brand-yellow">{{ data_get($r, 'promo_kicker') }}</p>
                        <h3 class="break-words text-xl font-extrabold text-white">{{ data_get($r, 'promo_title') }}</h3>
                        <p class="mt-1 break-words text-sm text-slate-200">{{ data_get($r, 'promo_text') }}</p>
                        <span class="mt-4 inline-flex rounded-xl bg-brand-blue px-6 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-brand-dark active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-brand-blue/30">
                            {{ data_get($r, 'promo_button') }}
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
