<?php

namespace App\Support\Util;

readonly class ShippingUtil
{
    public static function getDefaultShipping(string $zipCode): array
    {
        $zipCode = str_replace(['-', '.'], '', $zipCode);

        try {
            $response = file_get_contents("https://viacep.com.br/ws/{$zipCode}/json/");
            $data = json_decode($response, true);

            $shippingValues = [
                'AC' => 102.00,
                'AL' => 66.00,
                'AP' => 104.00,
                'AM' => 74.00,
                'BA' => 30.00,
                'CE' => 66.00,
                'DF' => 30.00,
                'ES' => 30.00,
                'GO' => 30.00,
                'MA' => 66.00,
                'MT' => 47.00,
                'MS' => 30.00,
                'MG' => 18.00,
                'PA' => 66.00,
                'PB' => 66.00,
                'PR' => 30.00,
                'PE' => 66.00,
                'PI' => 77.00,
                'RJ' => 25.00,
                'RN' => 77.00,
                'RS' => 66.00,
                'RO' => 77.00,
                'RR' => 102.00,
                'SC' => 30.00,
                'SP' => 25.00,
                'SE' => 25.00,
                'TO' => 66.00
            ];

            $state = $data['uf'];

            return [[
                'name' => 'PAC',
                'price' => $shippingValues[$state],
                'days' => 10,
                'company' => 'Correios'
            ]];


        } catch (\Exception $e) {
            return [];
        }
    }
}
