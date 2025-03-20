<?php

namespace App\Models\Enums;

enum PaymentMethod: string
{
    case  VISA = 'visa';
    case  MASTERCARD = 'mastercard';
    case PIX = 'pix';

    //BOLETO
    case TICKET = 'bolbradesco';
}
