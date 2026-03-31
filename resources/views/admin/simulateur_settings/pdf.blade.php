<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simulator Lead #{{ $lead->id }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #0f172a; font-size: 12px; }
        h1 { margin: 0 0 8px; font-size: 20px; }
        h2 { margin: 18px 0 8px; font-size: 14px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; }
        td { border: 1px solid #e2e8f0; padding: 6px 8px; vertical-align: top; }
        .label { width: 220px; font-weight: bold; background: #f8fafc; }
        .muted { color: #475569; }
    </style>
</head>
<body>
    <h1>Simulator Lead #{{ $lead->id }}</h1>
    <p class="muted">
        Exported at {{ now()->format('d/m/Y H:i') }}
    </p>

    <h2>Status</h2>
    <table>
        <tr><td class="label">Created at</td><td>{{ optional($lead->created_at)->format('d/m/Y H:i') ?: '-' }}</td></tr>
        <tr><td class="label">Updated at</td><td>{{ optional($lead->updated_at)->format('d/m/Y H:i') ?: '-' }}</td></tr>
        <tr><td class="label">Status</td><td>{{ $lead->completed_at ? 'completed' : 'in_progress' }}</td></tr>
        <tr><td class="label">Source page</td><td>{{ $lead->source_page ?: '-' }}</td></tr>
    </table>

    <h2>Contact</h2>
    <table>
        <tr><td class="label">Nom et prenom</td><td>{{ $lead->nom_prenom ?: '-' }}</td></tr>
        <tr><td class="label">Email</td><td>{{ $lead->email ?: '-' }}</td></tr>
        <tr><td class="label">Telephone</td><td>{{ $lead->telephone ?: '-' }}</td></tr>
        <tr><td class="label">Code postal</td><td>{{ $lead->code_postal ?: '-' }}</td></tr>
        <tr><td class="label">Address</td><td>{{ $lead->address ?: '-' }}</td></tr>
        <tr><td class="label">Surface (m²)</td><td>{{ $lead->surface_m2 ?: '-' }}</td></tr>
    </table>

    <h2>Project</h2>
    <table>
        <tr><td class="label">Main service</td><td>{{ $lead->service_title ?: '-' }}</td></tr>
        <tr><td class="label">Main sub-service</td><td>{{ $lead->sub_service ?: '-' }}</td></tr>
        <tr><td class="label">Selected services</td><td>{{ collect((array) $lead->selected_services)->filter()->implode(', ') ?: '-' }}</td></tr>
        <tr><td class="label">Selected sub-services</td><td>{{ collect((array) $lead->selected_sub_services)->filter()->implode(', ') ?: '-' }}</td></tr>
        <tr><td class="label">Message</td><td>{{ $lead->message ?: '-' }}</td></tr>
    </table>

    <h2>Attachments</h2>
    <table>
        @php
            $files = collect((array) ($lead->photos ?? []))
                ->map(fn ($p) => trim((string) $p))
                ->filter(fn ($p) => $p !== '')
                ->values()
                ->all();
        @endphp
        @if ($files === [])
            <tr><td>No attachment uploaded.</td></tr>
        @else
            @foreach ($files as $path)
                @php
                    $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
                        ? $path
                        : (str_starts_with($path, 'storage/') ? asset(ltrim($path, '/')) : asset('storage/'.ltrim($path, '/')));
                @endphp
                <tr><td>{{ $url }}</td></tr>
            @endforeach
        @endif
    </table>
</body>
</html>
