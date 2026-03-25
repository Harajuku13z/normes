@extends('admin.layout')

@section('title', 'Sections — Admin')

@section('content')
    <h1 class="text-2xl font-extrabold text-slate-900">Sections de la page d'accueil</h1>
    <p class="mt-2 max-w-2xl text-sm text-slate-600">Chaque bloc correspond à un objet JSON. Les modifications remplacent les valeurs par défaut pour cette section.</p>
    <ul class="mt-8 divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white">
        @foreach ($keys as $key)
            <li class="flex flex-wrap items-center justify-between gap-3 px-4 py-4 sm:px-5">
                <div>
                    <p class="font-bold text-slate-900">{{ $labels[$key] ?? $key }}</p>
                    <p class="text-xs font-mono text-slate-500">{{ $key }}</p>
                    @if (isset($saved[$key]))
                        <p class="mt-1 text-xs text-slate-500">
                            Dernière mise à jour :
                            @if (is_object($saved[$key]) && method_exists($saved[$key], 'diffForHumans'))
                                {{ $saved[$key]->diffForHumans() }}
                            @else
                                {{ $saved[$key] }}
                            @endif
                        </p>
                    @endif
                </div>
                <a href="{{ route('admin.section.edit', $key) }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">Modifier</a>
            </li>
        @endforeach
    </ul>
@endsection
