<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CheckUserProfile
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if ($request->is('api/*')) {
                // API authentication
                $token = $request->header('Authorization');
                if (!$token) {
                    return response()->json(['error' => 'Não autorizado'], 401);
                }
                
                $token = str_replace('Bearer ', '', $token);
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();
            } else {
                // Web authentication
                $user = Auth::user();
            }

            if (!$user) {
                if ($request->is('api/*')) {
                    return response()->json(['error' => 'Usuário não encontrado'], 401);
                }
                return redirect()->route('login');
            }

            if (!$user->document || !$user->phone || !$user->zip_code || !$user->street_name 
                || !$user->street_number || !$user->street_neighborhood 
                || !$user->city || !$user->state
            ) {
                
                return redirect()->route('profile.complete')
                    ->with('warning', 'Por favor, complete seu perfil para continuar.');
            }

            return $next($request);
            
        } catch (JWTException $e) {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Token inválido'], 401);
            }
            return redirect()->route('login');
        } catch (\Exception $e) {
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Erro na autenticação'], 401);
            }
            return redirect()->route('login');
        }
    }
} 