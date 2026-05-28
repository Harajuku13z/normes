<?php

namespace App\Support;

use App\Models\EmailSignature;

final class EmailSignaturePresenter
{
    public static function toViewData(EmailSignature $signature): array
    {
        $fullName = trim((string) $signature->full_name);
        $websiteUrl = trim((string) ($signature->website_url ?: config('app.url') ?: url('/')));
        [$nameLeading, $nameAccent] = self::splitName($fullName);
        $socialItems = self::socialItems($signature, $websiteUrl);
        $footer = HomePageDefaults::all()['footer'] ?? [];
        $footerAddress = implode(', ', array_filter(array_map('strval', (array) ($footer['address_lines'] ?? []))));
        $footerLegal = trim((string) ($footer['legal'] ?? ''));
        $agencyPhone = trim((string) ($footer['phone'] ?? ''));
        $email = trim((string) ($signature->email ?: ($footer['email'] ?? '')));
        $phone = trim((string) ($signature->phone ?: ($footer['phone'] ?? '')));

        return [
            'fullName' => $fullName,
            'nameLeading' => $nameLeading,
            'nameAccent' => $nameAccent,
            'roleTitle' => trim((string) ($signature->role_title ?: 'Collaborateur')),
            'companyName' => 'Normes Rénovation',
            'email' => $email,
            'emailHref' => $email !== '' ? 'mailto:'.$email : '',
            'phone' => $phone,
            'phoneHref' => $phone !== '' ? 'tel:'.preg_replace('/[^\d+]/', '', $phone) : '',
            'location' => trim((string) ($signature->location ?: 'Chalon-sur-Saône')),
            'websiteUrl' => $websiteUrl,
            'websiteLabel' => self::websiteLabel($websiteUrl),
            'tagline' => trim((string) ($signature->tagline ?: "Toiture, façade, isolation et rénovation de l'habitat.")),
            'photoUrl' => HomeView::url($signature->photo_path),
            'photoAlt' => $fullName !== '' ? 'Portrait de '.$fullName.' pour la signature mail Normes Rénovation' : 'Photo collaborateur Normes Rénovation',
            'logoUrl' => HomeView::url('signatures/assets/logo-normes-renovation.png'),
            'logoAlt' => 'Logo Normes Rénovation',
            'rgeUrl' => HomeView::url('signatures/assets/logo-rge-qualibat.png'),
            'rgeAlt' => 'Logo RGE Qualibat Normes Rénovation',
            'initials' => self::initials($fullName),
            'socialItems' => $socialItems,
            'footerAddress' => $footerAddress !== '' ? $footerAddress : '6 rue Pierre de Coubertin, 71100 Chalon-sur-Saône',
            'footerLegal' => $footerLegal !== '' ? $footerLegal : "RCS Chalon-sur-Saône — 900 571 696 00013 · SIREN 900 571 696 · SIRET (siège) 900 571 696 00013 · TVA FR96 900 571 696",
            'agencyPhone' => $agencyPhone !== '' ? $agencyPhone : '03 85 41 98 86',
            'agencyPhoneHref' => $agencyPhone !== '' ? 'tel:'.preg_replace('/[^\d+]/', '', $agencyPhone) : 'tel:+33385419886',
            'previewUrl' => route('email_signatures.show', $signature->slug),
            'htmlUrl' => route('email_signatures.html', $signature->slug),
        ];
    }

    public static function renderHtml(EmailSignature $signature): string
    {
        return view('signatures.snippet', self::toViewData($signature))->render();
    }

    public static function renderDocumentHtml(EmailSignature $signature): string
    {
        $snippet = self::renderHtml($signature);
        $fullName = trim((string) $signature->full_name);
        $title = $fullName !== '' ? 'Signature mail '.$fullName.' | Normes Rénovation' : 'Signature mail | Normes Rénovation';

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
</head>
<body style="margin:0;padding:24px;background:#ffffff;font-family:Arial,sans-serif;">
{$snippet}
</body>
</html>
HTML;
    }

    private static function initials(string $fullName): string
    {
        $parts = preg_split('/\s+/u', trim($fullName)) ?: [];
        $letters = [];

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }
            $letters[] = mb_strtoupper(mb_substr($part, 0, 1));
            if (count($letters) === 2) {
                break;
            }
        }

        return $letters !== [] ? implode('', $letters) : 'NR';
    }

    private static function websiteLabel(string $websiteUrl): string
    {
        $label = preg_replace('#^https?://#i', '', trim($websiteUrl));
        $label = preg_replace('#/$#', '', (string) $label);

        return $label !== '' ? $label : 'normesrenovation.fr';
    }

    /**
     * @return array{0:string,1:string}
     */
    private static function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/u', trim($fullName)) ?: [];
        $parts = array_values(array_filter($parts, fn ($part) => $part !== ''));

        if ($parts === []) {
            return ['NORMES', 'RÉNOVATION'];
        }

        if (count($parts) === 1) {
            return [mb_strtoupper($parts[0]), ''];
        }

        $accent = array_pop($parts);
        $leading = implode(' ', $parts);

        return [mb_strtoupper($leading), mb_strtoupper((string) $accent)];
    }

    /**
     * @return array<int, array{network:string,url:string,label:string,iconUrl:string}>
     */
    private static function socialItems(EmailSignature $signature, string $websiteUrl): array
    {
        $items = [
            [
                'network' => 'facebook',
                'url' => trim((string) ($signature->facebook_url ?: '')),
                'label' => 'Facebook',
                'iconUrl' => HomeView::url('signatures/assets/facebook.png'),
            ],
            [
                'network' => 'instagram',
                'url' => trim((string) ($signature->instagram_url ?: '')),
                'label' => 'Instagram',
                'iconUrl' => HomeView::url('signatures/assets/instagram.png'),
            ],
            [
                'network' => 'linkedin',
                'url' => trim((string) ($signature->linkedin_url ?: '')),
                'label' => 'LinkedIn',
                'iconUrl' => HomeView::url('signatures/assets/linkedin.png'),
            ],
        ];

        $hasAtLeastOneRealLink = false;
        foreach ($items as $item) {
            if ($item['url'] !== '') {
                $hasAtLeastOneRealLink = true;
                break;
            }
        }

        return array_map(function (array $item) use ($websiteUrl, $hasAtLeastOneRealLink): array {
            if (! $hasAtLeastOneRealLink && $item['url'] === '') {
                $item['url'] = $websiteUrl;
            }

            return $item;
        }, $items);
    }
}
