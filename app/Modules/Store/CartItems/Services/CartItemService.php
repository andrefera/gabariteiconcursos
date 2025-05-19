<?php

namespace App\Modules\Store\CartItems\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartItemService
{
    public function addItem(Cart $cart, array $item): void
    {
        $product = Product::findOrFail($item['product_id']);

        // Check if the item already exists in the cart
        $cartItem = $cart->items()->where('product_id', $product->id)
            ->where('size', $item['size'])
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $item['quantity']
            ]);
            
            return;
        }

         $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $item['quantity'],
            'size' => $item['size'],
            'price' => $product->price
        ]);
    }

    public function updateQuantity(CartItem $item, int $quantity): void
    {
        $item->update([
            'quantity' => $quantity
        ]);
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function validateCartItem(Cart $cart, CartItem $item): bool
    {
        return $cart->id === $item->cart_id;
    }
} 