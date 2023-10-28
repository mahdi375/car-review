<?php

namespace App\Http\Controllers\Api\V1\Car;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\V1\Car\StoreRequest;
use App\Http\Requests\Api\V1\Car\UpdateRequest;
use App\Http\Resources\Api\V1\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CarController extends Controller
{
    public function index(): JsonResponse
    {
        $paginatedCars = Car::with('brand')->paginate();

        return $this->responseSuccess(CarResource::collection($paginatedCars));
    }

    public function show(Car $car): JsonResponse
    {
        $car->load('brand');

        return $this->responseSuccess(CarResource::make($car));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $user = $request->user();
        $car = $user->cars()->create($request->only(['model', 'brand_id', 'color']));

        return $this->responseSuccess(CarResource::make($car), Response::HTTP_CREATED);
    }

    public function update(UpdateRequest $request, Car $car): JsonResponse
    {
        $this->authorize('update', $car);
        $car->update($request->only(['model', 'brand_id', 'color']));

        return $this->responseSuccess(CarResource::make($car));
    }

    public function delete(Car $car): JsonResponse
    {
        $this->authorize('delete', $car);
        $car->delete();

        return $this->responseSuccess('car successfully deleted.', Response::HTTP_NO_CONTENT);
    }
}
