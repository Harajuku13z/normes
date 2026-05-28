<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmailSignature extends Model
{
    protected $fillable = [
        'full_name',
        'slug',
        'role_title',
        'email',
        'phone',
        'location',
        'website_url',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'tagline',
        'cta_primary_label',
        'cta_primary_url',
        'cta_secondary_label',
        'cta_secondary_url',
        'photo_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $signature): void {
            $signature->full_name = trim((string) $signature->full_name);
            $signature->role_title = self::trimNullable($signature->role_title);
            $signature->email = self::trimNullable($signature->email);
            $signature->phone = self::trimNullable($signature->phone);
            $signature->location = self::trimNullable($signature->location);
            $signature->website_url = self::trimNullable($signature->website_url);
            $signature->facebook_url = self::trimNullable($signature->facebook_url);
            $signature->instagram_url = self::trimNullable($signature->instagram_url);
            $signature->linkedin_url = self::trimNullable($signature->linkedin_url);
            $signature->tagline = self::trimNullable($signature->tagline);
            $signature->cta_primary_label = self::trimNullable($signature->cta_primary_label);
            $signature->cta_primary_url = self::trimNullable($signature->cta_primary_url);
            $signature->cta_secondary_label = self::trimNullable($signature->cta_secondary_label);
            $signature->cta_secondary_url = self::trimNullable($signature->cta_secondary_url);
            $signature->photo_path = self::trimNullable($signature->photo_path);
            $signature->sort_order = (int) ($signature->sort_order ?? 0);

            $slugBase = trim((string) $signature->slug);
            if ($slugBase === '') {
                $slugBase = $signature->full_name;
            }
            $signature->slug = self::makeUniqueSlug($slugBase, $signature->id);
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('full_name');
    }

    public static function makeUniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source);
        if ($base === '') {
            $base = 'signature-mail';
        }

        $slug = $base;
        $i = 2;

        while (static::query()
            ->when($ignoreId !== null, fn (Builder $q) => $q->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    private static function trimNullable(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
