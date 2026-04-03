<?php

namespace Database\Factories;

use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioProject>
 */
class PortfolioProjectFactory extends Factory
{
    protected $model = PortfolioProject::class;

    public function definition(): array
    {
        return [
            'title' => fake()->words(4, true),
            'description' => fake()->paragraph(),
            'sort_order' => 0,
        ];
    }
}
