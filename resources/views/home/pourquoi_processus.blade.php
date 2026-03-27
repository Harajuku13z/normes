@php
    $h = $home ?? [];
    $p = data_get($h, 'pourquoi', []);
    $proc = data_get($h, 'processus', []);
    $aides = data_get($h, 'aides_renov', []);
    $logoMa = \App\Support\HomeView::url(data_get($aides, 'logo'));
@endphp
<section class="bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="mb-10 max-w-2xl">
            <h2 class="text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($p, 'title_accent') }}</span>{{ data_get($p, 'title_rest') }}</h2>
            <p class="mt-3 text-base text-slate-600 sm:text-lg">{{ data_get($p, 'intro') }}</p>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:items-stretch">
            @foreach (data_get($p, 'cards', []) as $card)
                @php
                    $ring = (string) data_get($card, 'ring', 'brand-blue/15');
                    $tint = match ($ring) {
                        'brand-yellow/25' => 'bg-brand-yellow/5',
                        'emerald-500/20' => 'bg-emerald-500/5',
                        'sky-400/25' => 'bg-sky-400/5',
                        default => 'bg-brand-blue/5',
                    };
                @endphp
                <article class="flex h-full min-h-[210px] flex-col rounded-2xl border border-slate-200/90 p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md {{ $tint }} {{ !empty($card['wide']) ? 'sm:col-span-2 lg:col-span-1' : '' }}">
                    @if ($ring === 'brand-yellow/25')
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-yellow/15 ring-1 ring-brand-yellow/25 text-3xl leading-none" aria-hidden="true">
                            {{ data_get($card, 'emoji') }}
                        </div>
                    @elseif ($ring === 'emerald-500/20')
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/15 ring-1 ring-emerald-500/25 text-3xl leading-none" aria-hidden="true">
                            {{ data_get($card, 'emoji') }}
                        </div>
                    @elseif ($ring === 'sky-400/25')
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-400/15 ring-1 ring-sky-400/25 text-3xl leading-none" aria-hidden="true">
                            {{ data_get($card, 'emoji') }}
                        </div>
                    @else
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-blue/12 ring-1 ring-brand-blue/20 text-3xl leading-none" aria-hidden="true">
                            {{ data_get($card, 'emoji') }}
                        </div>
                    @endif

                    <h3 class="text-base font-extrabold leading-snug text-brand-dark sm:text-lg">{{ data_get($card, 'title') }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">{{ data_get($card, 'text') }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-14 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-soft">
            <div class="border-b border-slate-100 px-5 py-8 sm:px-8 sm:py-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0">
                        <h2 class="text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl lg:text-5xl"><span class="text-brand-blue">{{ data_get($proc, 'title_accent') }}</span>{{ data_get($proc, 'title_rest') }}</h2>
                        <p class="mt-3 max-w-3xl text-base text-slate-600 sm:text-lg">{{ data_get($proc, 'intro') }}</p>
                    </div>
                    <div class="hidden justify-start lg:flex lg:justify-end">
                        <div class="w-full max-w-[390px] rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                            <img
                                src="{{ $logoMa }}"
                                alt="{{ data_get($aides, 'logo_alt') }}"
                                width="520"
                                height="200"
                                class="h-auto max-h-28 w-full object-contain object-center"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative px-5 py-6 sm:px-8 sm:py-8">
                <div class="pointer-events-none absolute left-0 right-0 top-[2.25rem] hidden h-px bg-gradient-to-r from-transparent via-brand-blue/35 to-transparent lg:block" aria-hidden="true"></div>
                <ol class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                    @foreach (data_get($proc, 'steps', []) as $step)
                        @php
                            $isOdd = ($loop->iteration % 2) === 1;
                            $numClass = $isOdd
                                ? 'mb-4 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-blue text-sm font-black text-white shadow-md shadow-brand-blue/25 lg:mx-auto'
                                : 'mb-4 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-dark text-sm font-black text-white shadow-md lg:mx-auto';
                            $liClass = 'relative rounded-xl border border-slate-100 bg-slate-50/60 p-5 lg:border-slate-100/80 lg:bg-white lg:p-6 lg:text-center lg:shadow-sm';
                            if (!empty($step['span'])) {
                                $liClass .= ' sm:col-span-2 lg:col-span-1';
                            }
                        @endphp
                        <li class="{{ $liClass }}">
                            <span class="{{ $numClass }}">{{ data_get($step, 'num') }}</span>
                            <h4 class="text-base font-extrabold text-brand-dark sm:text-lg">{{ data_get($step, 'title') }}</h4>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ data_get($step, 'text') }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="aides-renov-hero-bg border-t border-slate-200/80">
                <div class="relative z-[1] grid gap-8 p-6 sm:p-8 lg:grid-cols-12 lg:items-center lg:gap-12 lg:p-10">
                    <div class="flex justify-center lg:col-span-4 lg:justify-start">
                        <div class="w-full max-w-[320px] rounded-2xl border border-white/25 bg-white/95 p-5 shadow-lg ring-1 ring-slate-200/60 sm:p-6">
                            <div class="flex min-h-[120px] items-center justify-center rounded-xl bg-slate-50 p-3 ring-1 ring-slate-100">
                                <img src="{{ $logoMa }}" alt="{{ data_get($aides, 'logo_alt') }}" width="520" height="200" class="h-auto max-h-32 w-full object-contain object-center sm:max-h-36" loading="lazy" decoding="async">
                            </div>
                            <p class="mt-4 text-center text-[11px] font-bold uppercase tracking-wider text-brand-dark/75">{{ data_get($aides, 'logo_caption') }}</p>
                            <p class="mt-1 text-center text-xs text-slate-600">{{ data_get($aides, 'logo_sub') }}</p>
                        </div>
                    </div>
                    <div class="lg:col-span-8">
                        <p class="text-[11px] font-extrabold uppercase tracking-[0.22em] text-brand-yellow">{{ data_get($aides, 'kicker') }}</p>
                        <h3 class="mt-3 text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl">{{ data_get($aides, 'title') }}</h3>
                        <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-100 sm:text-lg">{{ data_get($aides, 'body') }}</p>
                        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                            <a href="#devis" class="inline-flex justify-center rounded-xl bg-brand-yellow px-6 py-3.5 text-sm font-extrabold text-brand-dark shadow-lg transition hover:bg-yellow-300">{{ data_get($aides, 'button') }}</a>
                            <span class="text-center text-xs text-slate-300 sm:text-left">{{ data_get($aides, 'footnote') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
