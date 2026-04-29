@extends('admin.layout')

@section('title', 'Demande de ' . ($contactInquiry->nom_complet ?: 'inconnu'))

@section('content')
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.contact_inquiries.index') }}"
           class="flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Retour aux demandes
        </a>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">

        {{-- Infos principales --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-base font-extrabold text-slate-900">Coordonnées</h2>
                <dl class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nom complet</dt>
                        <dd class="mt-0.5 font-semibold text-slate-800">{{ $contactInquiry->nom_complet ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</dt>
                        <dd class="mt-0.5">
                            @if($contactInquiry->email)
                                <a href="mailto:{{ $contactInquiry->email }}" class="font-semibold text-blue-600 hover:underline">{{ $contactInquiry->email }}</a>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Téléphone</dt>
                        <dd class="mt-0.5">
                            @if($contactInquiry->telephone)
                                <a href="tel:{{ $contactInquiry->telephone }}" class="font-semibold text-slate-800 hover:text-blue-600">{{ $contactInquiry->telephone }}</a>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Code postal</dt>
                        <dd class="mt-0.5 font-semibold text-slate-800">{{ $contactInquiry->code_postal ?: '—' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Service demandé</dt>
                        <dd class="mt-0.5 font-semibold text-slate-800">{{ $contactInquiry->service ?: '—' }}</dd>
                    </div>
                </dl>
            </div>

            @if($contactInquiry->message)
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-3 text-base font-extrabold text-slate-900">Message</h2>
                    <p class="whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $contactInquiry->message }}</p>
                </div>
            @endif

            @if($contactInquiry->autres_infos)
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-3 text-base font-extrabold text-slate-900">Autres informations</h2>
                    <p class="whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $contactInquiry->autres_infos }}</p>
                </div>
            @endif

            @if(!empty($contactInquiry->photos))
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-3 text-base font-extrabold text-slate-900">Photos / Fichiers joints ({{ count($contactInquiry->photos) }})</h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($contactInquiry->photos as $photo)
                            <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                               class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                </svg>
                                {{ basename($photo) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar droite --}}
        <div class="space-y-5">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-400">Statut emails</h3>
                <ul class="space-y-2.5">
                    <li class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-700">Email admin</span>
                        @if($contactInquiry->admin_mail_sent)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                Envoyé
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-600">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                                Non envoyé
                            </span>
                        @endif
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-700">Email client</span>
                        @if($contactInquiry->client_mail_sent)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                Envoyé
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-500">
                                Non envoyé
                            </span>
                        @endif
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-400">Méta</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Reçu le</dt>
                        <dd class="font-semibold text-slate-800">{{ $contactInquiry->created_at->format('d/m/Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">À</dt>
                        <dd class="font-semibold text-slate-800">{{ $contactInquiry->created_at->format('H:i') }}</dd>
                    </div>
                    @if($contactInquiry->ip_address)
                        <div class="flex justify-between">
                            <dt class="text-slate-500">IP</dt>
                            <dd class="font-mono text-xs text-slate-600">{{ $contactInquiry->ip_address }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @if($contactInquiry->email)
                <a href="mailto:{{ $contactInquiry->email }}"
                   class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow hover:bg-blue-500 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                    </svg>
                    Répondre par email
                </a>
            @endif
        </div>
    </div>
@endsection
