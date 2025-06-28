<?php

namespace App\Modules\Admin\Orders\DTO;

use App\Models\Order;
use App\Models\UserAddress;
use Carbon\Carbon;

readonly class OrderShippingLabelDTO
{
    public function __construct(
        public int     $id,
        public string  $increment_id,
        public string  $user_name,
        public ?string $street,
        public ?string $number,
        public ?string $neighborhood,
        public ?string $city,
        public ?string $state,
        public ?string $zip_code,
        public string  $created_at,
    )
    {
    }

    public static function fromOrder(Order $order): self
    {
        /**
         * @var UserAddress|null $address
         */
        $address = $order->cart?->shipping()?->address;

        return new self(
            $order->id,
            $order->increment_id,
            $order->user->name,
            $address?->street,
            $address?->number,
            $address?->neighborhood,
            $address?->city,
            $address?->state,
            $address?->zip_code,
            Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i'),
        );
    }
}
