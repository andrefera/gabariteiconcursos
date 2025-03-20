<?php

namespace App\Modules\Admin\Products\Mappers;

use App\Models\Enums\ProductType;

class ProductTypeMapper
{
    public function __invoke(string $value): string
    {
        return match (ProductType::from($value)) {
            ProductType::SHIRT => 'Camisa',
            ProductType::SHORTS => 'Short',
            default => '',
        };
    }
}
