<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Admin Normes Rénovation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-900 px-4">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="mb-8 flex flex-col items-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 shadow-xl shadow-blue-600/30 mb-4">
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white">Normes Rénovation</h1>
            <p class="mt-1 text-sm text-slate-400">Panneau d'administration</p>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-slate-700/50 bg-slate-800 p-8 shadow-2xl">
            <h2 class="mb-6 text-base font-bold text-white">Connexion</h2>

            <form method="post" action="{{ url('/admin/login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="login" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Nom ou email
                    </label>
                    <input id="login" name="login" type="text" autocomplete="username" required
                           value="{{ old('login') }}"
                           class="w-full rounded-xl border border-slate-600 bg-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Mot de passe
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="w-full rounded-xl border border-slate-600 bg-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>

                @error('password')
                    <p class="flex items-center gap-1.5 text-sm text-red-400">
                        <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <button type="submit"
                        class="mt-2 w-full rounded-xl bg-blue-600 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 active:scale-[0.98]">
                    Se connecter
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-slate-600">© {{ date('Y') }} Normes Rénovation</p>
    </div>
</body>
</html>
