@extends('admin.layout')

@section('title', 'Blog — Admin')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Articles (Blog)</h1>
            <p class="mt-1 text-sm text-slate-600">Créez, publiez et optimisez vos articles (SEO + image mise en avant).</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.blog_posts.create') }}" class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                + Nouvel article
            </a>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-extrabold uppercase tracking-wide text-slate-600">
            <tr>
                <th class="px-4 py-3">Titre</th>
                <th class="px-4 py-3">Slug</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3">Publié</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
            @forelse ($posts as $post)
                @php
                    $isPublished = $post->published_at && $post->published_at->isPast();
                @endphp
                <tr class="hover:bg-slate-50/60">
                    <td class="px-4 py-3">
                        <p class="font-extrabold text-slate-900">{{ $post->title }}</p>
                        @if (trim((string) $post->excerpt) !== '')
                            <p class="mt-1 line-clamp-1 text-xs text-slate-500">{{ $post->excerpt }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $post->slug }}</td>
                    <td class="px-4 py-3">
                        @if ($isPublished)
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700 ring-1 ring-emerald-200">Publié</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-extrabold text-amber-800 ring-1 ring-amber-200">Brouillon</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-600">
                        {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : '—' }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.blog_posts.edit', $post) }}" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50">Éditer</a>
                            @if ($isPublished)
                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" rel="noopener" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50">Voir</a>
                            @endif
                            <form action="{{ route('admin.blog_posts.destroy', $post) }}" method="post" onsubmit="return confirm('Supprimer cet article ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-extrabold text-red-700 hover:bg-red-100">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-8 text-center text-sm text-slate-600" colspan="5">Aucun article.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@endsection

