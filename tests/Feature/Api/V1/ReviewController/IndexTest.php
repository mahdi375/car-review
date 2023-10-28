<?php

use App\Models\Car;
use App\Models\Review;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\getJson;

it('paginated reviews', function () {
    Review::factory(6)->create();

    getJson(route('v1.public.reviews.index', ['per_page' => 4]))
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('meta.per_page', 4)
            ->has('data', 4)
            ->has('data.0', fn (AssertableJson $carJson) => $carJson
                ->whereAllType([
                    'id' => 'integer',
                    'star' => 'integer',
                    'review' => 'string',
                    'user' => 'array',
                    'created_at' => 'string',
                ])
            )
            ->etc()
        );
});

it('can fetch five latest reviews of a given car with a rating above 6 stars', function () {
    [$car, $otherCar] = Car::factory(2)->create();

    // two old reviews (star >= 7)
    Review::factory(2)->for($car)->star(min: 7)->create();

    // new reviews for each car (star >= 7)
    $targetReviews = Review::factory(5)->for($car)->star(min: 7)->create();
    Review::factory(3)->for($otherCar)->star(min: 7)->create();

    // (star <= 6) reviews
    Review::factory(2)->for($car)->star(max: 6)->create();

    $filters = [
        'per_page' => 5,
        'min_star' => 7,
        'car' => $car->id,
        'sort' => 'id',
        'order' => 'desc',
    ];

    getJson(route('v1.public.reviews.index', $filters))
        ->assertSuccessful()
        ->assertJsonCount(5, 'data')
        ->assertJsonPath('data.0.id', $targetReviews->pop()->id)
        ->assertJsonPath('data.1.id', $targetReviews->pop()->id)
        ->assertJsonPath('data.2.id', $targetReviews->pop()->id)
        ->assertJsonPath('data.3.id', $targetReviews->pop()->id)
        ->assertJsonPath('data.4.id', $targetReviews->pop()->id);
});
