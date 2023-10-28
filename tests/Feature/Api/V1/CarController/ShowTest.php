<?php

use App\Models\Car;

it('can show a car', function () {
    $car = Car::factory()->create();

    login()
        ->getJson(route('v1.private.cars.show', $car))
        ->assertSuccessful()
        ->assertJsonPath('data.id', $car->id)
        ->assertJsonStructure([
            'data' => [
                'id',
                'model',
                'color',
                'brand' => [
                    'id',
                    'name',
                    'created_at',
                ],
                'owner' => [
                    'id',
                    'name',
                    'email',
                ],
                'created_at',
                'updated_at',
            ],
        ]);
});

it('returns 404 if car does not exist', function () {
    login()
        ->getJson(route('v1.private.cars.show', 1))
        ->assertNotFound();
});
