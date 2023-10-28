<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Toyota', 'Ford', 'Volkswagen', 'Honda', 'Chevrolet', 'BMW', 'Mercedes-Benz']),
        ];
    }
}
