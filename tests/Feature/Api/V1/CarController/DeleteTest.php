<?php

use App\Models\Car;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;

it('can delete a car', function () {
    $car = Car::factory()->create();

    login($car->owner)
        ->deleteJson(route('v1.private.cars.delete', $car))
        ->assertNoContent();

    assertDatabaseEmpty(Car::class);
});

it('prevents users from deleting other users car', function () {
    $otherUser = User::factory()->create();
    $car = Car::factory()->create();

    login($otherUser)
        ->deleteJson(route('v1.private.cars.delete', $car))
        ->assertForbidden();

    assertDatabaseCount(Car::class, 1);
});
