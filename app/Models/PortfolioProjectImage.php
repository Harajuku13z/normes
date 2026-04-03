<?php

namespace App\Models;

use Database\Factories\PortfolioProjectImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioProjectImage extends Model
{
    /** @use HasFactory<PortfolioProjectImageFactory> */
    use HasFactory;

    protected $fillable = [
        'portfolio_project_id',
        'path',
        'alt',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<PortfolioProject, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(PortfolioProject::class, 'portfolio_project_id');
    }
}
