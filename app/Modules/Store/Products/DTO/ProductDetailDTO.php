<?php

namespace App\Modules\Store\Products\DTO;

use App\Models\Product;
use App\Modules\Admin\Products\Mappers\ProductGenderMapper;
use App\Modules\Admin\Products\Mappers\ProductTypeMapper;
use App\Support\Util\NumberUtil;
use Carbon\Carbon;

readonly class ProductDetailDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $sku,
        public string  $price,
        public ?string $special_price,
        public string  $installment_price,
        public ?string $discount_percentage,
        public string  $type,
        public string  $is_active,
        public ?string $team,
        public string  $gender,
        public ?string $season,
        public ?string $description,
        public array   $sizes,
        public array   $categories,
        public array   $images,
    )
    {
    }

    public static function fromProduct(Product $product): self
    {
        $sizes = $product->sizes()->where('stock', '>', 0)->get();
        $installmentPrice = ($product->special_price ?? $product->price) / 4;

        return new self(
            $product->id,
            $product->name,
            $product->sku,
            "R$" . number_format($product->price, 2, ',', '.'),
            $product->special_price ? ("R$" . number_format($product->special_price, 2, ',', '.')) : null,
            "4x de R$" . number_format($installmentPrice, 2, ',', '.'),
            NumberUtil::calculateDiscountPercentage($product->price, $product->special_price),
            (new ProductTypeMapper())($product->type),
            $product->is_active ? "Sim" : "Não",
            $product->team?->name,
            (new ProductGenderMapper())($product->gender),
            $product->season,
            $product->description,
            $sizes->all(),
            $product->categories->all(),
            $product->images()->orderBy('order')->get()->all(),
        );
    }
}
