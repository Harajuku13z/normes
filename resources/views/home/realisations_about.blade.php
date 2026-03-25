@php
    $h = $home ?? [];
    $r = data_get($h, 'realisations', []);
    $cases = data_get($r, 'cases', []);
    $c0 = $cases[0] ?? [];
    $before0 = \App\Support\HomeView::url(data_get($c0, 'before'));
    $after0 = \App\Support\HomeView::url(data_get($c0, 'after'));
    $promoBg = \App\Support\HomeView::url(data_get($r, 'promo_bg'));
@endphp
<section id="realisations" class="scroll-mt-24 py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Carte À propos pleine largeur (sans Avant/Après) --}}
        <div id="a-propos" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft lg:p-8">
            <h2 class="mb-4 text-4xl font-extrabold leading-tight tracking-tight text-brand-dark sm:text-5xl">
                {{ data_get($h, 'about.title') }}
            </h2>
            <p class="mb-5 text-base leading-relaxed text-slate-600 sm:text-lg">{{ data_get($h, 'about.body') }}</p>
            <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ data_get($h, 'about.commitments_heading') }}</p>
            <ul class="space-y-2 text-base text-slate-700">
                @foreach (data_get($h, 'about.commitments', []) as $line)
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span>
                        <span>{{ $line }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Deux colonnes : projet/réalisations + logos RGE / équipe --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="flex min-h-0 flex-col gap-6">
                <div class="shrink-0 rounded-2xl border border-brand-dark/25 bg-gradient-to-br from-brand-dark via-brand-dark to-slate-900 p-5 shadow-lg sm:p-6">
                    <p class="text-lg font-extrabold leading-snug text-white sm:text-xl">{{ data_get($r, 'cta_title') }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-slate-200 sm:text-base">{{ data_get($r, 'cta_text') }}</p>
                    <a href="{{ data_get($r, 'cta_href', '#devis') }}" class="mt-4 inline-flex rounded-xl bg-brand-yellow px-4 py-2.5 text-sm font-extrabold text-brand-dark shadow-md transition hover:bg-yellow-300">
                        {{ data_get($r, 'cta_button') }}
                    </a>
                </div>

                <a href="#realisations" class="group relative block shrink-0 overflow-hidden rounded-2xl border border-slate-200 shadow-soft">
                    <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('{{ $promoBg }}')"></div>
                    <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-5 py-5">
                        <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">{{ data_get($r, 'promo_kicker') }}</p>
                        <h3 class="text-xl font-extrabold text-white">{{ data_get($r, 'promo_title') }}</h3>
                        <p class="mt-1 text-sm text-slate-200">{{ data_get($r, 'promo_text') }}</p>
                        <span class="mt-3 inline-flex rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition group-hover:bg-sky-500">{{ data_get($r, 'promo_button') }}</span>
                    </div>
                </a>
            </div>

            <div class="flex min-h-0 flex-col gap-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                    <h3 class="mb-4 text-lg font-extrabold text-brand-dark">Logos RGE</h3>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        @foreach (data_get($h, 'about.cert_images', []) as $img)
                            <div class="rounded-xl border border-slate-200 bg-white p-2 shadow-sm">
                                <img src="{{ \App\Support\HomeView::url(data_get($img, 'src')) }}" alt="{{ data_get($img, 'alt') }}" class="h-20 w-full rounded-lg object-contain sm:h-24">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <img src="{{ \App\Support\HomeView::url(data_get($h, 'about.team_image')) }}" alt="{{ data_get($h, 'about.team_alt') }}" class="h-56 w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>
