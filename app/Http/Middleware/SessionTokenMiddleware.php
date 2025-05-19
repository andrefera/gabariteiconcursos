<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Enums\CartStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SessionTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $cartToken = $request->cookie('session_token') ?: Str::uuid();

        $cart = Cart::query()->where('token', $cartToken)->first();

        if($cart && $cart->status !== CartStatus::OPEN->value) {
            Log::info("Change session token {$cart->id} {$cart->status}");
            $cartToken = Str::uuid();
            $cart = null;
        } else {
            // Check if cart belongs to a user and if we're authenticated
            if ($cart && $cart->user) {
                $user = Auth::user();
                if ($user) {
                    // If the cart belongs to a different user, create a new cart
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

        return tap($next($request), function ($response) use ($cartToken) {
            $response->headers->setCookie(cookie('session_token', $cartToken, (((int) env('SESSION_TOKEN_DAYS', 7)) * 1440), null, null, true));
        });
    }
}
