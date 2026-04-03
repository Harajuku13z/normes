@php
    use App\Support\HomeView;
    use App\Support\VimeoEmbed;

    $validReels = collect($reels ?? [])
        ->filter(function ($r) {
            if (! is_array($r)) {
                return false;
            }
            $v = trim((string) data_get($r, 'video', ''));
            $i = trim((string) data_get($r, 'image', ''));

            return $v !== '' || $i !== '';
        })
        ->values();
    $reelCount = $validReels->count();
@endphp

@if ($reelCount > 0)
<section aria-label="Reels et réalisations Normes et Rénovation">

    {{-- ══ MOBILE : plein écran — Vimeo iframe (lazy après la 1re slide) ══ --}}
    <div class="relative h-[100svh] lg:hidden">
        <div class="reels-scroll h-full snap-y snap-mandatory overflow-y-auto" id="reels-mobile">
            @foreach ($validReels as $idx => $reel)
                @php
                    $videoRaw = trim((string) data_get($reel, 'video', ''));
                    $imageRaw = trim((string) data_get($reel, 'image', ''));
                    $caption  = trim((string) data_get($reel, 'caption', ''));
                    $vimeoMeta = VimeoEmbed::parse($videoRaw);
                    $directFile = $videoRaw !== '' && $vimeoMeta === null && VimeoEmbed::isDirectFileUrl($videoRaw);
                    $directVideoUrl = $directFile ? HomeView::url($videoRaw) : '';
                    $imageUrl = $imageRaw !== '' ? HomeView::url($imageRaw) : '';
                    $posterUrl = ($directVideoUrl !== '' && $imageUrl !== '') ? $imageUrl : ($imageUrl !== '' ? $imageUrl : '');
                    $vimeoSrc = $vimeoMeta !== null ? VimeoEmbed::iframeSrc($vimeoMeta, $idx === 0) : '';
                @endphp
                <div class="reel-slide relative h-[100svh] w-full snap-start" data-index="{{ $idx }}">
                    @if ($vimeoMeta !== null)
                        <iframe
                            class="reel-iframe pointer-events-none absolute inset-0 h-full w-full border-0"
                            title="{{ $caption !== '' ? $caption : 'Vidéo Vimeo Normes et Rénovation' }}"
                            @if ($idx === 0)
                                src="{{ $vimeoSrc }}"
                            @else
                                data-src="{{ $vimeoSrc }}"
                            @endif
                            allow="autoplay; fullscreen; picture-in-picture"
                            loading="{{ $idx === 0 ? 'eager' : 'lazy' }}"
                            style="object-fit:cover;-webkit-transform:scale(1.05);transform:scale(1.05);"
                        ></iframe>
                    @elseif ($directVideoUrl !== '')
                        <video
                            class="absolute inset-0 h-full w-full object-cover"
                            @if ($idx === 0)
                                src="{{ $directVideoUrl }}"
                            @else
                                data-lazy-src="{{ $directVideoUrl }}"
                            @endif
                            @if ($posterUrl !== '') poster="{{ $posterUrl }}" @endif
                            muted
                            loop
                            playsinline
                            preload="{{ $idx === 0 ? 'metadata' : 'none' }}"
                            @if ($idx === 0) autoplay @endif
                        ></video>
                    @else
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $caption !== '' ? $caption : 'Réalisation Normes et Rénovation' }}"
                            class="absolute inset-0 h-full w-full object-cover"
                            width="1080"
                            height="1920"
                            loading="{{ $idx === 0 ? 'eager' : 'lazy' }}"
                            decoding="async"
                        >
                    @endif
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/25" aria-hidden="true"></div>

                    @if ($caption !== '')
                        <div class="absolute bottom-16 left-5 right-5 z-10">
                            <p class="text-sm font-semibold leading-relaxed text-white drop-shadow-lg">{{ $caption }}</p>
                        </div>
                    @endif

                    @if ($idx === $reelCount - 1)
                        <div class="pointer-events-none absolute bottom-4 left-1/2 z-10 -translate-x-1/2">
                            <span class="rounded-full bg-white/20 px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider text-white/90 backdrop-blur-sm">Continuer ↓</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="pointer-events-none absolute right-4 top-1/2 z-20 -translate-y-1/2 flex flex-col gap-2" id="reels-dots" aria-hidden="true">
            @for ($i = 0; $i < $reelCount; $i++)
                <div
                    class="reel-dot h-2 w-2 rounded-full transition-all duration-300 {{ $i === 0 ? 'scale-125 bg-white' : 'bg-white/40' }}"
                    data-dot="{{ $i }}"
                ></div>
            @endfor
        </div>

        <div class="pointer-events-none absolute bottom-4 left-1/2 z-20 -translate-x-1/2 animate-bounce" id="reels-swipe-hint" aria-hidden="true">
            <svg class="h-6 w-6 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </div>

    {{-- ══ DESKTOP : iframes Vimeo chargées à l’entrée dans le viewport ══ --}}
    <div id="reels-desktop-grid" class="hidden bg-brand-dark py-20 sm:py-24 lg:block">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                @if (trim((string) ($reelsKicker ?? '')) !== '')
                    <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-brand-yellow">{{ $reelsKicker }}</p>
                @endif
                @if (trim((string) ($reelsTitle ?? '')) !== '')
                    <h2 class="mx-auto mt-3 max-w-xl text-3xl font-black text-white sm:text-4xl">{{ $reelsTitle }}</h2>
                    <div class="mx-auto mt-4 h-1 w-16 rounded-full bg-brand-yellow"></div>
                @endif
            </div>
            <div class="mx-auto mt-14 grid max-w-5xl grid-cols-2 gap-5 xl:grid-cols-4">
                @foreach ($validReels as $reel)
                    @php
                        $videoRaw = trim((string) data_get($reel, 'video', ''));
                        $imageRaw = trim((string) data_get($reel, 'image', ''));
                        $caption  = trim((string) data_get($reel, 'caption', ''));
                        $vimeoMeta = VimeoEmbed::parse($videoRaw);
                        $directFile = $videoRaw !== '' && $vimeoMeta === null && VimeoEmbed::isDirectFileUrl($videoRaw);
                        $directVideoUrl = $directFile ? HomeView::url($videoRaw) : '';
                        $imageUrl = $imageRaw !== '' ? HomeView::url($imageRaw) : '';
                        $posterUrl = ($directVideoUrl !== '' && $imageUrl !== '') ? $imageUrl : '';
                    @endphp
                    <div class="reel-desk-cell group relative aspect-[9/16] overflow-hidden rounded-2xl bg-slate-800">
                        @if ($vimeoMeta !== null)
                            <iframe
                                class="reel-iframe-desktop pointer-events-none h-full w-full max-w-none border-0"
                                title="{{ $caption !== '' ? $caption : 'Vidéo Vimeo' }}"
                                data-src="{{ VimeoEmbed::iframeSrc($vimeoMeta, true) }}"
                                data-loaded="0"
                                allow="autoplay; fullscreen; picture-in-picture"
                                loading="lazy"
                                style="min-height:100%;object-fit:cover;-webkit-transform:scale(1.06);transform:scale(1.06);"
                            ></iframe>
                        @elseif ($directVideoUrl !== '')
                            <video
                                class="reel-video-desktop h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                data-lazy-src="{{ $directVideoUrl }}"
                                data-loaded="0"
                                @if ($posterUrl !== '') poster="{{ $posterUrl }}" @endif
                                muted
                                loop
                                playsinline
                                preload="none"
                            ></video>
                        @else
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $caption !== '' ? $caption : 'Réalisation Normes et Rénovation' }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                width="1080"
                                height="1920"
                                loading="lazy"
                                decoding="async"
                            >
                        @endif
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        @if ($caption !== '')
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <p class="text-xs font-semibold leading-relaxed text-white drop-shadow-md sm:text-sm">{{ $caption }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</section>

<style>
    .reels-scroll::-webkit-scrollbar{display:none}
    .reels-scroll{-ms-overflow-style:none;scrollbar-width:none}
</style>

<script>
document.addEventListener('DOMContentLoaded',function(){
    function hydrateVideo(v){
        var ds=v.getAttribute('data-lazy-src');
        if(!ds)return;
        if(v.getAttribute('data-loaded')==='1')return;
        v.src=ds;
        v.removeAttribute('data-lazy-src');
        v.setAttribute('data-loaded','1');
    }
    function hydrateIframe(f){
        var ds=f.getAttribute('data-src');
        if(!ds)return;
        if(f.getAttribute('data-loaded')==='1')return;
        f.src=ds;
        f.removeAttribute('data-src');
        f.setAttribute('data-loaded','1');
    }

    var c=document.getElementById('reels-mobile');
    if(c){
        var slides=c.querySelectorAll('.reel-slide');
        var dots=document.querySelectorAll('#reels-dots .reel-dot');
        var hint=document.getElementById('reels-swipe-hint');
        var obs=new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if(!e.isIntersecting)return;
                var idx=parseInt(e.target.dataset.index,10);
                dots.forEach(function(d,i){
                    d.classList.toggle('bg-white',i===idx);
                    d.classList.toggle('scale-125',i===idx);
                    d.classList.toggle('bg-white/40',i!==idx);
                    d.classList.toggle('scale-100',i!==idx);
                });
                if(hint)hint.style.display=idx===0?'':'none';
                slides.forEach(function(s,i){
                    var fr=s.querySelector('iframe.reel-iframe');
                    if(fr){
                        if(i===idx){ hydrateIframe(fr); }
                        return;
                    }
                    var v=s.querySelector('video');
                    if(!v)return;
                    if(i===idx){
                        hydrateVideo(v);
                        v.play().catch(function(){});
                    }else{
                        v.pause();
                    }
                });
            });
        },{root:c,threshold:0.6});
        slides.forEach(function(s){obs.observe(s);});
    }

    document.querySelectorAll('.reel-iframe-desktop').forEach(function(f){
        var cell=f.closest('.reel-desk-cell');
        if(!cell)return;
        var io=new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if(en.isIntersecting){
                    hydrateIframe(f);
                }
            });
        },{root:null,rootMargin:'0px 0px 80px 0px',threshold:0.15});
        io.observe(cell);
    });

    document.querySelectorAll('.reel-video-desktop').forEach(function(v){
        var cell=v.closest('.reel-desk-cell');
        if(!cell)return;
        var io=new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if(en.isIntersecting){
                    hydrateVideo(v);
                    v.play&&v.play().catch(function(){});
                }else{
                    v.pause&&v.pause();
                }
            });
        },{root:null,rootMargin:'0px 0px 80px 0px',threshold:0.15});
        io.observe(cell);
    });
});
</script>
@endif
