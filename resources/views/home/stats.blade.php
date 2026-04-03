@php $h = $home ?? []; @endphp
<section class="bg-brand-dark py-14 text-white sm:py-20">
    <div class="mx-auto grid w-[95%] gap-4 px-4 sm:grid-cols-2 sm:gap-5 sm:px-6 lg:grid-cols-4 lg:gap-6 lg:px-8">
        @foreach (data_get($h, 'stats.items', []) as $item)
            @php
                $isOdd = ($loop->iteration % 2) === 1;
                $tone = $isOdd ? 'brand-blue' : 'brand-dark';
                $textClass = $isOdd ? 'text-brand-blue' : 'text-brand-dark';
                $mutedTextClass = $isOdd ? 'text-brand-blue/90' : 'text-brand-dark/90';
                $iconWrapClass = $isOdd ? 'bg-brand-blue/10 ring-brand-blue/15' : 'bg-brand-dark/10 ring-brand-dark/15';
            @endphp
            <article class="flex flex-col items-center rounded-2xl border border-white/15 bg-white px-4 py-7 text-center shadow-soft ring-1 ring-white/10 sm:py-8">
                <span class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl {{ $iconWrapClass }} {{ $textClass }} ring-1" aria-hidden="true">
                    @if (data_get($item, 'icon') === 'building')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    @elseif (data_get($item, 'icon') === 'star')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    @elseif (data_get($item, 'icon') === 'clock')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @endif
                </span>
                <strong class="text-4xl font-black tracking-tight {{ $textClass }}" data-countup="{{ data_get($item, 'value') }}">{{ data_get($item, 'value') }}</strong>
                <span class="mt-1 text-sm font-bold {{ $mutedTextClass }} sm:text-base">{{ data_get($item, 'label') }}</span>
            </article>
        @endforeach
    </div>
</section>
