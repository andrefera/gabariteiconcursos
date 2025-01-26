<?php

namespace App\Models\Enums;

enum OrderPaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';
}
