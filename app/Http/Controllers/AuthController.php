<?php

namespace App\Http\Controllers;

use App\Modules\Users\DTO\UserDTO;
use App\Modules\Users\Services\Actions\ChangePassword;
use App\Modules\Users\Services\Actions\LoginUser;
use App\Modules\Users\Services\Actions\RegisterUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        return response()->json(LoginUser::fromRequest($request)->execute());
    }

    public function register(Request $request): JsonResponse
    {
        return response()->json(RegisterUser::fromRequest($request)->execute());
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Deslogado com sucesso!',
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        return response()->json(ChangePassword::fromRequest($request)->execute());
    }

    public function me(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'success' => true,
                'user' => UserDTO::fromUser($user)
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'user' => null
            ]);
        }
    }
}

