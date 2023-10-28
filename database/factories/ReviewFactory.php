<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'star' => fake()->numberBetween(0, 10),
            'review' => fake()->sentence(),
        ];
    }

    public function star($min = 1, $max = 10): self
    {
        return $this->state(fn () => ['star' => rand($min, $max)]);
    }
}
