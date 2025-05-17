<?php

namespace App\Modules\Store\Carts\Services;

use App\Models\Cart;
use App\Models\Enums\CartStatus;
use App\Modules\Store\Carts\DTO\CartDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(): ?CartDTO
    {
        $token = Session::get('sessionToken');
        if (!$token) {
            return null;
        }

        $cart = Cart::where('token', $token)
            ->where('status', 'active')
            ->first();

        return $cart ? CartDTO::fromCart($cart) : null;
    }

    public function getOrCreateCart(): Cart
    {
        $cart = $this->getCart();
        
        if (!$cart) {
            $token = Session::get('sessionToken') ?: Str::uuid();
            Session::put('sessionToken', $token);
            
            $cart = Cart::create([
                'token' => $token,
                'status' => CartStatus::OPEN->value,
                'user_id' => Auth::id()
            ]);
        }
        
        return $cart;
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }
} 