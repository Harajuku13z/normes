@php
    use App\Support\SectionTitle;

    $tag = $as ?? 'h2';
    $variant = $variant ?? 'light';
    $p = SectionTitle::accentRest(trim((string) ($title ?? '')));
    $showSplit = $p['accent'] !== '' && $p['rest'] !== '';
    $accentOnly = $p['accent'] !== '' && $p['rest'] === '';
@endphp
<{{ $tag }} @if (! empty($id)) id="{{ $id }}" @endif class="{{ $class ?? '' }}">
@if ($showSplit)
    @if ($variant === 'hero')
        <span class="text-white">{{ $p['accent'] }}</span><span class="text-brand-blue"> {{ $p['rest'] }}</span>
    @else
        <span class="text-brand-blue">{{ $p['accent'] }}</span><span class="text-brand-dark"> {{ $p['rest'] }}</span>
    @endif
@elseif ($accentOnly)
    <span class="text-brand-blue">{{ $p['accent'] }}</span>
@else
    {{ $p['rest'] }}
@endif
</{{ $tag }}>
