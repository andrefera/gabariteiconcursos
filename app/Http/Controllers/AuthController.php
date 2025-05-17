<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Users\DTO\UserDTO;
use App\Modules\Users\Services\Actions\ChangePassword;
use App\Modules\Users\Services\Actions\LoginUser;
use App\Modules\Users\Services\Actions\RegisterUser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthController extends Controller
{
    public function login(): View|Factory|Application
    {
        return view('auth.login');
    }

    public function loginAction(Request $request): JsonResponse
    {
        return response()->json(LoginUser::fromRequest($request, $request->path())->execute());
    }

    public function register(): View|Factory|Application
    {
        return view('auth.register');
    }

    public function registerAction(Request $request): JsonResponse
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

    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(24)),
                    'google_id' => $googleUser->id,
                ]);
            }

            $token = JWTAuth::fromUser($user);

            return redirect('/')->with([
                'token' => $token,
                'success' => true,
                'message' => 'Login realizado com sucesso!'
            ]);

        } catch (Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Erro ao fazer login com Google. Tente novamente.');
        }
    }

    /**
     * Redirect to Facebook for authentication
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook callback
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = User::where('email', $facebookUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'password' => Hash::make(Str::random(24)),
                    'facebook_id' => $facebookUser->id,
                ]);
            }

            $token = JWTAuth::fromUser($user);

            return redirect('/')->with([
                'token' => $token,
                'success' => true,
                'message' => 'Login realizado com sucesso!'
            ]);

        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Erro ao fazer login com Facebook. Tente novamente.');
        }
    }
}
