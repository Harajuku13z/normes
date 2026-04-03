<?php

namespace App\Support;

/**
 * Extrait l’ID (et le hash de confidentialité) d’une URL Vimeo pour l’iframe player.
 */
final class VimeoEmbed
{
    /**
     * @return array{id: string, h: string|null}|null
     */
    public static function parse(?string $url): ?array
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        $id = null;
        $h = null;

        if (preg_match('#player\.vimeo\.com/video/(\d+)#i', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('#vimeo\.com/(?:channels/[^/]+/|groups/[^/]+/videos/)?(\d+)(?:/([a-z0-9]+))?#i', $url, $m)) {
            $id = $m[1];
            $h = $m[2] ?? null;
        }

        if ($id === null) {
            return null;
        }

        if ($h === null && preg_match('#[?&]h=([a-z0-9]+)#i', $url, $mh)) {
            $h = $mh[1];
        }

        return ['id' => $id, 'h' => $h];
    }

    /** Fichier hébergé (MP4/MOV…) — hors Vimeo. */
    public static function isDirectFileUrl(string $raw): bool
    {
        $lower = strtolower($raw);
        if (str_contains($lower, 'vimeo.com') || str_contains($lower, 'player.vimeo.com')) {
            return false;
        }

        return (bool) preg_match('#\.(mp4|webm|mov)(\?|#|$)#i', $lower)
            || str_contains($lower, '/uploads/');
    }

    /**
     * URL iframe : lecture muette, boucle, style “fond” (peu de chrome Vimeo).
     *
     * @param  array{id: string, h: string|null}  $meta
     */
    public static function iframeSrc(array $meta, bool $autoplay = true): string
    {
        $query = [
            'badge' => '0',
            'autopause' => '0',
            'loop' => '1',
            'muted' => '1',
            'background' => '1',
            'byline' => '0',
            'title' => '0',
            'portrait' => '0',
            'playsinline' => '1',
            'autoplay' => $autoplay ? '1' : '0',
        ];

        if (! empty($meta['h'])) {
            $query['h'] = $meta['h'];
        }

        return 'https://player.vimeo.com/video/'.$meta['id'].'?'.http_build_query($query);
    }
}
