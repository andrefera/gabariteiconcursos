<?php

namespace App\Models\Enums;

enum PaymentMethod: string
{
    case  VISA = 'visa';
    case  MASTERCARD = 'master';
    case PIX = 'pix';
    case CREDIT_CARD = 'credit_card';

    //BOLETO
    case TICKET = 'bolbradesco';
}
