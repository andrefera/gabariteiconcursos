<?php

namespace App\Http\Middleware;

use App\Models\Enums\UserRole;
use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Jwt
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (str_starts_with($request->path(), 'api/admin') && $user->role !== UserRole::ADMIN->value) {
                return response()->json(['msg' => 'Acesso não autorizado'], 403);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['msg' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['msg' => 'Token inválido'], 401);
        } catch (Exception $e) {
            return response()->json(['msg' => 'Token não encontrado'], 401);
        }


        return $next($request);
    }
}
