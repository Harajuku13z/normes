@php
    $defaults = \App\Support\HomePageDefaults::all();
    $defaultAvis = is_array(data_get($defaults, 'avis', [])) ? data_get($defaults, 'avis', []) : [];

    $h = $home ?? [];
    $ov = is_array($avisOverrides ?? null) ? $avisOverrides : [];

    $titleAccent = trim((string) data_get($ov, 'title_accent', (string) data_get($h, 'avis.title_accent', (string) data_get($defaultAvis, 'title_accent', 'Avis'))));
    $titleRest = trim((string) data_get($ov, 'title_rest', (string) data_get($h, 'avis.title_rest', (string) data_get($defaultAvis, 'title_rest', 'clients'))));
    $intro = trim((string) data_get($ov, 'intro', (string) data_get($h, 'avis.intro', (string) data_get($defaultAvis, 'intro', ''))));
    $googleUrl = trim((string) data_get($h, 'avis.google_url', (string) data_get($defaultAvis, 'google_url', '#')));
    $sidebarAvis = (array) data_get($h, 'sidebar_avis', data_get($defaults, 'sidebar_avis', []));
    $sidebarIcon = trim((string) data_get($sidebarAvis, 'icon', '/iconne.png'));
    $googleReviewsLabel = trim((string) data_get($sidebarAvis, 'text', '98 avis Google'));

    $testimonials = collect((array) data_get($h, 'avis.testimonials', []))
        ->filter(fn ($t) => is_array($t))
        ->values()
        ->all();
    if ($testimonials === []) {
        $testimonials = collect((array) data_get($defaultAvis, 'testimonials', []))
            ->filter(fn ($t) => is_array($t))
            ->values()
            ->all();
    }

    $initialColors = ['bg-indigo-500', 'bg-rose-500', 'bg-amber-500', 'bg-emerald-500', 'bg-violet-500', 'bg-sky-500'];
@endphp

