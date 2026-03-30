<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', ['home' => $home])

<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $home])

@include('home.devis', ['home' => $home])

@include('home.footer', ['home' => $home])

@include('home.cookie_consent', ['home' => $home])
@include('home.scripts', ['home' => $home])
</body>
</html>

