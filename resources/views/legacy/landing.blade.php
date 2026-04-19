@php
    $h = $home ?? app(\App\Services\HomePageService::class)->merged();
    $canonicalUrl = url('/');
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'canonicalUrl' => $canonicalUrl,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])
@include('home.hero', ['home' => $h])
@include('home.asides', ['home' => $h])
@include('home.services', ['home' => $h])
@include('home.simulateur', ['home' => $h])
@include('home.realisations_about', ['home' => $h])
@include('home.agences', ['home' => $h])
@include('home.pourquoi_processus', ['home' => $h])
@include('home.stats', ['home' => $h])
@include('home.avis', ['home' => $h])
@include('home.devis', ['home' => $h])
@include('home.blog', ['home' => $h])
@include('home.partners', ['home' => $h])
@include('home.footer', ['home' => $h])
@include('home.popup_simulateur', ['home' => $h])
@include('home.cookie_consent', ['home' => $h])
@include('home.countup_script')
@include('home.scripts', ['home' => $h])
</body>
</html>
