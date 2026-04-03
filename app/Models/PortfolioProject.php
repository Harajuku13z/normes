<?php

namespace App\Models;

use Database\Factories\PortfolioProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * @return HasMany<PortfolioProjectImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PortfolioProjectImage::class)->orderBy('sort_order')->orderBy('id');
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
