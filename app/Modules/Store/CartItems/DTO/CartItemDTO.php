<?php

namespace App\Modules\Store\CartItems\DTO;

use App\Models\CartItem;
use App\Support\Util\NumberUtil;

readonly class CartItemDTO
{
    public function __construct(
        public int     $id,
        public int     $productId,
        public string  $name,
        public ?string $imageUrl,
        public string  $sku,
        public string  $size,
        public int     $quantity,
        public float   $price,
        public float   $specialPrice,
        public string  $priceLabel,
    )
    {
    }

    public static function fromCartItem(CartItem $cartItem): self
    {
        $image = $cartItem->product->images->first();

        return new self(
            $cartItem->id,
            $cartItem->product_id,
            $cartItem->product->name,
            $image?->url,
            $cartItem->product->sku,
            $cartItem->size,
            $cartItem->quantity,
            $cartItem->product->price,
            $cartItem->product->getFinalPrice(),
            NumberUtil::formatPrice($cartItem->product->getFinalPrice())
        );
    }
}
