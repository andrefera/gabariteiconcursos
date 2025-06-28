<?php

namespace App\Modules\Admin\Orders\DTO;

use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Modules\Admin\OrderItems\DTO\OrderItemDTO;
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
        public array  $items,
        public string $created_at,
    )
    {
    }

    public static function fromOrder(Order $order): self
    {
        $items = $order->items()->get()->map(function (OrderItem $orderItem) {
            return OrderItemDTO::fromOrderItem($orderItem);
        })->all();

        return new self(
            $order->id,
            $order->increment_id,
            $order->user->name,
            $order->user->email,
            OrderStatus::toPortuguese($order->status),
            "R$" . number_format($order->final_price, 2, ',', '.'),
            $items,
            Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i'),
        );
    }
}
