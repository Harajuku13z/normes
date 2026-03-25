<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate adminuser</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4">
    <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h1 class="text-xl font-extrabold text-slate-900">Création d’admins</h1>
        <p class="mt-2 text-sm text-slate-600">Mot de passe requis pour accéder à la création d’users admin.</p>

        <form method="post" action="{{ route('admin.adminuser.login.post') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="password" class="mb-1 block text-sm font-semibold text-slate-800">Mot de passe</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
            </div>

            @error('password')
                <p class="text-sm font-semibold text-red-600">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full rounded-xl bg-slate-900 py-2.5 text-sm font-extrabold text-white hover:bg-slate-800">
                Entrer
            </button>
        </form>
    </div>
</body>
</html>

