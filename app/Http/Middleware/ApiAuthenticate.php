<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Exception;

class ApiAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->header('Authorization');
            
            if (!$token) {
                return response()->json(['error' => 'Token não fornecido'], 401);
            }

            $token = str_replace('Bearer ', '', $token);
            JWTAuth::setToken($token);
            
            $user = JWTAuth::authenticate();
            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado'], 401);
            }

            return $next($request);

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro na autenticação'], 401);
        }
    }
} 