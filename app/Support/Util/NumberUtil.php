<?php

namespace App\Support\Util;

readonly class NumberUtil
{
    public static function formatPrice(float $price): string
    {
        return "R$" . number_format($price, 2, ',', '.');
    }
}
