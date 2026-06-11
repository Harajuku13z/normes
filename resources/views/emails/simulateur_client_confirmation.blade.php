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
            <td style="padding:20px 24px;background:linear-gradient(135deg,{{ $brandDark }},{{ $brandBlue }});color:#ffffff;text-align:center;border-bottom:4px solid {{ $brandYellow }};">
                <img src="{{ $logoUrl }}" alt="{{ $logoAlt !== '' ? $logoAlt : 'Normes & Renovation' }}" style="height:44px;width:auto;display:block;margin:0 auto 12px;">
                <div style="font-size:22px;font-weight:700;">Votre demande a bien été reçue</div>
                <div style="font-size:13px;opacity:.92;margin-top:4px;">Merci de votre confiance.</div>
            </td>
        </tr>
        <tr>
            <td style="padding:22px 24px;">
                <p style="margin:0 0 10px;font-size:15px;">Bonjour {{ $lead->nom_prenom ?: '' }},</p>
                <p style="margin:0 0 16px;font-size:14px;color:#334155;">
                    Nous avons bien reçu votre demande via le simulateur de rénovation. Un conseiller vous recontactera rapidement pour confirmer les prochaines étapes.
                </p>
                <div style="margin:0 0 16px;padding:14px 16px;border:1px solid #dbeafe;border-radius:12px;background:#f7fbff;color:#334155;font-size:13px;line-height:1.65;">
                    Voici un résumé simple de votre simulation. Ces chiffres servent de première estimation pour vous donner un ordre d'idée. Ils pourront être ajustés après étude de votre toiture, du matériel retenu et des conditions réelles du chantier.
                </div>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;width:170px;">Référence</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">#{{ $lead->id }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Téléphone</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ $lead->telephone ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-weight:700;">Services sélectionnés</td><td style="padding:8px 0;border-bottom:1px solid #e2e8f0;">{{ collect((array) $lead->selected_services)->filter()->implode(', ') ?: '-' }}</td></tr>
                    <tr><td style="padding:8px 0;font-weight:700;">Sous-services sélectionnés</td><td style="padding:8px 0;">{{ collect((array) $lead->selected_sub_services)->filter()->implode(', ') ?: '-' }}</td></tr>
                </table>
                <div style="margin-top:18px;padding:16px;border:1px solid #e2e8f0;border-radius:12px;background:#ffffff;">
                    <div style="font-size:14px;font-weight:700;margin-bottom:10px;">Ce que signifie votre estimation</div>
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;width:170px;">Type de projet</td>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">
                                {{ $project ?: '-' }}<br>
                                <span style="color:#64748b;">Cela indique la façon dont votre future installation pourrait être utilisée chez vous.</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Panneaux prévus</td>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">
                                {{ $panelCount ?: '-' }}<br>
                                <span style="color:#64748b;">C'est le nombre de panneaux qui semble pouvoir être installé dans la zone que vous avez tracée.</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Puissance estimée</td>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">
                                {{ $kwc ?: '-' }}<br>
                                <span style="color:#64748b;">Cette puissance correspond à la taille globale de l'installation envisagée.</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Production annuelle estimée</td>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">
                                {{ $yearlyKwh ?: '-' }}<br>
                                <span style="color:#64748b;">C'est une estimation de l'énergie que l'installation pourrait produire sur une année complète.</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Économies annuelles estimées</td>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">
                                {{ $savings ?: '-' }}<br>
                                <span style="color:#64748b;">Cela correspond au gain annuel possible, selon votre consommation et les conditions réelles d'exploitation.</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-weight:700;">Fourchette de prix estimative</td>
                            <td style="padding:10px 0;border-top:1px solid #eef2f7;font-size:13px;color:#334155;">
                                {{ $budget ?: '-' }}<br>
                                <span style="color:#64748b;">C'est une fourchette indicative du coût possible de l'installation. Le montant final dépendra notamment du type de toiture, de l'accès au chantier, du matériel retenu et des options choisies.</span>
                            </td>
                        </tr>
                    </table>
                </div>
                @if ($photoUrl)
                    <div style="margin-top:18px;">
                        <div style="font-size:13px;font-weight:700;margin-bottom:8px;">Votre projet en image</div>
                        <a href="{{ $photoUrl }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ $photoUrl }}" alt="Capture de votre projet solaire" style="display:block;width:100%;max-width:620px;height:auto;border-radius:12px;border:1px solid #dbe4ea;">
                        </a>
                    </div>
                @endif
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
                <div style="margin-top:20px;">
                    <a href="{{ url('/contact') }}" style="display:inline-block;background:{{ $brandBlue }};color:#ffffff;text-decoration:none;font-weight:700;padding:10px 16px;border-radius:8px;">
                        Contacter l'équipe
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 24px;background:#f8fafc;color:#64748b;font-size:12px;text-align:center;">
                Normes & Renovation — Ceci est un email automatique de confirmation.
            </td>
        </tr>
    </table>
</div>
