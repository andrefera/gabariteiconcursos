<?php

namespace App\Modules\Admin\Products\Mappers;

use App\Models\Enums\ProductGender;

class ProductGenderMapper
{
    public function __invoke(string $value): string
    {
        return match (ProductGender::from($value)) {
            ProductGender::MASCULINE => 'Masculino',
            ProductGender::FEMININE => 'Feminino',
            ProductGender::UNISEX => 'Unisex',
            default => '',
        };
    }
}
