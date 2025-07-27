<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCpf implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove non-digits
        $cpf = preg_replace('/[^0-9]/', '', $value);
        
        // Validate length
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Validate if all digits are the same
        if (preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }
        
        // Validate first check digit
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $cpf[$i] * (10 - $i);
        }
        $remainder = $sum % 11;
        $checkDigit1 = ($remainder < 2) ? 0 : 11 - $remainder;
        if ($cpf[9] != $checkDigit1) {
            return false;
        }
        
        // Validate second check digit
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $cpf[$i] * (11 - $i);
        }
        $remainder = $sum % 11;
        $checkDigit2 = ($remainder < 2) ? 0 : 11 - $remainder;
        
        return $cpf[10] == $checkDigit2;
    }

    public function message()
    {
        return 'O CPF informado não é válido.';
    }
} 