<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCep implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove non-digits
        $cep = preg_replace('/[^0-9]/', '', $value);
        
        // Validate length
        if (strlen($cep) != 8) {
            return false;
        }

        if (!preg_match('/^[0-9]{8}$/', $cep)) {
            return false;
        }

        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response);

        if (isset($data->erro) || !$data) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'O CEP informado não é válido.';
    }
} 