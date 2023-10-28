<?php

use App\Models\Car;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('can update a car', function () {
    $car = Car::factory()->create();
    $payload = ['model' => fake()->words(asText: true)];

    login($car->owner)
        ->patchJson(route('v1.private.cars.update', $car), $payload)
        ->assertOk();

    assertDatabaseHas(Car::class, $payload);
});

it('prevents users from updating other users car', function () {
    $otherUser = User::factory()->create();
    $car = Car::factory()->create();
    $payload = ['model' => fake()->words(asText: true)];

    login($otherUser)
        ->patchJson(route('v1.private.cars.update', $car), $payload)
        ->assertForbidden();

    assertDatabaseMissing(Car::class, $payload);
});

it('validate update data', function () {
    // TODO:
});
