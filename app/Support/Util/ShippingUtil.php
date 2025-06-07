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
                'AC' => 100.00,
                'AL' => 64.00,
                'AP' => 100.00,
                'AM' => 72.00,
                'BA' => 28.00,
                'CE' => 64.00,
                'DF' => 28.00,
                'ES' => 28.00,
                'GO' => 28.00,
                'MA' => 64.00,
                'MT' => 45.00,
                'MS' => 28.00,
                'MG' => 16.00,
                'PA' => 64.00,
                'PB' => 64.00,
                'PR' => 28.00,
                'PE' => 64.00,
                'PI' => 75.00,
                'RJ' => 23.00,
                'RN' => 75.00,
                'RS' => 64.00,
                'RO' => 75.00,
                'RR' => 100.00,
                'SC' => 28.00,
                'SP' => 23.00,
                'SE' => 23.00,
                'TO' => 64.00
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