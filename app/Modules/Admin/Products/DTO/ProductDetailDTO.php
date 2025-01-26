<?php

namespace App\Modules\Admin\Products\DTO;

use App\Models\Product;
use App\Modules\Admin\Products\Mappers\ProductCategoryMapper;
use App\Modules\Admin\Products\Mappers\ProductGenderMapper;
use Carbon\Carbon;

readonly class ProductDetailDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $sku,
        public string  $url,
        public string  $price,
        public ?string $special_price,
        public string  $category,
        public string  $is_active,
        public ?string $team,
        public string  $gender,
        public ?string $season,
        public int $stock,
        public string  $created_at,
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
            "R$" . number_format($product->price, 2, ',', '.'),
            $product->special_price ? ("R$" . number_format($product->special_price, 2, ',', '.')) : null,
            (new ProductCategoryMapper())($product->category),
            $product->is_active ? "Sim" : "Não",
            $product->team?->name,
            (new ProductGenderMapper())($product->gender),
            $product->season,
            $product->getStock(),
            Carbon::parse($product->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),
        );
    }
}
