<?php

namespace App\Support\Util;

use Throwable;

class PhoneUtil
{
    public static function getDDD($phone): string
    {
        try {
            $phone = str_replace(' ', '', $phone);
            $phone = str_replace('(', '', $phone);
            $phone = str_replace(')', '', $phone);
            $phone = str_replace('-', '', $phone);
            $phone = substr($phone, 0, 2);

            if (strlen($phone) === 2 && is_numeric($phone)) {
                return (string)$phone;
            }
        } catch (Throwable) {
        }

        return '35';
    }

    public static function getNumber($phone): string
    {
        try {
            $phone = str_replace(' ', '', $phone);
            $phone = str_replace('(', '', $phone);
            $phone = str_replace(')', '', $phone);
            $phone = str_replace('-', '', $phone);
            $phone = substr($phone, -9);

            if (strlen($phone) === 9 && is_numeric($phone)) {
                return (string)$phone;
            }
        } catch (Throwable) {
        }

        return '911111111';
    }

    public static function formatPhone($phone): string
    {
        // Remove tudo que não for número
        $digits = preg_replace('/\D/', '', $phone);
        
        // Se não tiver pelo menos 12 dígitos, retorna o original
        if (strlen($digits) < 12) {
            return $phone;
        }

        // Pega DDD (2), prefixo (5), sufixo (5)
        $ddd = substr($digits, 0, 2);
        $prefix = substr($digits, 2, 5);
        $suffix = substr($digits, 7, 5);

        return sprintf('(%s) %s-%s', $ddd, $prefix, $suffix);
    }

}
