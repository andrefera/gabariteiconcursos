<?php

namespace App\Modules\Admin\Products\DTO;

use App\Models\Product;
use App\Modules\Admin\Products\Mappers\ProductGenderMapper;
use App\Modules\Admin\Products\Mappers\ProductTypeMapper;
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
        public string  $type,
        public string  $is_active,
        public ?string $team,
        public string  $gender,
        public ?string $season,
        public int     $stock,
        public string  $categories,
        public ?string $image_url,
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
            (new ProductTypeMapper())($product->type),
            $product->is_active ? "Sim" : "Não",
            $product->team?->name,
            (new ProductGenderMapper())($product->gender),
            $product->season,
            $product->getStock(),
            $product->categories()->pluck("name")->join(', '),
            $product->images()->orderBy('order')->first()?->url,
            Carbon::parse($product->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),

        );
    }

    public static function fromArray(array $product): self
    {
        return new self(
            $product['id'],
            $product['name'],
            $product['sku'],
            $product['url'],
            "R$" . number_format($product['price'], 2, ',', '.'),
            $product['special_price'] ? ("R$" . number_format($product['special_price'], 2, ',', '.')) : null,
            $product['type'],
            $product['is_active'],
            $product['team_name'],
            $product['gender'],
            $product['season'],
            $product['stock'],
            collect($product['categories'] ?? [])->join(', '),
            null,
            $product['created_at'],
        );
    }
}
