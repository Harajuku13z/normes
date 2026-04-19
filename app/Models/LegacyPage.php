<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LegacyPage extends Model
{
    protected $fillable = [
        'old_path',
        'title',
        'h1',
        'excerpt',
        'content_html',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $page): void {
            $page->old_path = self::normalizePath((string) $page->old_path);
            $page->title = trim((string) $page->title);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function normalizePath(string $path): string
    {
        $normalized = trim(mb_strtolower($path));
        $normalized = preg_replace('#^https?://[^/]+/?#i', '', $normalized) ?? $normalized;
        $normalized = trim($normalized, "/ \t\n\r\0\x0B");

        return $normalized;
    }
}

