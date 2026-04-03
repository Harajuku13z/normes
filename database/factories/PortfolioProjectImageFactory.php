<?php

namespace Database\Factories;

use App\Models\PortfolioProject;
use App\Models\PortfolioProjectImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioProjectImage>
 */
class PortfolioProjectImageFactory extends Factory
{
    protected $model = PortfolioProjectImage::class;

    public function definition(): array
    {
        return [
            'portfolio_project_id' => PortfolioProject::factory(),
            'path' => 'slide/toiture.png',
            'alt' => null,
            'sort_order' => 0,
        ];
    }
}
