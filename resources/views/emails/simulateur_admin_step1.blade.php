<div style="font-family:Arial,sans-serif;color:#0f172a;line-height:1.45">
    <h2 style="margin:0 0 12px">New simulator lead started</h2>
    <p style="margin:0 0 8px"><strong>Name:</strong> {{ $lead->nom_prenom ?: '-' }}</p>
    <p style="margin:0 0 8px"><strong>Phone:</strong> {{ $lead->telephone ?: '-' }}</p>
    <p style="margin:0 0 8px"><strong>Email:</strong> {{ $lead->email ?: '-' }}</p>
    <p style="margin:0 0 8px"><strong>Postal code:</strong> {{ $lead->code_postal ?: '-' }}</p>
    <p style="margin:0 0 8px"><strong>Surface:</strong> {{ $lead->surface_m2 ?: '-' }} m²</p>
    <p style="margin:0 0 8px"><strong>Source page:</strong> {{ $lead->source_page ?: '-' }}</p>
    <p style="margin:12px 0 0;color:#475569">Lead ID: #{{ $lead->id }} — {{ optional($lead->created_at)->format('d/m/Y H:i') }}</p>
</div>
