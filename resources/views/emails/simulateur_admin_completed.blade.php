@php
    $footerPayload = optional(\App\Models\HomeSection::query()->where('key', 'footer')->first())->payload;
    $logoPath = trim((string) data_get($footerPayload, 'logo', '/logo.png'));
    $logoAlt = trim((string) data_get($footerPayload, 'logo_alt', 'Normes & Renovation'));
    $logoUrl = (str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://')) ? $logoPath : url('/'.ltrim($logoPath, '/'));
    $brandBlue = '#60B4F9';
    $brandYellow = '#FADF70';
    $brandDark = '#2F4251';
    $photoPath = collect((array) ($lead->photos ?? []))->map(fn ($p) => trim((string) $p))->first();
    $photoUrl = null;
    if ($photoPath) {
        $photoUrl = (str_starts_with($photoPath, 'http://') || str_starts_with($photoPath, 'https://'))
            ? $photoPath
            : url('/storage/'.ltrim($photoPath, '/'));
    }
    $recap = collect((array) $lead->selected_sub_services)->filter()->values();
    $project = $lead->sub_service ?: ($recap->first(fn ($item) => str_contains(mb_strtolower($item), 'projet')) ?? null);
    $panelCount = $recap->first(fn ($item) => str_contains(mb_strtolower($item), 'panneaux'));
    $kwc = $recap->first(fn ($item) => str_contains(mb_strtolower($item), 'kwc'));
    $yearlyKwh = $recap->first(fn ($item) => str_contains(mb_strtolower($item), 'kwh/an'));
    $savings = $recap->first(fn ($item) => str_contains(mb_strtolower($item), 'économies') || str_contains(mb_strtolower($item), 'economies'));
    $budget = $recap->first(fn ($item) => str_contains(mb_strtolower($item), 'budget'));
@endphp
<div style="margin:0;padding:24px;background:#eef4f8;font-family:Arial,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;margin:0 auto;background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
        <tr>
            <td style="padding:20px 24px;background:linear-gradient(135deg,{{ $brandDark }},{{ $brandBlue }});color:#ffffff;border-bottom:4px solid {{ $brandYellow }};">
                <img src="{{ $logoUrl }}" alt="{{ $logoAlt !== '' ? $logoAlt : 'Normes & Renovation' }}" style="height:42px;width:auto;display:block;margin-bottom:12px;">
                <div style="font-size:20px;font-weight:700;">Simulateur complété</div>
                <div style="font-size:13px;opacity:.92;margin-top:4px;">Un utilisateur a finalisé sa demande complète.</div>
            </td>
        </tr>
        <tr>
            <td style="padding:20px 24px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;width:170px;">ID lead</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">#{{ $lead->id }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Date</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ optional($lead->updated_at)->format('d/m/Y H:i') ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Nom et prénom</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->nom_prenom ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Téléphone</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->telephone ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Email</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->email ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Code postal</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->code_postal ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Surface</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->surface_m2 ?: '-' }} m²</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Services sélectionnés</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ collect((array) $lead->selected_services)->filter()->implode(', ') ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Sous-services sélectionnés</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ collect((array) $lead->selected_sub_services)->filter()->implode(', ') ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Message</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->message ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;font-weight:700;">Page source</td><td style="padding:8px 0;">{{ $lead->source_page ?: '-' }}</td></tr>
                </table>
                <div style="margin-top:18px;padding:16px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;">
                    <div style="font-size:14px;font-weight:700;margin-bottom:10px;">Lecture rapide de l'estimation</div>
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr><td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;width:170px;">Projet</td><td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">{{ $project ?: '-' }}</td></tr>
                        <tr><td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Panneaux prévus</td><td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">{{ $panelCount ?: '-' }}</td></tr>
                        <tr><td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Puissance estimée</td><td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">{{ $kwc ?: '-' }}</td></tr>
                        <tr><td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Production annuelle estimée</td><td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">{{ $yearlyKwh ?: '-' }}</td></tr>
                        <tr><td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Économies annuelles estimées</td><td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">{{ $savings ?: '-' }}</td></tr>
                        <tr><td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Fourchette de prix</td><td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">{{ $budget ?: '-' }}</td></tr>
                    </table>
                    <div style="margin-top:12px;font-size:13px;color:#64748b;line-height:1.6;">
                        Le budget reste indicatif. Il pourra évoluer selon la toiture, l'accès, le matériel retenu, les protections électriques et les options éventuelles.
                    </div>
                </div>
                @if ($recap->isNotEmpty())
                    <div style="margin-top:18px;padding:14px 16px;border:1px solid #e2e8f0;border-radius:12px;background:#f8fafc;">
                        <div style="font-size:13px;font-weight:700;margin-bottom:8px;">Récapitulatif technique</div>
                        <ul style="margin:0;padding-left:18px;color:#334155;font-size:13px;line-height:1.6;">
                            @foreach ($recap as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($photoUrl)
                    <div style="margin-top:18px;">
                        <div style="font-size:13px;font-weight:700;margin-bottom:8px;">Capture du projet</div>
                        <a href="{{ $photoUrl }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ $photoUrl }}" alt="Capture du simulateur solaire" style="display:block;width:100%;max-width:620px;height:auto;border-radius:12px;border:1px solid #dbe4ea;">
                        </a>
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding:14px 24px;background:#f8fafc;color:#64748b;font-size:12px;">
                Normes & Renovation — Notification simulateur
            </td>
        </tr>
    </table>
</div>
