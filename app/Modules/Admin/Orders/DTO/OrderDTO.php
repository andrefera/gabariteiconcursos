<?php

namespace App\Modules\Admin\Orders\DTO;

use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Modules\Admin\OrderItems\DTO\OrderItemDTO;
use App\Support\Util\PhoneUtil;
use App\Support\Util\StringUtil;
use Carbon\Carbon;

readonly class OrderDTO
{
    public function __construct(
        public int     $id,
        public string  $increment_id,
        public string  $status,
        public string  $status_label,
        public array   $items,
        public string  $cost,
        public string  $total_price,
        public string  $final_price,
        public string  $shipping_price,
        public string  $discount,
        public string  $profit,
        public ?string $payment_method,
        public ?array  $payment_data,
        public ?string $installments,
        public ?string $paid_at,
        public string  $created_at,
        public string  $user_name,
        public string  $user_email,
        public ?string $user_document,
        public ?string $user_phone_number,
        public ?string $user_street_name,
        public ?string $user_street_number,
        public ?string $user_street_neighborhood,
        public ?string $user_street_complement,
        public ?string $user_street_city,
        public ?string $user_street_state,
        public ?string $user_street_zipcode,
        public ?string $shipping_street,
        public ?string $shipping_number,
        public ?string $shipping_neighborhood,
        public ?string $shipping_complement,
        public ?string $shipping_city,
        public ?string $shipping_state,
        public ?string $shipping_zipcode,
    )
    {
    }

    public static function fromOrder(Order $order): self
    {
        $items = $order->items;

        $orderItems = $items->map(function (OrderItem $orderItem) {
            return OrderItemDTO::fromOrderItem($orderItem);
        })->all();

        $cost = $items->sum(function (OrderItem $orderItem) {
            return $orderItem->product->cost * $orderItem->quantity;
        });

        $payment = $order->payments()->orderByDesc('id')->first();

        $shippingAddress = $order->cart?->shipping()?->address;

        return new self(
            $order->id,
            $order->increment_id,
            $order->status,
            OrderStatus::toPortuguese($order->status),
            $orderItems,
            "R$" . number_format($cost ?: 0, 2, ',', '.'),
            "R$" . number_format($order->total_price ?: 0, 2, ',', '.'),
            "R$" . number_format($order->final_price ?: 0, 2, ',', '.'),
            "R$" . number_format($order->shipping_price ?: 0, 2, ',', '.'),
            "R$" . number_format($order->discount ?: 0, 2, ',', '.'),
            "R$" . number_format(($order->final_price ?: 0) - ($cost ?: 0) + ($order->shipping_price ? 2 : 0), 2, ',', '.'),
            $payment?->method,
            $payment?->payment_data ? json_decode($payment->data, true) : null,
            $payment && $payment->installments > 1 && $payment->installment_value !== $order->final_price ?
                ("{$payment->installments}x de R$" . number_format($payment->installment_value ?: 0, 2, ',', '.')) : null,
            $order->paid_at ? Carbon::parse($order->paid_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i') : null,
            Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i'),
            $order->user?->name,
            $order->user?->email,
            $order->user?->document ? StringUtil::formatDocument($order->user->document) : null,
            $order->user?->phone ? PhoneUtil::formatPhone($order->user->phone) : null,
            $order->user?->street_name,
            $order->user?->street_number,
            $order->user?->street_neighborhood,
            $order->user?->street_complement,
            $order->user?->city,
            $order->user?->state,
            $order->user?->zip_code,
            $shippingAddress?->street,
            $shippingAddress?->number,
            $shippingAddress?->neighborhood,
            $shippingAddress?->complement,
            $shippingAddress?->city,
            $shippingAddress?->state,
            $shippingAddress?->zip_code
        );
    }
}