<div id="svc-avis-clients" class="rounded-2xl bg-sky-50 p-6 sm:p-8">

    <h2 class="text-2xl font-black leading-tight text-brand-dark sm:text-3xl">
        <span class="text-brand-blue">{{ $titleAccent }}</span>@if ($titleRest !== ''){{ ' '.$titleRest }}@endif
    </h2>

    <div class="mt-4 flex items-center gap-3">
        <span class="h-0.5 w-8 rounded-full bg-brand-blue" aria-hidden="true"></span>
        <span class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Témoignage</span>
    </div>
    @if ($intro !== '')
        <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">{{ $intro }}</p>
    @endif

    <div class="mt-8 flex items-stretch gap-4">

        {{-- Card Google Business (md+) --}}
        <div class="hidden shrink-0 flex-col items-center justify-center rounded-2xl bg-white px-5 py-6 shadow-sm md:flex" style="min-width:160px">
            <img src="{{ \App\Support\HomeView::url($sidebarIcon) }}" alt="Normes et Rénovation" class="h-10 w-10 rounded-lg object-contain" loading="lazy" decoding="async">
            <p class="mt-2 text-center text-[10px] font-extrabold uppercase tracking-wide text-brand-dark">Normes et Rénovation</p>
            <p class="mt-1 text-sm text-yellow-500">★★★★★</p>
            <p class="mt-0.5 text-[11px] text-slate-500">{{ $googleReviewsLabel }}</p>
            <a href="{{ $googleUrl }}" target="_blank" rel="noopener noreferrer" class="mt-3 rounded-lg border border-slate-200 px-3 py-1.5 text-[11px] font-extrabold text-brand-dark transition hover:border-brand-blue hover:text-brand-blue">
                Écrire un avis
            </a>
        </div>

        {{-- Carousel --}}
        <div class="relative min-w-0 flex-1" id="svcAvisCarousel">
            <button id="svcAvisPrev" type="button" aria-label="Avis précédents"
                class="absolute -left-2.5 top-1/2 z-10 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-md transition hover:border-brand-blue hover:text-brand-blue active:scale-95">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button id="svcAvisNext" type="button" aria-label="Avis suivants"
                class="absolute -right-2.5 top-1/2 z-10 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-md transition hover:border-brand-blue hover:text-brand-blue active:scale-95">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
            </button>

            <div id="svcAvisViewport" class="overflow-hidden rounded-xl">
                <div id="svcAvisTrack" class="flex" style="transition:transform .5s ease">
                    @foreach ($testimonials as $idx => $t)
                        @php
                            $platform = (string) data_get($t, 'platform', 'google');
                            $author   = (string) data_get($t, 'author', '');
                            $text     = (string) data_get($t, 'text', '');
                            $initial  = mb_strtoupper(mb_substr($author, 0, 1));
                            $color    = $initialColors[$idx % count($initialColors)];
                        @endphp
                        <article class="svc-avis-slide shrink-0 px-1.5" style="box-sizing:border-box">
                            <div class="flex h-full flex-col rounded-xl bg-white p-4 shadow-sm">
                                <div class="mb-2 flex items-center gap-2.5">
                                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $color }} text-xs font-extrabold text-white">{{ $initial }}</span>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-xs font-extrabold text-brand-dark">{{ $author }}</p>
                                        <p class="text-[10px] text-slate-400">il y a quelque temps</p>
                                    </div>
                                    @if ($platform === 'google')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" aria-label="Google">
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        </svg>
                                    @else
                                        <span class="shrink-0 rounded-full bg-slate-100 px-2 py-0.5 text-[9px] font-extrabold text-brand-blue">{{ $platform }}</span>
                                    @endif
                                </div>
                                <div class="mb-2 flex items-center gap-1">
                                    <p class="text-xs text-yellow-500">★★★★★</p>
                                    <svg class="h-3 w-3 text-brand-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                </div>
                                <p class="mb-2 flex-1 text-xs leading-relaxed text-slate-600 line-clamp-3">{{ $text }}</p>
                                <a href="{{ $googleUrl }}" target="_blank" rel="noopener noreferrer" class="text-[11px] font-bold text-brand-blue hover:underline">Lire la suite</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var viewport = document.getElementById('svcAvisViewport');
    var track = document.getElementById('svcAvisTrack');
    var slides = track ? Array.from(track.querySelectorAll('.svc-avis-slide')) : [];
    var prev = document.getElementById('svcAvisPrev');
    var next = document.getElementById('svcAvisNext');
    var section = document.getElementById('svc-avis-clients');
    var n = slides.length;
    if (!n || !track || !viewport) return;

    var currentPage = 0;
    var timer = null;

    function getVisible() {
        var w = viewport.offsetWidth;
        if (w >= 768) return 3;
        if (w >= 480) return 2;
        return 1;
    }

    function layout() {
        var vis = getVisible();
        var slideW = viewport.offsetWidth / vis;
        for (var i = 0; i < n; i++) slides[i].style.width = slideW + 'px';
        track.style.width = (slideW * n) + 'px';
    }

    function getTotalPages() {
        return Math.ceil(n / getVisible());
    }

    function goTo(page) {
        layout();
        var vis = getVisible();
        var total = getTotalPages();
        currentPage = ((page % total) + total) % total;
        var offset = currentPage * vis * (viewport.offsetWidth / vis);
        track.style.transform = 'translateX(-' + offset + 'px)';
    }

    function startAuto() {
        if (timer) return;
        timer = setInterval(function () { goTo(currentPage + 1); }, 4000);
    }

    function stopAuto() {
        if (!timer) return;
        clearInterval(timer);
        timer = null;
    }

    if (prev) prev.addEventListener('click', function () { stopAuto(); goTo(currentPage - 1); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); goTo(currentPage + 1); startAuto(); });

    if (section) {
        section.addEventListener('mouseenter', stopAuto);
        section.addEventListener('mouseleave', startAuto);
    }

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () { goTo(currentPage); }, 100);
    });

    layout();
    goTo(0);
    startAuto();
});
</script>
