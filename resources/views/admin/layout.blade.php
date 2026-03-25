<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — Normes')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-3 px-4 py-4 sm:px-6">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-extrabold text-slate-800">Admin — Page d'accueil</a>
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('home') }}" class="font-semibold text-sky-700 hover:underline" target="_blank" rel="noopener">Voir le site</a>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Déconnexion</button>
                </form>
            </div>
        </div>
    </header>
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
