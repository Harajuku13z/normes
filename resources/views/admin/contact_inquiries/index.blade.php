@extends('admin.layout')

@section('title', 'Demandes de contact')

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Demandes de contact</h1>
            <p class="mt-1 text-sm text-slate-500">Formulaires soumis via la page <code class="rounded bg-slate-100 px-1 text-xs">/contact</code></p>
        </div>
        <span class="inline-flex items-center rounded-xl bg-blue-100 px-3 py-1.5 text-sm font-bold text-blue-700">
            {{ $inquiries->total() }} demande{{ $inquiries->total() > 1 ? 's' : '' }}
        </span>
    </div>

    @if ($inquiries->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
            </svg>
            <p class="mt-3 text-sm font-semibold text-slate-500">Aucune demande de contact pour le moment.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Nom</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Service</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Emails</th>
                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($inquiries as $inquiry)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">
                                {{ $inquiry->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $inquiry->nom_complet ?: '—' }}
                                @if($inquiry->code_postal)
                                    <span class="ml-1 text-xs font-normal text-slate-400">{{ $inquiry->code_postal }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($inquiry->email)
                                    <a href="mailto:{{ $inquiry->email }}" class="block text-blue-600 hover:underline text-xs">{{ $inquiry->email }}</a>
                                @endif
                                @if($inquiry->telephone)
                                    <a href="tel:{{ $inquiry->telephone }}" class="block text-slate-600 text-xs mt-0.5">{{ $inquiry->telephone }}</a>
                                @endif
                                @if(!$inquiry->email && !$inquiry->telephone)
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-xs">
                                {{ $inquiry->service ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1.5 flex-wrap">
                                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold
                                        {{ $inquiry->admin_mail_sent ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                                        @if($inquiry->admin_mail_sent)
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                        @else
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                                        @endif
                                        Admin
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold
                                        {{ $inquiry->client_mail_sent ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        @if($inquiry->client_mail_sent)
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                        @else
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                                        @endif
                                        Client
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contact_inquiries.show', $inquiry) }}"
                                       class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                                        Voir
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </a>
                                    <form method="post" action="{{ route('admin.contact_inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Supprimer cette demande de contact ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 transition-colors hover:bg-red-100">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $inquiries->links() }}
        </div>
    @endif
@endsection
