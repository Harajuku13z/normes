@extends('admin.layout')

@section('title', 'Projets — Réalisations')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Projets (réalisations)</h1>
            <p class="mt-1 text-sm text-slate-600">Ordre d’affichage : champ « ordre » (nombre le plus petit en premier).</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.realisations.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                ← Hub Réalisations
            </a>
            <a href="{{ route('admin.portfolio_projects.create') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                Nouveau projet
            </a>
        </div>
    </div>

    @if ($projects->isEmpty())
        <p class="rounded-xl border border-slate-200 bg-white p-6 text-sm text-slate-600">Aucun projet pour le moment.</p>
    @else
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Ordre</th>
                        <th class="px-4 py-3">Titre</th>
                        <th class="px-4 py-3">Photos</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($projects as $p)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 font-mono text-slate-700">{{ $p->sort_order }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $p->title }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $p->images_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.portfolio_projects.edit', $p) }}" class="font-extrabold text-sky-700 hover:underline">Modifier</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
