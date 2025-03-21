<?php

namespace App\Modules\Admin\Orders\DTO;

use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Modules\Admin\Products\DTO\ProductDetailDTO;
use Carbon\Carbon;

readonly class OrderDetailDTO
{
    public function __construct(
        public int    $id,
        public string $increment_id,
        public string $name,
        public string $email,
        public string $status,
        public string $total,
        public array  $products,
        public string $created_at,
    )
    {
    }

    public static function fromOrder(Order $order): self
    {
        $products = $order->items()->get()->map(function (OrderItem $orderItem) {
            return ProductDetailDTO::fromProduct($orderItem->product);
        })->toArray();

        return new self(
            $order->id,
            $order->increment_id,
            $order->user->name,
            $order->user->email,
            OrderStatus::toPortuguese($order->status),
            "R$" . number_format($order->final_price, 2, ',', '.'),
            $products,
            Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i'),
        );
    }
}
