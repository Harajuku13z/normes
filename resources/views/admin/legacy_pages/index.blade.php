@extends('admin.layout')

@section('title', 'Pages legacy WordPress')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Pages legacy WordPress</h1>
            <p class="mt-1 text-sm text-slate-600">
                Crée des pages 200 OK sur les anciennes URLs indexées (sans redirection).
            </p>
            <p class="mt-1 text-xs text-slate-500">
                Import initial uniquement: <code class="rounded bg-slate-100 px-1">php artisan legacy:import-wordpress --no-update</code>
                <span class="ml-1 text-slate-400">(les pages verrouillées 🔒 ne sont jamais écrasées)</span>
            </p>
        </div>
        <a href="{{ route('admin.legacy_pages.create') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
            Ajouter une page legacy
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-extrabold text-slate-700">URL legacy</th>
                    <th class="px-4 py-3 text-left font-extrabold text-slate-700">Titre</th>
                    <th class="px-4 py-3 text-left font-extrabold text-slate-700">Statut / Lock</th>
                    <th class="px-4 py-3 text-right font-extrabold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pages as $page)
                    @php $url = url('/'.$page->old_path); @endphp
                    <tr>
                        <td class="px-4 py-3 align-top">
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-sky-700 hover:underline">{{ '/'.$page->old_path }}</a>
                        </td>
                        <td class="px-4 py-3 align-top">{{ $page->title }}</td>
                        <td class="px-4 py-3 align-top">
                            <div class="flex flex-wrap gap-1.5">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $page->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $page->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                                @if ($page->content_locked)
                                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">🔒 Verrouillé</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 align-top">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.legacy_pages.edit', $page) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50">Modifier</a>
                                <form method="post" action="{{ route('admin.legacy_pages.destroy', $page) }}" onsubmit="return confirm('Supprimer cette page legacy ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-300 bg-white px-3 py-1.5 text-xs font-extrabold text-red-700 hover:bg-red-50">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Aucune page legacy pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pages->links() }}
    </div>
@endsection

