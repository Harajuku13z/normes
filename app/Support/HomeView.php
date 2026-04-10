<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class HomeView
{
    public static function url(?string $path): string
    {
        $path = trim(str_replace('\\', '/', (string) $path));
        if ($path === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
        if (str_starts_with($path, '//')) {
            return 'https:'.$path;
        }
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        // Filament / storage public disk (blog/featured, blog/og, pièces jointes éditeur)
        if (str_starts_with($path, 'blog/')) {
            return Storage::disk('public')->url($path);
        }

        return asset($path);
    }
}
