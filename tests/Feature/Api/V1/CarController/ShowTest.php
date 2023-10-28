<?php

it('can show a car', function () {
    // TODO:
});

it('returns 404 if car does not exist', function () {
    login()
        ->getJson(route('v1.private.cars.show', 1))
        ->assertNotFound();
});
