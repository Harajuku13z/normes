<?php

namespace App\Models;

use Database\Factories\PortfolioProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PortfolioProject extends Model
{
    /** @use HasFactory<PortfolioProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (PortfolioProject $project): void {
            if (! filled($project->slug) && filled($project->title)) {
                $project->slug = static::makeUniqueSlugFromTitle(
                    $project->title,
                    $project->exists ? $project->id : null
                );
            }
        });
    }

    /**
     * Persist slugs for rows missing one (ex. avant migration ou imports).
     */
    public static function ensureMissingSlugsPersisted(): void
    {
        $table = (new static)->getTable();
        if (! Schema::hasColumn($table, 'slug')) {
            return;
        }

        static::query()
            ->where(function ($q): void {
                $q->whereNull('slug')->orWhere('slug', '');
            })
            ->orderBy('id')
            ->each(function (PortfolioProject $project): void {
                $project->slug = static::makeUniqueSlugFromTitle(
                    $project->title,
                    $project->id
                );
                $project->saveQuietly();
            });
    }

    /**
     * @return HasMany<PortfolioProjectImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PortfolioProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Accepte l'id (toujours valide) ou le slug si la colonne existe (SEO / anciens liens).
     *
     * @param  mixed  $value
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (Schema::hasColumn($this->getTable(), 'slug')) {
            $bySlug = static::query()->where('slug', $value)->first();
            if ($bySlug !== null) {
                return $bySlug;
            }
        }

        if (ctype_digit($value)) {
            return static::query()->whereKey((int) $value)->first();
        }

        return null;
    }

    public static function makeUniqueSlugFromTitle(string $title, ?int $exceptId = null): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'realisation';
        }
        $slug = $base;
        $i = 2;
        while (static::query()
            ->where('slug', $slug)
            ->when($exceptId !== null, fn ($q) => $q->where('id', '!=', $exceptId))
            ->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
