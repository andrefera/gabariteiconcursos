<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPhone implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove non-digits
        $phone = preg_replace('/[^0-9]/', '', $value);
        
        // Validate length (10 for landline, 11 for mobile)
        if (!in_array(strlen($phone), [10, 11])) {
            return false;
        }
        
        // If mobile (11 digits), validate if starts with 9
        if (strlen($phone) == 11 && $phone[2] != '9') {
            return false;
        }
        
        // Validate DDD (11-99)
        $ddd = substr($phone, 0, 2);
        if ($ddd < 11 || $ddd > 99) {
            return false;
        }
        
        return true;
    }

    public function message()
    {
        return 'O número de telefone informado não é válido. Use o formato (XX) XXXXX-XXXX para celular ou (XX) XXXX-XXXX para fixo.';
    }
} 