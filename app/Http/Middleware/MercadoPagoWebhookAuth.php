<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MercadoPagoWebhookAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('token');

        $expectedToken = config('services.mercado_pago.webhook_token');

        if (!$expectedToken) {
            return response()->json(['error' => 'Token de webhook não configurado'], 500);
        }

        if (!$token || $token !== $expectedToken) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        return $next($request);
    }
}

