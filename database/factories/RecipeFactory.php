<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'user_id' => 1,
             'title' => fake()->sentence(),
             'description' => fake()->sentence(),
             'ingredients' => fake()->paragraph(20),
             'steps' => fake()->paragraph(30),

        ];
    }
}
