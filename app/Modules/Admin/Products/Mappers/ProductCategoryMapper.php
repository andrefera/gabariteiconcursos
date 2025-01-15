<?php

namespace App\Modules\Admin\Products\Mappers;

use App\Models\Enums\ProductCategory;

class ProductCategoryMapper
{
    public function __invoke(string $value): string
    {
        return match (ProductCategory::from($value)) {
            ProductCategory::SHIRT => 'Camisa',
            ProductCategory::SHORTS => 'Short',
            default => '',
        };
    }
}
