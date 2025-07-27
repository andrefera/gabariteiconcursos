<?php

namespace App\Modules\Admin\OrderItems\DTO;

use App\Models\OrderItem;

readonly class OrderItemDTO
{
    public function __construct(
        public int     $id,
        public int     $productId,
        public string  $name,
        public string  $sku,
        public ?string $image_url,
        public string  $size,
        public int     $quantity,
        public string  $price,
        public string  $totalPrice,
    )
    {
    }

    public static function fromOrderItem(OrderItem $orderItem): self
    {
        return new self(
            $orderItem->id,
            $orderItem->product_id,
            $orderItem->product->name,
            $orderItem->product->sku,
            $orderItem->product->images()->orderBy('order')->first()?->url,
            $orderItem->size,
            $orderItem->quantity,
            "R$" . number_format($orderItem->product->getFinalPrice(), 2, ',', '.'),
            "R$" . number_format($orderItem->product->getFinalPrice() * $orderItem->quantity, 2, ',', '.'),
        );
    }
}
