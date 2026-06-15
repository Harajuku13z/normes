@php
    $footerPayload = optional(\App\Models\HomeSection::query()->where('key', 'footer')->first())->payload;
    $logoPath = trim((string) data_get($footerPayload, 'logo', '/logo.png'));
    $logoAlt  = trim((string) data_get($footerPayload, 'logo_alt', 'Normes & Renovation'));
    $logoUrl  = (str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://')) ? $logoPath : url('/'.ltrim($logoPath, '/'));
    $brandBlue   = '#60B4F9';
    $brandYellow = '#FADF70';
    $brandDark   = '#2F4251';
    $recap = collect((array) $lead->selected_sub_services)->filter()->values();
@endphp
<div style="margin:0;padding:24px;background:#eef4f8;font-family:Arial,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;margin:0 auto;background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
        <tr>
            <td style="padding:20px 24px;background:linear-gradient(135deg,{{ $brandDark }},{{ $brandBlue }});color:#ffffff;text-align:center;border-bottom:4px solid {{ $brandYellow }};">
                <img src="{{ $logoUrl }}" alt="{{ $logoAlt !== '' ? $logoAlt : 'Normes & Renovation' }}" style="height:44px;width:auto;display:block;margin:0 auto 12px;">
                <div style="font-size:22px;font-weight:700;">Merci de nous avoir contacté !</div>
                <div style="font-size:13px;opacity:.92;margin-top:4px;">Nous avons bien reçu votre demande.</div>
            </td>
        </tr>
        <tr>
            <td style="padding:28px 24px;">
                <p style="margin:0 0 12px;font-size:15px;">Bonjour {{ $lead->nom_prenom ?: '' }},</p>
                <p style="margin:0 0 20px;font-size:14px;color:#334155;line-height:1.65;">
                    Votre demande de rappel a bien été enregistrée. Un conseiller Normes Rénovation vous recontactera très prochainement afin de répondre à toutes vos questions sur votre projet photovoltaïque.
                </p>

                <div style="padding:16px 20px;border-left:4px solid {{ $brandBlue }};background:#f0f8ff;border-radius:0 10px 10px 0;margin:0 0 20px;font-size:13px;color:#334155;line-height:1.65;">
                    <strong>Récapitulatif de votre demande :</strong><br>
                    Nom : {{ $lead->nom_prenom ?: '-' }}<br>
                    Téléphone : {{ $lead->telephone ?: '-' }}<br>
                    Adresse : {{ $lead->address ?: '-' }}<br>
                    Référence : #{{ $lead->id }}
                </div>

                @if ($recap->isNotEmpty())
                <div style="margin:0 0 20px;padding:14px 16px;border:1px solid #e2e8f0;border-radius:12px;background:#f8fafc;">
                    <div style="font-size:13px;font-weight:700;margin-bottom:8px;">Votre simulation en résumé</div>
                    <ul style="margin:0;padding-left:18px;color:#334155;font-size:13px;line-height:1.7;">
                        @foreach ($recap as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <p style="margin:0 0 20px;font-size:13px;color:#64748b;line-height:1.6;">
                    En attendant, n'hésitez pas à consulter notre site pour en apprendre davantage sur nos solutions solaires.
                </p>

                <div>
                    <a href="{{ url('/contact') }}" style="display:inline-block;background:{{ $brandBlue }};color:#ffffff;text-decoration:none;font-weight:700;padding:11px 20px;border-radius:8px;font-size:14px;">
                        Nous contacter
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 24px;background:#f8fafc;color:#64748b;font-size:12px;text-align:center;border-top:1px solid #e2e8f0;">
                Normes Rénovation — Cet e-mail est une confirmation automatique de votre demande de contact.
            </td>
        </tr>
    </table>
</div>
