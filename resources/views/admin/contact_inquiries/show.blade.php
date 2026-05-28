@extends('admin.layout')

@section('title', 'Demande de ' . ($contactInquiry->nom_complet ?: 'inconnu'))

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.contact_inquiries.index') }}"
           class="flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Retour aux demandes
        </a>
        <form method="post" action="{{ route('admin.contact_inquiries.destroy', $contactInquiry) }}" onsubmit="return confirm('Supprimer définitivement cette demande ?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-extrabold text-red-700 shadow-sm transition hover:bg-red-100">
                Supprimer la demande
            </button>
        </form>
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
                @php
                    $imageExts = ['jpg','jpeg','png','gif','webp'];
                @endphp
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-4 text-base font-extrabold text-slate-900">
                        Photos / Fichiers joints
                        <span class="ml-2 text-sm font-normal text-slate-400">({{ count($contactInquiry->photos) }})</span>
                    </h2>

                    {{-- Images affichées directement --}}
                    @php $images = array_filter($contactInquiry->photos, fn($p) => in_array(strtolower(pathinfo($p, PATHINFO_EXTENSION)), $imageExts)); @endphp
                    @if(count($images))
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 mb-4">
                            @foreach($images as $photo)
                                <a href="{{ asset('storage/' . $photo) }}" target="_blank" rel="noopener"
                                   class="group relative block overflow-hidden rounded-xl border border-slate-200 bg-slate-100 aspect-square hover:border-blue-400 transition-colors">
                                    <img src="{{ asset('storage/' . $photo) }}"
                                         alt="Photo contact"
                                         class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-105"
                                         loading="lazy">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 opacity-0 transition group-hover:bg-black/20 group-hover:opacity-100">
                                        <svg class="h-7 w-7 text-white drop-shadow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Fichiers non-image (PDF, DOC, HEIC non converti…) --}}
                    @php $files = array_filter($contactInquiry->photos, fn($p) => !in_array(strtolower(pathinfo($p, PATHINFO_EXTENSION)), $imageExts)); @endphp
                    @if(count($files))
                        <div class="flex flex-wrap gap-2">
                            @foreach($files as $photo)
                                @php $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION)); @endphp
                                <a href="{{ asset('storage/' . $photo) }}" target="_blank" rel="noopener"
                                   class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
                                    @if($ext === 'pdf')
                                        <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5V8H18.5L13 3.5zM8.5 17H8v1.5H6.5V14H8.5a2 2 0 0 1 0 4v-1zm5.5-.5H12.5V14H15v1h-1.5v.5H15V17h-1.5V18.5H12V14h2a1.5 1.5 0 0 1 0 3zm4-1.5H17v3.5h-1.5V14H18v1.5z"/></svg>
                                    @else
                                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                        </svg>
                                    @endif
                                    {{ basename($photo) }}
                                    <span class="uppercase text-slate-400">{{ $ext }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
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
