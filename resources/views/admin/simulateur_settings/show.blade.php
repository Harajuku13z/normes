@extends('admin.layout')

@section('title', 'Simulator Lead Details')

@section('content')
    @php
        $photos = collect((array) ($lead->photos ?? []))
            ->map(fn ($p) => trim((string) $p))
            ->filter(fn ($p) => $p !== '')
            ->map(function (string $path): array {
                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                    $url = $path;
                } elseif (str_starts_with($path, 'storage/')) {
                    $url = asset(ltrim($path, '/'));
                } else {
                    $url = asset('storage/'.ltrim($path, '/'));
                }
                $lower = strtolower($path);
                $isImage = str_ends_with($lower, '.jpg') || str_ends_with($lower, '.jpeg') || str_ends_with($lower, '.png') || str_ends_with($lower, '.webp') || str_ends_with($lower, '.gif');

                return [
                    'path' => $path,
                    'url' => $url,
                    'is_image' => $isImage,
                ];
            })
            ->values()
            ->all();
    @endphp

    <div class="space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Lead #{{ $lead->id }}</h1>
                <p class="mt-1 text-sm text-slate-600">All submitted data for this simulator lead.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.simulateur_leads.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Back to leads
                </a>
                <a href="{{ route('admin.simulateur_leads.pdf', $lead) }}" class="inline-flex items-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-rose-700">
                    Export PDF
                </a>
            </div>
        </div>

        <section class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2">
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Date</span><p class="mt-1 font-semibold text-slate-800">{{ optional($lead->created_at)->format('d/m/Y H:i') ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Status</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->completed_at ? 'completed' : 'in_progress' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Source page</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->source_page ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Last update</span><p class="mt-1 font-semibold text-slate-800">{{ optional($lead->updated_at)->format('d/m/Y H:i') ?: '-' }}</p></div>
        </section>

        <section class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2">
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Nom et prenom</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->nom_prenom ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Code postal</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->code_postal ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Telephone</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->telephone ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Email</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->email ?: '-' }}</p></div>
            <div class="sm:col-span-2"><span class="text-xs uppercase tracking-wide text-slate-500">Address</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->address ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Surface (m²)</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->surface_m2 ?: '-' }}</p></div>
        </section>

        <section class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2">
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Main service</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->service_title ?: '-' }}</p></div>
            <div><span class="text-xs uppercase tracking-wide text-slate-500">Main sub-service</span><p class="mt-1 font-semibold text-slate-800">{{ $lead->sub_service ?: '-' }}</p></div>
            <div class="sm:col-span-2">
                <span class="text-xs uppercase tracking-wide text-slate-500">Selected services</span>
                <p class="mt-1 font-semibold text-slate-800">{{ collect((array) $lead->selected_services)->filter()->implode(', ') ?: '-' }}</p>
            </div>
            <div class="sm:col-span-2">
                <span class="text-xs uppercase tracking-wide text-slate-500">Selected sub-services</span>
                <p class="mt-1 font-semibold text-slate-800">{{ collect((array) $lead->selected_sub_services)->filter()->implode(', ') ?: '-' }}</p>
            </div>
            <div class="sm:col-span-2">
                <span class="text-xs uppercase tracking-wide text-slate-500">Message</span>
                <p class="mt-1 whitespace-pre-line font-semibold text-slate-800">{{ $lead->message ?: '-' }}</p>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Attachments</h2>
            @if ($photos === [])
                <p class="mt-2 text-sm text-slate-500">No attachment uploaded.</p>
            @else
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    @foreach ($photos as $file)
                        @if ($file['is_image'])
                            <a href="{{ $file['url'] }}" target="_blank" rel="noopener noreferrer" class="block overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                <img src="{{ $file['url'] }}" alt="Attachment image" class="h-52 w-full object-cover">
                            </a>
                        @else
                            <a href="{{ $file['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex w-fit items-center rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                Open file
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
