<?php

namespace App\Support\Util;

readonly class NumberUtil
{
    public static function formatPrice(float $price): string
    {
        return "R$" . number_format($price, 2, ',', '.');
    }

    public static function calculateDiscountPercentage(float $price, ?float $specialPrice): ?string
    {

        if (!$price || !$specialPrice || $specialPrice >= $price) {
            return null;
        }

        return intval((($price - $specialPrice) / $price) * 100, 2) . "%";
    }
}
