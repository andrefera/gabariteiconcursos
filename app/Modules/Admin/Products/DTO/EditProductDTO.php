<?php

namespace App\Modules\Admin\Products\DTO;

use App\Models\Product;
use App\Modules\Admin\Products\Mappers\ProductCategoryMapper;
use App\Modules\Admin\Products\Mappers\ProductGenderMapper;
use Illuminate\Database\Eloquent\Collection;

readonly class EditProductDTO
{
    public function __construct(
        public int        $id,
        public string     $name,
        public string     $sku,
        public string     $url,
        public string     $cost,
        public string     $price,
        public ?string    $special_price,
        public ?string    $description,
        public string     $category,
        public string     $category_name,
        public bool       $is_active,
        public ?int       $team_id,
        public ?string    $team_name,
        public ?string    $season,
        public string     $gender,
        public string     $gender_name,
        public ?string    $sizes_image,
        public Collection $images,
        public Collection $sizes
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
            number_format($product->cost, 2, '.', ''),
            number_format($product->price, 2, '.', ''),
            $product->special_price ? number_format($product->special_price, 2, '.', '') : null,
            $product->description,
            $product->category,
            (new ProductCategoryMapper())($product->category),
            $product->is_active,
            $product->team_id,
            $product->team?->name,
            $product->season,
            $product->gender,
            (new ProductGenderMapper())($product->gender),
            $product->sizes_image,
            $product->images,
            $product->sizes,
        );
    }
}
