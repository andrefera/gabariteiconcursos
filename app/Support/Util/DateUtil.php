<?php

namespace App\Support\Util;

use DateTime;
use DateTimeZone;

class DateUtil
{
    public static function formatDateFrontEnd($date): ?string
    {
        if (!is_null($date)) {
            if ($date == '0000-00-00 00:00:00') {
                return "";
            }

            $date = self::convertToAmericaSaoPaulo($date);

            return $date->format('d/m/y H:i');
        }

        return null;
    }

    public static function convertToAmericaSaoPaulo($date): ?DateTime
    {
        if (!$date) {
            return null;
        }

        $date = new DateTime($date, new DateTimeZone('UTC'));
        $date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));

        return $date;
    }
}
