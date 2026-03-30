@php
    use App\Support\HomeView;
    $bg = HomeView::url($page->image ?? '');
    $ctaHref = $page->cta_href ? (str_starts_with($page->cta_href, 'http') ? $page->cta_href : $page->cta_href) : '#devis';
@endphp

<section class="scroll-mt-24 bg-slate-50/70 py-14 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white">
            <div class="absolute inset-0">
                @if ($bg)
                    <img src="{{ $bg }}" alt="" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/60 to-transparent"></div>
                @else
                    <div class="absolute inset-0 bg-brand-dark/10"></div>
                @endif
            </div>

            <div class="relative z-10 p-6 sm:p-8">
                <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">
                    {{ $page->subtitle ?? 'Service' }}
                </p>
                <h1 class="mt-2 text-3xl font-extrabold leading-tight text-white sm:text-4xl">
                    {{ $page->title }}
                </h1>
                @if (!empty($page->intro))
                    <p class="mt-4 max-w-3xl text-base leading-relaxed text-white/90 sm:text-lg">
                        {{ $page->intro }}
                    </p>
                @endif

                @if (!empty($page->cta_text))
                    <a href="{{ $ctaHref }}"
                       class="mt-6 inline-flex w-fit rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-brand-dark">
                        {{ $page->cta_text }}
                    </a>
                @endif
            </div>
        </div>

        @if (!empty($page->body))
            <div class="mt-10 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($page->body)) !!}
                </div>
            </div>
        @endif
    </div>
</section>

