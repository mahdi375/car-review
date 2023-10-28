<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait RespondApi
{
    public function response(
        JsonResource|ResourceCollection|string|array $data,
        $statusCode = Response::HTTP_OK
    ): JsonResponse {
        if (is_array($data) || is_string($data)) {
            return response()->json([
                'data' => $data,
            ], $statusCode);
        }

        return $data->response()->setStatusCode($statusCode);
    }

    public function responseSuccess(
        JsonResource|ResourceCollection|Throwable|Exception|string|array $data,
        $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return $this->response($data, $statusCode);
    }

    public function responseError(
        JsonResource|ResourceCollection|Throwable|Exception|string|array $data,
        $statusCode = Response::HTTP_BAD_REQUEST
    ): JsonResponse {
        return $this->response($data, $statusCode);
    }
}
