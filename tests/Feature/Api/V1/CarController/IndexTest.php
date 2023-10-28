<?php

use App\Models\Car;
use Illuminate\Testing\Fluent\AssertableJson;

it('can paginate cars', function () {
    Car::factory(5)->create();

    login()
        ->getJson(route('v1.private.cars.index'))
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 5)
            ->has('data.0', fn (AssertableJson $carJson) => $carJson
                ->hasAll(['id', 'model', 'color', 'brand', 'created_at', 'updated_at'])
            )
            ->etc()
        );
});
