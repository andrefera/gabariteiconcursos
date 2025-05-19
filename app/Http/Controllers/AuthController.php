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
        $result = LoginUser::fromRequest($request, $request->path())->execute();
        return response()->json($result);
    }

    public function loginWeb(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $credentials = $request->only('email', 'password');
            
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                // If the user was trying to access a protected page, redirect them there
                return redirect()->intended('/');
            }

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
                ]);
        } catch (\Exception $e) {
            \Log::error('Erro no login web: ' . $e->getMessage());
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'error' => 'Erro ao processar sua solicitação. Tente novamente mais tarde.'
                ]);
        }
    }

    public function register(): View|Factory|Application
    {
        return view('auth.register');
    }

    // API Register
    public function registerAction(Request $request): JsonResponse
    {
        $result = RegisterUser::fromRequest($request)->execute();
        return response()->json($result);
    }

    // Web Register
    public function registerWeb(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // API Logout
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Deslogado com sucesso!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer logout!'
            ]);
        }
    }

    // Web Logout
    public function logoutWeb(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function changePassword(Request $request): JsonResponse
    {
        return response()->json(ChangePassword::fromRequest($request)->execute());
    }

    public function me(): JsonResponse
    {
        try {
            if (request()->is('api/*')) {
                $user = JWTAuth::parseToken()->authenticate();
            } else {
                $user = Auth::user();
            }

            if (!$user) {
                throw new Exception('Usuário não encontrado');
            }

            return response()->json([
                'success' => true,
                'user' => UserDTO::fromUser($user)
            ]);
        } catch (Exception $exception) {
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

            if (request()->is('api/*')) {
                $token = JWTAuth::fromUser($user);
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => UserDTO::fromUser($user)
                ]);
            } else {
                Auth::login($user);
                return redirect('/');
            }

        } catch (Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            if (request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao fazer login com Google'
                ], 500);
            }
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

            if (request()->is('api/*')) {
                $token = JWTAuth::fromUser($user);
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => UserDTO::fromUser($user)
                ]);
            } else {
                Auth::login($user);
                return redirect('/');
            }

        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            if (request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao fazer login com Facebook'
                ], 500);
            }
            return redirect('/login')->with('error', 'Erro ao fazer login com Facebook. Tente novamente.');
        }
    }
}
