<?php

namespace App\Modules\Admin\Products\DTO;

use App\Models\Product;
use App\Modules\Admin\Products\Mappers\ProductCategoryMapper;
use App\Modules\Admin\Products\Mappers\ProductGenderMapper;

readonly class ProductDetailDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $sku,
        public string  $url,
        public float   $price,
        public ?float  $special_price,
        public string  $category,
        public string  $is_active,
        public ?string $team,
        public string  $gender,
    )
    {
    }

    public static function fromProduct(Product $product): self
    {
        return new self(
            $product->id,
            $product->name,
            $product->sku,
            $product->url,
            $product->price,
            $product->special_price,
            (new ProductCategoryMapper())($product->category),
            $product->is_active ? "Sim" : "Não",
            $product->team?->name,
            (new ProductGenderMapper())($product->gender)
        );
    }
}
