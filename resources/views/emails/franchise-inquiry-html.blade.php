@php
    $footerPayload = optional(\App\Models\HomeSection::query()->where('key', 'footer')->first())->payload;
    $logoPath = trim((string) data_get($footerPayload, 'logo', '/logo.png'));
    $logoAlt  = trim((string) data_get($footerPayload, 'logo_alt', 'Normes & Renovation'));
    $logoUrl  = (str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://')) ? $logoPath : url('/'.ltrim($logoPath, '/'));
    $brandBlue   = '#60B4F9';
    $brandYellow = '#FADF70';
    $brandDark   = '#2F4251';
@endphp
<div style="margin:0;padding:24px;background:#eef4f8;font-family:Arial,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;margin:0 auto;background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
        <tr>
            <td style="padding:20px 24px;background:linear-gradient(135deg,{{ $brandDark }},{{ $brandBlue }});color:#ffffff;text-align:center;border-bottom:4px solid {{ $brandYellow }};">
                <img src="{{ $logoUrl }}" alt="{{ $logoAlt !== '' ? $logoAlt : 'Normes & Renovation' }}" style="height:44px;width:auto;display:block;margin:0 auto 12px;">
                <div style="font-size:22px;font-weight:700;">Nouvelle candidature Franchise</div>
                <div style="font-size:13px;opacity:.92;margin-top:4px;">Reçue le {{ now()->format('d/m/Y à H:i') }}</div>
            </td>
        </tr>
        <tr>
            <td style="padding:22px 24px;">
                <p style="margin:0 0 16px;font-size:15px;font-weight:700;color:{{ $brandDark }};">Informations du candidat :</p>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:14px;">
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;width:200px;color:#475569;">Nom</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->name ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Email</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">
                            @if($inquiry->email)
                                <a href="mailto:{{ $inquiry->email }}" style="color:{{ $brandBlue }};text-decoration:none;">{{ $inquiry->email }}</a>
                            @else -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Téléphone</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">
                            @if($inquiry->phone)
                                <a href="tel:{{ $inquiry->phone }}" style="color:{{ $brandBlue }};text-decoration:none;">{{ $inquiry->phone }}</a>
                            @else -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Code postal</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->postal_code ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Activité indépendante</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->has_independent_activity ? 'Oui' : 'Non' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Secteur géographique</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->geographic_sector ?: '-' }}</td>
                    </tr>
                    @if($inquiry->personal_contribution)
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Apport personnel</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->personal_contribution }}</td>
                    </tr>
                    @endif
                </table>

                @if($inquiry->message)
                <div style="margin-top:20px;padding:14px 16px;background:#f8fafc;border-left:4px solid {{ $brandBlue }};border-radius:6px;">
                    <p style="margin:0 0 6px;font-weight:700;font-size:13px;color:#475569;text-transform:uppercase;letter-spacing:.05em;">Message</p>
                    <p style="margin:0;font-size:14px;line-height:1.6;white-space:pre-wrap;">{{ $inquiry->message }}</p>
                </div>
                @endif

                <div style="margin-top:22px;">
                    <a href="mailto:{{ $inquiry->email }}" style="display:inline-block;background:{{ $brandBlue }};color:#ffffff;text-decoration:none;font-weight:700;padding:10px 20px;border-radius:8px;font-size:14px;">
                        Contacter le candidat
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 24px;background:#f8fafc;color:#64748b;font-size:12px;text-align:center;">
                Normes &amp; Renovation — Candidature #{{ $inquiry->id }} reçue le {{ $inquiry->created_at?->format('d/m/Y à H:i') }}
            </td>
        </tr>
    </table>
</div>
