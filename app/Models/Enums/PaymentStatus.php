<?php

namespace App\Models\Enums;

enum PaymentStatus: string
{
    case CONNECTION_TIMEOUT = 'connection_timeout';
    case ERROR_INFRASTRUCTURE = 'error_infrastructure';
    case PROCESSING = 'processing';

    case AUTHORIZED = 'authorized';
    case PAID = 'paid';
    case APPROVED = 'approved';
    case REFUNDED = 'refunded';
    case WAINTING_PAYMENT = 'waiting_payment';
    case PENDING_REFUND = 'pending_refund';
    case REFUSED = 'refused';
    case REJECTED = 'rejected';
    case CHARGEDBACK = 'chargedback';
    case ANALYZING = 'analyzing';
    case PENDING_REVIEW = 'pending_review';
}
