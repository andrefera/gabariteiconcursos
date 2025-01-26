<?php

namespace App\Modules\Admin\Teams\Mappers;

class CountryMapper
{
    public function __invoke(string $value): string
    {
        return match ($value) {
            'BR' => 'Brasil',
            'AR' => 'Argentina',
            'FR' => 'França',
            'IT' => 'Itália',
            'DE' => 'Alemanha',
            'ES' => 'Espanha',
            'PT' => 'Portugal',
            'GB' => 'Inglaterra',
            'US' => 'Estados Unidos',
            'MX' => 'México',
            'JP' => 'Japão',
            'NL' => 'Holanda',
            'BE' => 'Bélgica',
            'CH' => 'Suíça',
            'UR' => 'Uruguai',
            'SA' => 'Arábia Saudita',
            default => '',
        };
    }
}
