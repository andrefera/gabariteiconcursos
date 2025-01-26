<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case IN_SEPARATION = 'in_separation';
    case WAITING_FOR_CARRIER = 'waiting_for_carrier';
    case IN_TRANSPORT = 'in_transport';
    case DELIVERED = 'delivered';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';
}
