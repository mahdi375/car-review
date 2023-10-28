<?php

use App\Models\Brand;
use App\Models\Car;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

function carCreationPayload(array $data = [])
{
    $brand = Brand::factory()->create();

    return array_merge([
        'brand_id' => $brand->id,
        'model' => fake()->words(asText: true),
        'color' => fake()->hexColor(),
    ], $data);
}

it('can create new car', function () {
    $user = User::factory()->create();
    $payload = carCreationPayload();

    assertDatabaseCount(Car::class, 0);

    login($user)
        ->postJson(route('v1.private.cars.store'), $payload)
        ->assertCreated();

    assertDatabaseCount(Car::class, 1);
    assertDatabaseHas(Car::class, array_merge($payload, ['user_id' => $user->id]));
});

it('is forbidden for guest', function () {
    $payload = carCreationPayload();

    postJson(route('v1.private.cars.store'), $payload)
        ->assertUnauthorized();

    assertDatabaseCount(Car::class, 0);
});

it('validate posted data', function (array $data, $message) {
    $payload = carCreationPayload($data);

    login()
        ->postJson(route('v1.private.cars.store'), $payload)
        ->assertUnprocessable()
        ->assertJsonPath('message', $message);

    assertDatabaseCount(Car::class, 0);
})->with('invalid_data');

dataset('invalid_data', [

    'brand required' => [
        ['brand_id' => null],
        'The brand id field is required.',
    ],

    'brand must exist' => [
        ['brand_id' => fake()->numberBetween(1)],
        'The selected brand id is invalid.',
    ],

    'model required' => [
        ['model' => null],
        'The model field is required.',
    ],

    'model string' => [
        ['model' => fake()->numberBetween()],
        'The model field must be a string.',
    ],

    'model min:3' => [
        ['model' => 'ab'],
        'The model field must be at least 3 characters.',
    ],

    'model max:254' => [
        ['model' => fake()->words(250, true)],
        'The model field must not be greater than 254 characters.',
    ],

    'color required' => [
        ['color' => null],
        'The color field is required.',
    ],

    'color string' => [
        ['color' => fake()->numberBetween()],
        'The color field must be a string.',
    ],

    'color min:3' => [
        ['color' => 'ab'],
        'The color field must be at least 3 characters.',
    ],

    'color max:254' => [
        ['color' => fake()->words(250, true)],
        'The color field must not be greater than 254 characters.',
    ],
]);
