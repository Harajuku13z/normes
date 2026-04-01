<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Page introuvable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <main class="mx-auto flex min-h-screen w-[95%] max-w-4xl flex-col items-center justify-center px-4 py-10 text-center">
        <p class="text-sm font-extrabold uppercase tracking-[0.22em] text-sky-600">Erreur 404</p>
        <h1 class="mt-3 text-4xl font-black leading-tight sm:text-5xl">Page introuvable</h1>
        <p class="mt-4 max-w-2xl text-base text-slate-600 sm:text-lg">
            Le lien demandé n’existe plus ou a été déplacé. Reviens à l’accueil ou consulte directement les pages importantes.
        </p>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Accueil
            </a>
            <a href="{{ route('services.index') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-100">
                Nos services
            </a>
            <a href="{{ route('contact.page') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-100">
                Contact
            </a>
        </div>
    </main>
</body>
</html>
