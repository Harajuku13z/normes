@php $h = $home ?? []; @endphp
<section class="border-t border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-16 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="flex h-full flex-col">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-brand-blue/10 px-4 py-2 text-xs font-extrabold uppercase tracking-wide text-brand-blue">
                        Avis multi-plateformes
                    </div>
                    <h2 class="text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($h, 'avis.title_accent') }}</span>{{ data_get($h, 'avis.title_rest') }}</h2>
                    <p class="mt-3 text-base text-slate-600 sm:text-lg">{{ data_get($h, 'avis.intro') }}</p>

                    <a href="{{ data_get($h, 'avis.google_url') }}" target="_blank" rel="noopener noreferrer"
                       class="mt-6 inline-flex w-fit items-center justify-center gap-2 rounded-xl border-2 border-brand-dark/15 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm ring-1 ring-slate-200/80 transition hover:border-brand-blue/40 hover:bg-slate-50 hover:text-brand-blue hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#4285F4]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        {{ data_get($h, 'avis.google_button') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="mb-5 flex items-center justify-between gap-4">
                    <div class="text-sm font-semibold text-slate-600">
                        Des retours concrets, provenant de plusieurs plateformes.
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="avisPrev" type="button" aria-label="Avis précédent"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-soft transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-[0.99]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button id="avisNext" type="button" aria-label="Avis suivant"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-soft transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-[0.99]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="avisCarousel"
                     class="flex gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    @foreach (data_get($h, 'avis.testimonials', []) as $t)
                        @php
                            $platform = (string) data_get($t, 'platform', 'google');
                            $reviewCount = (string) data_get($t, 'review_count', $platform === 'google' ? '+100 avis' : '+avis');
                            $author = (string) data_get($t, 'author', '');
                            $text = (string) data_get($t, 'text', '');
                            $deco = (string) data_get($t, 'deco_class', 'bg-brand-blue/5');
                        @endphp
                        <article class="relative w-full min-w-full flex-shrink-0 rounded-2xl border border-slate-200/90 bg-white p-6 shadow-soft ring-1 ring-slate-100 transition hover:border-brand-blue/25 hover:shadow-lg snap-start">
                            <div class="absolute -right-2 -top-2 h-16 w-16 rounded-full {{ $deco }}" aria-hidden="true"></div>

                            <div class="relative mb-4 flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    @if ($platform === 'google')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        </svg>
                                    @else
                                        <span class="inline-flex h-9 items-center rounded-full bg-slate-100 px-3 text-xs font-extrabold text-brand-blue">
                                            {{ $platform }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-lg tracking-wide text-yellow-500" aria-label="5 sur 5">★★★★★</p>
                            </div>

                            <p class="relative mb-4 text-sm leading-relaxed text-slate-700 sm:text-base">{{ $text }}</p>

                            <div class="flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                <span class="text-xs font-extrabold text-brand-blue">{{ $reviewCount }}</span>
                                <p class="text-sm font-extrabold text-brand-dark">{{ $author }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="relative h-full overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-soft">
                <div
                    class="absolute inset-0 bg-cover bg-center transition duration-300"
                    style="background-image:url('{{ \App\Support\HomeView::url('/nous/equipe.jpeg') }}');"
                    aria-hidden="true"
                ></div>
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>
                <div class="relative z-10 flex h-full flex-col justify-end p-6 sm:p-7">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-brand-yellow">Clients satisfaits</p>
                    <h3 class="mt-2 text-2xl font-extrabold leading-tight text-white sm:text-3xl">
                        Une équipe au top pour des clients satisfaits.
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const carousel = document.getElementById('avisCarousel');
        const prev = document.getElementById('avisPrev');
        const next = document.getElementById('avisNext');
        if (!carousel || !prev || !next) return;

        const getStep = () => carousel.clientWidth;

        const scrollPageNext = () => {
            const step = getStep();
            const maxLeft = carousel.scrollWidth - carousel.clientWidth;
            if (carousel.scrollLeft >= maxLeft - 2) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
                return;
            }
            carousel.scrollBy({ left: step, behavior: 'smooth' });
        };

        const scrollPagePrev = () => {
            const step = getStep();
            if (carousel.scrollLeft <= 2) {
                const maxLeft = carousel.scrollWidth - carousel.clientWidth;
                carousel.scrollTo({ left: maxLeft, behavior: 'smooth' });
                return;
            }
            carousel.scrollBy({ left: -step, behavior: 'smooth' });
        };

        prev.addEventListener('click', scrollPagePrev);
        next.addEventListener('click', scrollPageNext);

        let t = null;
        const reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const start = () => {
            if (reduced) return;
            if (t) return;
            t = window.setInterval(scrollPageNext, 5200);
        };
        const stop = () => {
            if (!t) return;
            window.clearInterval(t);
            t = null;
        };

        carousel.addEventListener('mouseenter', stop);
        carousel.addEventListener('mouseleave', start);
        carousel.addEventListener('touchstart', stop, { passive: true });
        carousel.addEventListener('touchend', start, { passive: true });

        start();
    })();
</script>
