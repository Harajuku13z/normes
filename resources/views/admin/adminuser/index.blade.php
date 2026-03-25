@extends('admin.layout')

@section('title', 'Créer un admin — AdminUser')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Créer un user admin</h1>
            <p class="mt-1 text-sm text-slate-600">Accès réservé au gate <code class="rounded bg-slate-100 px-1">elizo</code>.</p>
        </div>
        <form action="{{ route('admin.adminuser.logout') }}" method="post">
            @csrf
            <button type="submit" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Quitter
            </button>
        </form>
    </div>

    @if (session('status'))
        <div class="mt-6 mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_420px] lg:items-start">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-extrabold text-slate-900">Nouveau admin</h2>

            <form method="post" action="{{ route('admin.adminuser.store') }}" class="mt-4 space-y-4">
                @csrf

                <div>
                    <label for="name" class="mb-1 block text-sm font-semibold text-slate-800">Nom</label>
                    <input id="name" name="name" type="text" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-semibold text-slate-800">Email</label>
                    <input id="email" name="email" type="email" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-semibold text-slate-800">Mot de passe</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-semibold text-slate-800">Confirmer</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                </div>

                <button type="submit" class="w-full rounded-xl bg-slate-900 py-2.5 text-sm font-extrabold text-white hover:bg-slate-800">
                    Créer
                </button>
            </form>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-extrabold text-slate-900">Admins existants</h2>

            <div class="mt-4 overflow-hidden rounded-lg border border-slate-200">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="px-3 py-2">Nom</th>
                            <th class="px-3 py-2">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $u)
                            <tr>
                                <td class="px-3 py-2 font-semibold text-slate-900">{{ $u->name }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $u->email }}</td>
                            </tr>
                        @endforeach
                        @if ($users->isEmpty())
                            <tr>
                                <td colspan="2" class="px-3 py-3 text-sm text-slate-500">
                                    Aucun user pour le moment.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

