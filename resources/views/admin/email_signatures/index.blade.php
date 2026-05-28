@extends('admin.layout')

@section('title', 'Signatures mail')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Signatures mail</h1>
            <p class="mt-2 max-w-3xl text-sm text-slate-600">
                Créez une signature HTML par collaborateur avec photo, coordonnées et aperçu prêt à copier dans Gmail.
            </p>
        </div>
        <a href="{{ route('admin.email_signatures.create') }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-extrabold text-white hover:bg-sky-700">
            + Nouvelle signature
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                    <th class="px-6 py-4">Collaborateur</th>
                    <th class="px-6 py-4">Coordonnées</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4">Prévisualisation</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($signatures as $signature)
                    @php
                        $photoUrl = \App\Support\HomeView::url($signature->photo_path);
                    @endphp
                    <tr class="align-top">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-slate-100">
                                    @if ($photoUrl !== '')
                                        <img src="{{ $photoUrl }}" alt="" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-sm font-black text-slate-500">
                                            {{ \Illuminate\Support\Str::of($signature->full_name)->explode(' ')->filter()->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))->take(2)->implode('') }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-900">{{ $signature->full_name }}</p>
                                    <p class="mt-1 text-sm text-slate-600">{{ $signature->role_title ?: 'Collaborateur' }}</p>
                                    <p class="mt-1 font-mono text-xs text-slate-400">/{{ $signature->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-700">
                            @if ($signature->email)
                                <p>{{ $signature->email }}</p>
                            @endif
                            @if ($signature->phone)
                                <p class="mt-1">{{ $signature->phone }}</p>
                            @endif
                            @if ($signature->location)
                                <p class="mt-1 text-slate-500">{{ $signature->location }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            @if ($signature->is_active)
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-extrabold text-emerald-700">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-extrabold text-slate-600">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            @if ($signature->is_active)
                                <a href="{{ route('email_signatures.show', $signature->slug) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                                    Ouvrir la preview
                                </a>
                            @else
                                <span class="text-sm text-slate-400">Signature non publiée</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end gap-2">
                                @if ($signature->is_active)
                                    <a href="{{ route('email_signatures.html', $signature->slug) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                                        Code HTML
                                    </a>
                                    <a href="{{ route('email_signatures.download', $signature->slug) }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                                        Télécharger
                                    </a>
                                @endif
                                <a href="{{ route('admin.email_signatures.edit', $signature) }}" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                                    Modifier
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                            Aucune signature pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
