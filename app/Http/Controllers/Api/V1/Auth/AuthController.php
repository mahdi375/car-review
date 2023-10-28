<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // TODO: usually there are more logics around login|register and  we need to use Service Layer
    // Keep It Simple Stupid for now
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->only('name', 'email', 'password'));

        return $this->responseSuccess(UserResource::make($user));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            /** @var User $user */
            $user = Auth::user();
            $user->token = $user->createToken('auth')->plainTextToken;

            return $this->responseSuccess(UserResource::make($user));
        }

        return $this->responseError(
            'The provided credentials are incorrect.',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
