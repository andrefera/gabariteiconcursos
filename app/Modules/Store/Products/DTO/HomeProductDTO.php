<?php

namespace App\Modules\Store\Products\DTO;

use App\Models\Product;
use App\Support\Util\NumberUtil;
use App\Support\Util\UrlUtil;

readonly class HomeProductDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
        public string $price,
        public ?string $special_price,
        public ?string $discount_percentage,
        public string $installment_price,
        public ?string $image,
        public ?string $team_name,
        public string $gender,
        public ?string $season,
        public int $stock,
    )
    {
    }

    public static function fromProduct(Product $product): self
    {
        $installmentPrice = ($product->special_price ?? $product->price) / 12;
        $stock = $product->getStock();
        $mainImage = $product->images()->orderBy('order')->first();

        return new self(
            $product->id,
            $product->name,
            UrlUtil::formatUrlKey($product->name),
            "R$ " . number_format($product->price, 2, ',', '.'),
            $product->special_price ? ("R$ " . number_format($product->special_price, 2, ',', '.')) : null,
            NumberUtil::calculateDiscountPercentage($product->price, $product->special_price),
            "em até 12x de R$ " . number_format($installmentPrice, 2, ',', '.'),
            $mainImage?->url,
            $product->team?->name,
            $product->gender,
            $product->season,
            $stock,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'price' => $this->price,
            'special_price' => $this->special_price,
            'discount_percentage' => $this->discount_percentage,
            'installment_price' => $this->installment_price,
            'image' => $this->image,
            'team_name' => $this->team_name,
            'gender' => $this->gender,
            'season' => $this->season,
            'stock' => $this->stock,
        ];
    }
} 