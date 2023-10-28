<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBrands();
        $this->seedCars();
        $this->seedReviews();

        $this->command->info('Seeding Successfully Completed.');
    }

    private function seedBrands(): void
    {
        $brands = ['Toyota', 'Ford', 'Volkswagen', 'Honda', 'Chevrolet', 'BMW', 'Mercedes-Benz'];

        foreach ($brands as $name) {
            Brand::create([
                'name' => $name,
            ]);
        }
    }

    private function seedCars(): void
    {
        $brands = Brand::pluck('id');

        $brands->each(function ($brand) {
            Car::factory(rand(2, 6))->create([
                'brand_id' => $brand,
            ]);
        });
    }

    private function seedReviews(): void
    {
        $cars = Car::pluck('id');

        $cars->each(function ($car) {
            Review::factory(rand(0, 6))->create([
                'car_id' => $car,
            ]);
        });
    }
}
