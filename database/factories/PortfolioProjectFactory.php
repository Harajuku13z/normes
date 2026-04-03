<?php

namespace Database\Factories;

use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PortfolioProject>
 */
class PortfolioProjectFactory extends Factory
{
    protected $model = PortfolioProject::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(4, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(10000, 999999),
            'description' => fake()->paragraph(),
            'sort_order' => 0,
        ];
    }
}
