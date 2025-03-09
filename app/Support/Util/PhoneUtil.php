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

}
