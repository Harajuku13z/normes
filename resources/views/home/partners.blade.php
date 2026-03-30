@php
    $h = $home ?? [];
@endphp
<section class="partners-marquee border-y border-slate-200 bg-white py-10" aria-label="Partenaires et certification">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        @include('home._partners_marquee', ['home' => $h])
    </div>
</section>
