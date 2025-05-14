<?php

namespace App\Models\Enums;

enum PaymentMethod: string
{
    case  VISA = 'visa';
    case  MASTERCARD = 'master';
    case PIX = 'pix';

    //BOLETO
    case TICKET = 'bolbradesco';
}
