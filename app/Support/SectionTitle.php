<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Découpe un titre pour affichage deux tons (comme sur la home : accent bleu + corps foncé).
 * Convention : séparateur "|" (prioritaire) ou virgule ", " une fois (ex. "Partie une, partie deux").
 *
 * @return array{accent: string, rest: string}
 */
final class SectionTitle
{
    public static function accentRest(string $title): array
    {
        $title = trim($title);
        if ($title === '') {
            return ['accent' => '', 'rest' => ''];
        }

        if (str_contains($title, '|')) {
            $parts = explode('|', $title, 2);

            return [
                'accent' => trim((string) ($parts[0] ?? '')),
                'rest' => trim((string) ($parts[1] ?? '')),
            ];
        }

        if (preg_match('/^(.+?),\s+(.+)$/u', $title, $m)) {
            return ['accent' => $m[1], 'rest' => $m[2]];
        }

        return ['accent' => '', 'rest' => $title];
    }
}
