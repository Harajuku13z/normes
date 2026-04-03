@php
    $items = collect($testimonials ?? [])
        ->filter(fn ($t) => is_array($t) && trim((string) data_get($t, 'author')) !== '' && trim((string) data_get($t, 'text')) !== '')
        ->values();
    $gUrl = trim((string) ($googleUrl ?? ''));
@endphp
<section id="avis-about" class="border-t border-slate-200/80 bg-gradient-to-b from-slate-50 to-white py-16 sm:py-20" aria-labelledby="avis-about-heading">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        @if (trim((string) ($avisKicker ?? '')) !== '')
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $avisKicker }}</p>
        @endif
        <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <h2 id="avis-about-heading" class="text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl">
                {{ $avisTitle ?? '' }}
            </h2>
            @if ($gUrl !== '')
                <div class="flex flex-wrap items-center gap-3">
                    @if (trim((string) ($googleReviewsLabel ?? '')) !== '')
                        <span class="rounded-full bg-white px-4 py-2 text-sm font-extrabold text-brand-dark ring-1 ring-slate-200">{{ $googleReviewsLabel }}</span>
                    @endif
                    <a href="{{ $gUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                        <span class="text-yellow-300" aria-hidden="true">★★★★★</span>
                        Écrire un avis
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-10 grid gap-5 md:grid-cols-2">
            @foreach ($items as $t)
                @php
                    $author = (string) data_get($t, 'author');
                    $when = trim((string) data_get($t, 'time_ago', ''));
                    $text = (string) data_get($t, 'text');
                @endphp
                <article class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-blue/15 text-sm font-extrabold text-brand-dark" aria-hidden="true">
                        {{ mb_strtoupper(mb_substr($author, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                            <p class="font-extrabold text-brand-dark">{{ $author }}</p>
                            @if ($when !== '')
                                <p class="text-xs text-slate-500">{{ $when }}</p>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-yellow-500" aria-hidden="true">★★★★★</p>
                        <p class="mt-3 text-sm leading-relaxed text-slate-700">{{ $text }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
