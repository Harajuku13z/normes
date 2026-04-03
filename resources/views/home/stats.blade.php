@php $h = $home ?? []; @endphp
<section class="bg-brand-dark py-14 text-white sm:py-20">
    <div class="mx-auto grid w-[95%] gap-4 px-4 sm:grid-cols-2 sm:gap-5 sm:px-6 lg:grid-cols-4 lg:gap-6 lg:px-8">
        @foreach (data_get($h, 'stats.items', []) as $item)
            @php
                $isOdd = ($loop->iteration % 2) === 1;
                $textClass = $isOdd ? 'text-brand-blue' : 'text-brand-dark';
                $mutedTextClass = $isOdd ? 'text-brand-blue/90' : 'text-brand-dark/90';
                $iconWrapClass = $isOdd ? 'bg-brand-blue/10 ring-brand-blue/15' : 'bg-brand-dark/10 ring-brand-dark/15';
                $iconClass = trim((string) data_get($item, 'icon', 'fa-solid fa-chart-line'));
                $isFa = str_starts_with($iconClass, 'fa-') || str_contains($iconClass, 'fa ');
            @endphp
            <article class="flex flex-col items-center rounded-2xl border border-white/15 bg-white px-4 py-7 text-center shadow-soft ring-1 ring-white/10 sm:py-8">
                <span class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl {{ $iconWrapClass }} {{ $textClass }} ring-1" aria-hidden="true">
                    @if ($isFa)
                        <i class="{{ $iconClass }} text-2xl"></i>
                    @else
                        <i class="fa-solid fa-chart-line text-2xl"></i>
                    @endif
                </span>
                <strong class="text-4xl font-black tracking-tight {{ $textClass }}" data-countup="{{ data_get($item, 'value') }}">0</strong>
                <noscript><strong class="text-4xl font-black tracking-tight {{ $textClass }}">{{ data_get($item, 'value') }}</strong></noscript>
                <span class="mt-1 text-sm font-bold {{ $mutedTextClass }} sm:text-base">{{ data_get($item, 'label') }}</span>
            </article>
        @endforeach
    </div>
</section>
