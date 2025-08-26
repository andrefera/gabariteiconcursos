<?php

namespace App\Modules\Store\Orders\Mappers;


class PaymentMethodMapper
{
    public function __invoke(string $value): string
    {
        return match ($value) {
            'pix' => 'Pix',
            'ticket' => 'Boleto',
            default => 'Cartão de Crédito',
        };
    }
}
