@php
    $items = collect($testimonials ?? [])
        ->filter(fn ($t) => is_array($t) && trim((string) data_get($t, 'author')) !== '' && trim((string) data_get($t, 'text')) !== '')
        ->values();
    $gUrl = trim((string) ($googleUrl ?? ''));
@endphp
<section id="avis-about" class="relative border-t border-slate-200/80 bg-gradient-to-b from-slate-100/90 via-white to-white py-16 sm:py-24" aria-labelledby="avis-about-heading">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-blue/25 to-transparent" aria-hidden="true"></div>
    <div class="mx-auto w-[95%] max-w-6xl px-4 sm:px-6 lg:px-8">
        @if (trim((string) ($avisKicker ?? '')) !== '')
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ $avisKicker }}</p>
        @endif
        <div class="mt-3 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <h2 id="avis-about-heading" class="text-3xl font-black leading-[1.1] tracking-tight text-brand-dark sm:text-4xl lg:text-[2.5rem]">
                    {{ $avisTitle ?? '' }}
                </h2>
            </div>
            @if ($gUrl !== '')
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                    @if (trim((string) ($googleReviewsLabel ?? '')) !== '')
                        <div class="inline-flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-white px-4 py-3 shadow-sm ring-1 ring-slate-100">
                            <span class="flex text-yellow-500" aria-hidden="true">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </span>
                            <span class="text-sm font-extrabold text-brand-dark">{{ $googleReviewsLabel }}</span>
                        </div>
                    @endif
                    <a
                        href="{{ $gUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-dark px-5 py-3 text-sm font-extrabold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-brand-dark/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow focus-visible:ring-offset-2"
                    >
                        <svg class="h-4 w-4 text-brand-yellow" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        Écrire un avis
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($items as $t)
                @php
                    $author = (string) data_get($t, 'author');
                    $when = trim((string) data_get($t, 'time_ago', ''));
                    $text = (string) data_get($t, 'text');
                @endphp
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-100/80 transition duration-300 hover:-translate-y-1 hover:border-brand-blue/20 hover:shadow-lg">
                    <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-brand-yellow via-sky-500/90 to-brand-blue" aria-hidden="true"></div>
                    <div class="pl-3 sm:pl-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-blue to-sky-600 text-sm font-black text-white shadow-md ring-2 ring-white" aria-hidden="true">
                                {{ mb_strtoupper(mb_substr($author, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1 pt-0.5">
                                <div class="flex flex-wrap items-baseline justify-between gap-x-2 gap-y-1">
                                    <p class="font-extrabold text-brand-dark">{{ $author }}</p>
                                    @if ($when !== '')
                                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ $when }}</p>
                                    @endif
                                </div>
                                <p class="mt-1.5 flex gap-0.5 text-yellow-500" aria-hidden="true">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </p>
                            </div>
                        </div>
                        <p class="mt-4 border-l-2 border-brand-blue/15 pl-4 text-sm leading-relaxed text-slate-700">
                            {{ $text }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
