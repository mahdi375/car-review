<?php

use App\Http\Controllers\Api\V1\Car\CarController;
use Illuminate\Support\Facades\Route;

Route::prefix('private')->middleware('auth:sanctum')->name('private.')->group(function () {
    Route::prefix('cars')->name('cars.')->controller(CarController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{car}', 'show')->name('show');
        Route::patch('{car}', 'update')->name('update');
        Route::delete('{car}', 'delete')->name('delete');
    });
});

Route::prefix('public')->name('public.')->group(function () {

});
