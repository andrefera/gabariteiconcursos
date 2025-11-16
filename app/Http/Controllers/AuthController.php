<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Users\DTO\UserDTO;
use App\Modules\Users\Services\Actions\ChangePassword;
use App\Modules\Users\Services\Actions\DeleteAccount;
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

                return response()->json([
                    'success' => true,
                    'message' => 'Login realizado com sucesso!',
                    'redirect' => '/'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'As credenciais fornecidas não correspondem aos nossos registros.',
                'errors' => [
                    'email' => 'As credenciais fornecidas não correspondem aos nossos registros.'
                ]
            ], 401);

        } catch (\Exception $e) {
            Log::error('Erro no login web: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar sua solicitação. Tente novamente mais tarde.',
                'errors' => [
                    'error' => 'Erro ao processar sua solicitação. Tente novamente mais tarde.'
                ]
            ], 500);
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'name.required' => 'O nome é obrigatório.',
                'name.string' => 'O nome deve ser um texto válido.',
                'name.max' => 'O nome não pode ter mais de 255 caracteres.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'O e-mail deve ser um endereço válido.',
                'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
                'email.unique' => 'Este e-mail já está cadastrado.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
                'password.confirmed' => 'A confirmação da senha não confere.',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Conta criada com sucesso!',
                'redirect' => '/'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            // Traduzir mensagens em inglês para português
            $translatedErrors = [];
            foreach ($errors as $field => $messages) {
                $translatedErrors[$field] = array_map(function($message) {
                    $translations = [
                        'The email has already been taken.' => 'Este e-mail já está cadastrado.',
                        'The name field is required.' => 'O nome é obrigatório.',
                        'The email field is required.' => 'O e-mail é obrigatório.',
                        'The password field is required.' => 'A senha é obrigatória.',
                        'The password confirmation does not match.' => 'A confirmação da senha não confere.',
                    ];
                    return $translations[$message] ?? $message;
                }, $messages);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $translatedErrors
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erro no registro web: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar sua solicitação. Tente novamente mais tarde.',
                'errors' => [
                    'error' => 'Erro ao processar sua solicitação. Tente novamente mais tarde.'
                ]
            ], 500);
        }
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

    public function deleteAccount(Request $request): JsonResponse
    {
        return response()->json(DeleteAccount::fromRequest($request)->execute());
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
