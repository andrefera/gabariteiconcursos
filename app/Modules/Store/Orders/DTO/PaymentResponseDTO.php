<?php

namespace App\Modules\Store\Orders\DTO;

readonly class PaymentResponseDTO
{
    public function __construct(
        public string  $message,
        public bool    $success,
        public ?int    $orderId = null,
        public ?string $urlRedirect = null,
    )
    {
    }
}
