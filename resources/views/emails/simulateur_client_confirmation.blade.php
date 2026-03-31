<div style="font-family:Arial,sans-serif;color:#0f172a;line-height:1.45">
    <h2 style="margin:0 0 12px">Your request has been received</h2>
    <p style="margin:0 0 8px">Hello {{ $lead->nom_prenom ?: 'there' }},</p>
    <p style="margin:0 0 8px">Thank you for your renovation simulation request. Our team will contact you shortly.</p>
    <p style="margin:0 0 8px"><strong>Phone:</strong> {{ $lead->telephone ?: '-' }}</p>
    <p style="margin:0 0 8px"><strong>Services:</strong> {{ collect((array) $lead->selected_services)->filter()->implode(', ') ?: '-' }}</p>
    <p style="margin:0 0 8px"><strong>Sub-services:</strong> {{ collect((array) $lead->selected_sub_services)->filter()->implode(', ') ?: '-' }}</p>
    <p style="margin:12px 0 0;color:#475569">Reference: #{{ $lead->id }}</p>
</div>
