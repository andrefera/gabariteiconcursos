<?php

namespace App\Support\Util;

class StringUtil
{
    /**
     * @param $fullName
     * @return array{firstName: string, lastName: string}
     */
    public static function extractNames($fullName): array
    {
        $nameArray = explode(' ', $fullName);
        $firstName = $nameArray[0];
        $lastName = count($nameArray) > 1 ? end($nameArray) : '';
        return ['firstName' => $firstName, 'lastName' => $lastName];
    }

    public static function formatDocument(string $value): ?string
    {
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

}
