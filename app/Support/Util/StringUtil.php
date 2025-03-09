<?php

namespace App\Support\Util;

class StringUtil
{
    /**
     * @param $fullName
     * @return array{firstName: string, lastName: string}
     */
    static function extractNames($fullName): array
    {
        $nameArray = explode(' ', $fullName);
        $firstName = $nameArray[0];
        $lastName = count($nameArray) > 1 ? end($nameArray) : '';
        return ['firstName' => $firstName, 'lastName' => $lastName];
    }
}
