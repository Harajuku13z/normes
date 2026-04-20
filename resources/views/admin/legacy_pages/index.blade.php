@extends('admin.layout')

@section('title', 'Pages legacy WordPress')

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Pages legacy WordPress</h1>
            <p class="mt-1 text-sm text-slate-600">
                Crée des pages 200 OK sur les anciennes URLs indexées (sans redirection).
                Les pages verrouillées 🔒 ne sont jamais écrasées par l'import.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            {{-- Bouton import WordPress --}}
            <form method="post" action="{{ route('admin.legacy_pages.import_wordpress') }}"
                  onsubmit="return confirm('Supprimer toutes les pages non verrouillées et relancer l\'import WordPress ? Cela peut prendre 1–2 minutes.')">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 px-4 py-2 text-sm font-extrabold text-white hover:bg-amber-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    Reimporter depuis WordPress
                </button>
            </form>
            <a href="{{ route('admin.legacy_pages.create') }}"
               class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                + Ajouter une page
            </a>
        </div>
    </div>

    {{-- Messages import --}}
    @if (session('import_status'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            ✅ {{ session('import_status') }}
        </div>
    @endif
    @if (session('import_error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
            ❌ {{ session('import_error') }}
        </div>
    @endif
    @if (session('status'))
        <div class="mb-5 rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-800">
            {{ session('status') }}
        </div>
    @endif

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

