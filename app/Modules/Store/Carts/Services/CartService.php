<?php

namespace App\Modules\Store\Carts\Services;

use App\Models\Cart;
use App\Models\Enums\CartStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(): ?Cart
    {
        $token = Session::get('sessionToken');
        if (!$token) {
            return null;
        }

        $cart = Cart::where('token', $token)
            ->where('status', CartStatus::OPEN->value)
            ->first();

        return $cart;
    }

    public function getOrCreateCart(): Cart
    {
        $cart = $this->getCart();

        if (!$cart) {
            $token = Session::get('sessionToken') ?: Str::uuid();

            $cart = Cart::create([
                'token' => $token,
                'status' => CartStatus::OPEN->value,
                'user_id' => Auth::id()
            ]);

            Session::put('sessionToken', $token);
            Session::put('cart', $cart);
        }

        return $cart;
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }
}
