@php $h = $home ?? []; @endphp
<section class="border-t border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-16 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">

            {{-- Colonne gauche : header + slider --}}
            <div class="flex flex-col gap-5">

                {{-- En-tête --}}
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-brand-blue/10 px-4 py-2 text-xs font-extrabold uppercase tracking-wide text-brand-blue">
                        Avis multi-plateformes
                    </div>
                    <h2 class="text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl lg:text-5xl">
                        <span class="text-brand-blue">{{ data_get($h, 'avis.title_accent') }}</span>{{ data_get($h, 'avis.title_rest') }}
                    </h2>
                    <p class="mt-3 text-base text-slate-600 sm:text-lg">{{ data_get($h, 'avis.intro') }}</p>

                    <a href="{{ data_get($h, 'avis.google_url') }}" target="_blank" rel="noopener noreferrer"
                       class="mt-5 inline-flex w-fit items-center gap-2 rounded-xl border-2 border-brand-dark/15 bg-white px-5 py-3 text-sm font-extrabold text-brand-dark shadow-sm ring-1 ring-slate-200/80 transition hover:border-brand-blue/40 hover:bg-slate-50 hover:text-brand-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        {{ data_get($h, 'avis.google_button') }}
                    </a>
                </div>

                {{-- Contrôles --}}
                <div class="flex items-center justify-between gap-4">
                    <p class="text-sm font-semibold text-slate-600">Des retours concrets, provenant de plusieurs plateformes.</p>
                    <div class="flex shrink-0 items-center gap-2">
                        <button id="avisPrev" type="button" aria-label="Avis précédent"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-soft transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <button id="avisNext" type="button" aria-label="Avis suivant"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-soft transition hover:border-brand-blue/40 hover:text-brand-blue active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Wrapper carousel : overflow:hidden + transform (zéro débordement) --}}
                <div class="relative flex-1 overflow-hidden rounded-2xl border border-slate-200 bg-white ring-1 ring-slate-100">
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-brand-blue/5 via-white to-brand-yellow/5" aria-hidden="true"></div>
                    <div class="relative p-3 sm:p-4">
                        <div id="avisTrack" class="flex transition-transform duration-500 ease-in-out will-change-transform">
                            @foreach (data_get($h, 'avis.testimonials', []) as $t)
                                @php
                                    $platform    = (string) data_get($t, 'platform', 'google');
                                    $reviewCount = (string) data_get($t, 'review_count', '+100 avis');
                                    $author      = (string) data_get($t, 'author', '');
                                    $text        = (string) data_get($t, 'text', '');
                                    $countClass  = ($loop->iteration % 2) === 1 ? 'text-brand-blue' : 'text-brand-yellow';
                                @endphp
                                <article class="w-full flex-shrink-0 overflow-hidden rounded-xl border border-slate-200/90 bg-white p-5 sm:p-6">
                                    <div class="mb-4 flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            @if ($platform === 'google')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                                </svg>
                                            @else
                                                <span class="inline-flex h-8 items-center rounded-full bg-slate-100 px-3 text-xs font-extrabold text-brand-blue">{{ $platform }}</span>
                                            @endif
                                        </div>
                                        <p class="text-base tracking-wide text-yellow-500" aria-label="5 sur 5">★★★★★</p>
                                    </div>

                                    <p class="mb-4 break-words text-sm leading-relaxed text-slate-700 sm:text-base">{{ $text }}</p>

                                    <div class="flex items-center justify-between gap-3 border-t border-slate-200/60 pt-3">
                                        <span class="text-xs font-extrabold {{ $countClass }}">{{ $reviewCount }}</span>
                                        <p class="text-sm font-extrabold text-brand-dark">{{ $author }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    {{-- Indicateurs dots --}}
                    <div id="avisDots" class="flex justify-center gap-2 pb-3 pt-1">
                        @foreach (data_get($h, 'avis.testimonials', []) as $t)
                            <button
                                type="button"
                                class="avis-dot h-2 w-2 rounded-full bg-slate-300 transition-all duration-300 first:bg-brand-blue"
                                aria-label="Avis {{ $loop->iteration }}"
                            ></button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Colonne droite : card Clients satisfaits --}}
            <div class="relative min-h-[260px] overflow-hidden rounded-2xl sm:min-h-[320px] lg:min-h-0">
                <div class="absolute inset-0 bg-cover bg-center transition duration-300"
                     style="background-image:url('{{ \App\Support\HomeView::url('/nous/equipe.jpeg') }}');"
                     aria-hidden="true"></div>
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
        const track = document.getElementById('avisTrack');
        const prev  = document.getElementById('avisPrev');
        const next  = document.getElementById('avisNext');
        const dotsEl = document.getElementById('avisDots');
        if (!track || !prev || !next) return;

        const cards = Array.from(track.querySelectorAll('article'));
        const dots  = dotsEl ? Array.from(dotsEl.querySelectorAll('.avis-dot')) : [];
        const n     = cards.length;
        let current = 0;

        const go = (idx) => {
            current = ((idx % n) + n) % n;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            dots.forEach((d, i) => {
                d.classList.toggle('bg-brand-blue', i === current);
                d.classList.toggle('w-4',           i === current);
                d.classList.toggle('bg-slate-300',  i !== current);
                d.classList.toggle('w-2',           i !== current);
            });
        };

        prev.addEventListener('click', () => go(current - 1));
        next.addEventListener('click', () => go(current + 1));
        dots.forEach((d, i) => d.addEventListener('click', () => go(i)));

        let timer = null;
        const reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const startAuto = () => {
            if (reduced || timer) return;
            timer = window.setInterval(() => go(current + 1), 5200);
        };
        const stopAuto = () => {
            if (!timer) return;
            window.clearInterval(timer);
            timer = null;
        };

        const section = track.closest('section');
        if (section) {
            section.addEventListener('mouseenter', stopAuto);
            section.addEventListener('mouseleave', startAuto);
        }
        track.addEventListener('touchstart', stopAuto, { passive: true });
        track.addEventListener('touchend',   startAuto, { passive: true });

        go(0);
        startAuto();
    })();
</script>
