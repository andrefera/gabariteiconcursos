<?php

namespace App\Modules\Store\CartItems\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Throwable;

class CartItemService
{
    public function addItem(Cart $cart, array $item): bool
    {
        try {
            $product = Product::query()->find($item['product_id']);

            if (!$product->checkStock($item['size'], $item['quantity'])) {
                return false;
            }

            $cart->items()->updateOrCreate(['product_id' => $product->id, 'size' => $item['size']], [
                'quantity' => $item['quantity'],
                'price' => $product->price
            ]);

        } catch (Throwable $exception) {
            Log::info("Erro ao adicionar item no carrinho: " . $exception->getMessage());
            return false;
        }

        return true;
    }

    public function updateQuantity(CartItem $item, int $quantity): bool
    {
        if (!$item->product->checkStock($item->size, $quantity)) {
            return false;
        }

        $item->update([
            'quantity' => $quantity
        ]);

        return true;
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
