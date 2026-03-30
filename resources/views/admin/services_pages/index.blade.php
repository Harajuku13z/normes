@extends('admin.layout')

@section('title', 'Services pages — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Services pages</h1>
            <p class="mt-1 text-sm text-slate-600">Pages dédiées pour chaque service (CTA vers page service).</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.services_pages.create') }}" class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                + Créer
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">
                    <th class="px-4 py-3">Service</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Actif</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $p)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3">
                            <div class="font-extrabold text-slate-900">{{ $p->title }}</div>
                            <div class="mt-1 text-xs font-mono text-slate-500">num: {{ $p->service_num ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm font-mono text-slate-700">{{ $p->slug }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="{{ $p->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} inline-flex rounded-full px-3 py-1 text-xs font-extrabold">
                                {{ $p->is_active ? 'Oui' : 'Non' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.services_pages.edit', $p) }}" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                                Modifier
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pages->links() }}
    </div>
@endsection

