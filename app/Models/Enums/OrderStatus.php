<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case NEW = 'new';
    case WAITING_PAYMENT = 'waiting_payment';
    case PAID = 'paid';
    case IN_SEPARATION = 'in_separation';
    case WAITING_FOR_CARRIER = 'waiting_for_carrier';
    case IN_TRANSPORT = 'in_transport';
    case DELIVERED = 'delivered';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';

    public static function toPortuguese(string $type): string
    {
        return match ($type) {
            self::WAITING_PAYMENT->value => 'Aguardando Pagamento',
            self::PAID->value => 'Pago',
            self::IN_SEPARATION->value => 'Em Separação',
            self::WAITING_FOR_CARRIER->value => 'Aguardando Transportadora',
            self::IN_TRANSPORT->value => 'Em Transporte',
            self::DELIVERED->value => 'Entregue',
            self::REFUNDED->value => 'Reembolsado',
            self::CANCELLED->value => 'Cancelado',
        };
    }
}
