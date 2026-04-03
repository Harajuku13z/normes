<?php

namespace App\Models;

use Database\Factories\PortfolioProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioProject extends Model
{
    /** @use HasFactory<PortfolioProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
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
}
