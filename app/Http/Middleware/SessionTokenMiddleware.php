<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Enums\CartStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HigherOrderTapProxy;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class SessionTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return HigherOrderTapProxy
     */
    public function handle(Request $request, Closure $next): HigherOrderTapProxy
    {
        $cartToken = $request->cookie('session_token') ?: Str::uuid();

        $cart = Cart::query()->where('token', $cartToken)->first();

        if($cart && $cart->status !== CartStatus::OPEN->value) {
            Log::info("Change session token {$cart->id} {$cart->status}");
            $cartToken = Str::uuid();
            $cart = null;
        } else {

            if ($cart && $cart->user) {
                $user = JWTAuth::parseToken()->authenticate();
                if ($user) {
                    if ($user->id !== $cart->user_id) {
                        Log::info("Change session token {$user->id} !== {$cart->user_id}");
                        $cartToken = Str::uuid();
                        Cart::cloneCart($user->id, $cartToken);
                    }
                }
            }
        }

        Session::put('sessionToken', $cartToken);
        Session::put('cart', $cart);

        return tap($next($request), function ($response) use ($request, $cartToken) {
            $response->headers->setCookie(cookie('session_token', $cartToken, (((int) env('SESSION_TOKEN_DAYS', 7)) * 1440), null, null, true));
        });
    }
}
