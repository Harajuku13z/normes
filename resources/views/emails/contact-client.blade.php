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
                <div style="font-size:22px;font-weight:700;">Votre demande a bien été reçue</div>
                <div style="font-size:13px;opacity:.92;margin-top:4px;">Merci de votre confiance.</div>
            </td>
        </tr>
        <tr>
            <td style="padding:22px 24px;">
                <p style="margin:0 0 12px;font-size:15px;">Bonjour {{ $inquiry->nom_complet ?: '' }},</p>
                <p style="margin:0 0 18px;font-size:14px;color:#334155;line-height:1.6;">
                    Nous avons bien reçu votre message et nous vous en remercions. Un conseiller de notre équipe prendra contact avec vous dans les meilleurs délais pour répondre à votre demande.
                </p>

                <p style="margin:0 0 8px;font-weight:700;font-size:14px;color:{{ $brandDark }};">Récapitulatif de votre demande :</p>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:14px;">
                    @if($inquiry->telephone)
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;width:170px;color:#475569;">Téléphone</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->telephone }}</td>
                    </tr>
                    @endif
                    @if($inquiry->code_postal)
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Code postal</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->code_postal }}</td>
                    </tr>
                    @endif
                    @if($inquiry->service)
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Service</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $inquiry->service }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:8px 0;font-weight:700;color:#475569;">Référence</td>
                        <td style="padding:8px 0;">#{{ $inquiry->id }}</td>
                    </tr>
                </table>

                @if($inquiry->message)
                <div style="margin-top:18px;padding:14px 16px;background:#f8fafc;border-left:4px solid {{ $brandBlue }};border-radius:6px;">
                    <p style="margin:0 0 6px;font-weight:700;font-size:13px;color:#475569;text-transform:uppercase;letter-spacing:.05em;">Votre message</p>
                    <p style="margin:0;font-size:14px;line-height:1.6;color:#334155;white-space:pre-wrap;">{{ $inquiry->message }}</p>
                </div>
                @endif

                <div style="margin-top:24px;padding:16px;background:linear-gradient(135deg,#eef4f8,#dbeafe);border-radius:10px;text-align:center;">
                    <p style="margin:0 0 4px;font-weight:700;font-size:15px;color:{{ $brandDark }};">Besoin d'une réponse rapide ?</p>
                    <p style="margin:0 0 12px;font-size:13px;color:#475569;">Appelez-nous directement ou utilisez notre simulateur de devis en ligne.</p>
                    <a href="{{ url('/simulateur') }}" style="display:inline-block;background:{{ $brandBlue }};color:#ffffff;text-decoration:none;font-weight:700;padding:10px 20px;border-radius:8px;font-size:14px;">
                        Simulateur gratuit
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 24px;background:#f8fafc;color:#64748b;font-size:12px;text-align:center;">
                Normes &amp; Renovation — Ceci est un email automatique de confirmation. Ne pas répondre à cet email.
            </td>
        </tr>
    </table>
</div>
