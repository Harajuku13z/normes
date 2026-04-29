@extends('admin.layout')

@section('title', 'Leads simulateur')

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Leads simulateur</h1>
            <p class="mt-1 text-sm text-slate-500">Formulaires soumis via le simulateur de devis</p>
        </div>
        <span class="inline-flex items-center rounded-xl bg-blue-100 px-3 py-1.5 text-sm font-bold text-blue-700">
            {{ $leads->count() }} lead{{ $leads->count() > 1 ? 's' : '' }}
        </span>
    </div>

    @if ($leads->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
            </svg>
            <p class="mt-3 text-sm font-semibold text-slate-500">Aucun lead pour le moment.</p>
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
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Emails</th>
                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wide text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($leads as $lead)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">
                                {{ optional($lead->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $lead->nom_prenom ?: '—' }}
                                @if($lead->code_postal)
                                    <span class="ml-1 text-xs font-normal text-slate-400">{{ $lead->code_postal }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($lead->email)
                                    <a href="mailto:{{ $lead->email }}" class="block text-blue-600 hover:underline text-xs">{{ $lead->email }}</a>
                                @endif
                                @if($lead->telephone)
                                    <a href="tel:{{ $lead->telephone }}" class="block text-slate-600 text-xs mt-0.5">{{ $lead->telephone }}</a>
                                @endif
                                @if(!$lead->email && !$lead->telephone)
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-xs">
                                {{ $lead->service_title ?: ($lead->service_slug ?: '—') }}
                                @if($lead->surface_m2)
                                    <div class="text-slate-400">{{ $lead->surface_m2 }} m²</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($lead->completed_at)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700">
                                        <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                        Complété
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700">
                                        <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                                        En cours
                                    </span>
                                @endif
                                @if($lead->mail_error)
                                    <div class="mt-1 text-[10px] text-red-500 font-semibold">Erreur mail</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1.5 flex-wrap">
                                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold
                                        {{ $lead->admin_notified_completed_at ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        @if($lead->admin_notified_completed_at)
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                        @else
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                                        @endif
                                        Admin
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold
                                        {{ $lead->client_notified_at ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        @if($lead->client_notified_at)
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                        @else
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                                        @endif
                                        Client
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.simulateur_leads.show', $lead) }}"
                                   class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                                    Voir
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
