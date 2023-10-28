<?php

use App\Models\Car;
use App\Models\Review;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

function addReviewPayload(array $data = [])
{
    $car = Car::factory()->create();

    return array_merge([
        'car_id' => $car->id,
        'star' => fake()->numberBetween(1, 10),
        'review' => fake()->text(),
    ], $data);
}

it('can create new car', function () {
    $user = User::factory()->create();
    $payload = addReviewPayload();

    assertDatabaseCount(Review::class, 0);

    login($user)
        ->postJson(route('v1.private.reviews.store'), $payload)
        ->assertCreated();

    assertDatabaseCount(Review::class, 1);
    assertDatabaseHas(Review::class, array_merge($payload, ['user_id' => $user->id]));
});

it('is forbidden for guest', function () {
    $payload = addReviewPayload();

    postJson(route('v1.private.reviews.store'), $payload)
        ->assertUnauthorized();

    assertDatabaseCount(Review::class, 0);
});

it('validate submitted data', function (array $data, $message) {
    $payload = addReviewPayload($data);

    login()
        ->postJson(route('v1.private.reviews.store'), $payload)
        ->assertUnprocessable()
        ->assertJsonPath('message', $message);

    assertDatabaseCount(Review::class, 0);
})->with('invalid_data');

dataset('invalid_data', [
    'car required' => [
        ['car_id' => null],
        'The car id field is required.',
    ],

    'car must exist' => [
        ['car_id' => fake()->numberBetween(1)],
        'The selected car id is invalid.',
    ],

    'star required' => [
        ['star' => null],
        'The star field is required.',
    ],

    'star number' => [
        ['star' => fake()->word()],
        'The star field must be an integer.',
    ],

    'star min:0' => [
        ['star' => -1],
        'The star field must be at least 0.',
    ],

    'star max:10' => [
        ['star' => fake()->numberBetween(11)],
        'The star field must not be greater than 10.',
    ],

    'review string' => [
        ['review' => fake()->numberBetween()],
        'The review field must be a string.',
    ],

    'review min:3' => [
        ['review' => 'ab'],
        'The review field must be at least 3 characters.',
    ],
]);
