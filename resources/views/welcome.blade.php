<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', ['home' => $home])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $home])
@include('home.hero', ['home' => $home])
@include('home.simulateur', ['home' => $home])
@include('home.asides', ['home' => $home])
@include('home.services', ['home' => $home])
@include('home.realisations_about', ['home' => $home])
@include('home.agences', ['home' => $home])
@include('home.pourquoi_processus', ['home' => $home])
@include('home.stats', ['home' => $home])
@include('home.avis', ['home' => $home])
@include('home.devis', ['home' => $home])
@include('home.blog', ['home' => $home])
@include('home.partners', ['home' => $home])
@include('home.footer', ['home' => $home])
@include('home.popup_simulateur', ['home' => $home])
@include('home.cookie_consent', ['home' => $home])
@include('home.scripts', ['home' => $home])
</body>
</html>
