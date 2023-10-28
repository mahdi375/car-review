<?php

namespace App\Http\Controllers\Api\V1\Review;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Filters\V1\ReviewFilters;
use App\Http\Requests\Api\V1\Review\StoreRequest;
use App\Http\Resources\Api\V1\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function index(ReviewFilters $filters): JsonResponse
    {
        $paginatedList = Review::filter($filters)
            ->with('user')
            ->paginate(perPage: request('per_page', 10));

        return $this->responseSuccess(ReviewResource::collection($paginatedList));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $review = $request->user()
            ->reviews()
            ->create($request->only('car_id', 'star', 'review'));

        return $this->responseSuccess(ReviewResource::make($review), Response::HTTP_CREATED);
    }
}
