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
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="flex min-h-0 flex-col lg:min-h-[560px]">
                <div class="flex min-h-0 flex-1 flex-col gap-4">
                    <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft">
                        <div class="relative min-h-[260px] flex-1 bg-slate-200 sm:min-h-[320px] lg:min-h-0">
                            <div id="beforeLayer" class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $before0 }}')"></div>
                            <div id="afterLayer" class="absolute inset-0 bg-cover bg-center" style="clip-path: inset(0 0 0 50%); background-image:url('{{ $after0 }}')"></div>
                        </div>
                        <input id="baRange" type="range" min="0" max="100" value="50" class="w-full shrink-0 accent-brand-blue">
                        <div class="flex shrink-0 items-center justify-between bg-slate-50 px-4 py-3 text-xs font-bold uppercase tracking-wide text-slate-600 sm:text-sm"><span>Avant</span><span>Apres</span></div>
                    </div>
                    <div class="shrink-0 rounded-2xl border border-brand-dark/25 bg-gradient-to-br from-brand-dark via-brand-dark to-slate-900 p-5 shadow-lg sm:p-6">
                        <p class="text-lg font-extrabold leading-snug text-white sm:text-xl">{{ data_get($r, 'cta_title') }}</p>
                        <p class="mt-2 text-sm leading-relaxed text-slate-200 sm:text-base">{{ data_get($r, 'cta_text') }}</p>
                        <a href="{{ data_get($r, 'cta_href', '#devis') }}" class="mt-4 inline-flex rounded-xl bg-brand-yellow px-4 py-2.5 text-sm font-extrabold text-brand-dark shadow-md transition hover:bg-yellow-300">{{ data_get($r, 'cta_button') }}</a>
                    </div>
                    <a href="#realisations" class="group relative mt-0 block shrink-0 overflow-hidden rounded-2xl border border-slate-200 shadow-soft">
                        <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('{{ $promoBg }}')"></div>
                        <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-5 py-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">{{ data_get($r, 'promo_kicker') }}</p>
                            <h3 class="text-xl font-extrabold text-white">{{ data_get($r, 'promo_title') }}</h3>
                            <p class="mt-1 text-sm text-slate-200">{{ data_get($r, 'promo_text') }}</p>
                            <span class="mt-3 inline-flex rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition group-hover:bg-sky-500">{{ data_get($r, 'promo_button') }}</span>
                        </div>
                    </a>
                </div>
            </div>

            <aside id="a-propos" class="flex min-h-0 scroll-mt-28 flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-soft lg:min-h-[560px]">
                <h2 class="mb-4 text-4xl font-extrabold leading-tight tracking-tight text-brand-dark sm:text-5xl">
                    {{ data_get($h, 'about.title') }}
                </h2>
                <p class="mb-5 text-base leading-relaxed text-slate-600 sm:text-lg">{{ data_get($h, 'about.body') }}</p>
                <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ data_get($h, 'about.commitments_heading') }}</p>
                <ul class="mb-5 space-y-2 text-base text-slate-700">
                    @foreach (data_get($h, 'about.commitments', []) as $line)
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>{{ $line }}</span></li>
                    @endforeach
                </ul>
                <div class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
                    @foreach (data_get($h, 'about.cert_images', []) as $img)
                        <div class="rounded-xl border border-slate-200 bg-white p-2 shadow-sm">
                            <img src="{{ \App\Support\HomeView::url(data_get($img, 'src')) }}" alt="{{ data_get($img, 'alt') }}" class="h-20 w-full rounded-lg object-contain sm:h-24">
                        </div>
                    @endforeach
                </div>
                <div class="mt-auto overflow-hidden rounded-xl border border-slate-200 shadow-sm">
                    <img src="{{ \App\Support\HomeView::url(data_get($h, 'about.team_image')) }}" alt="{{ data_get($h, 'about.team_alt') }}" class="h-48 w-full object-cover sm:h-56">
                </div>
            </aside>
        </div>
    </div>
</section>
