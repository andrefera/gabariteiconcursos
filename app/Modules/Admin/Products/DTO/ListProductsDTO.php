<?php

namespace App\Modules\Admin\Products\DTO;

use App\Models\Product;

class ListProductsDTO
{
    /**
     * @var ProductDetailDTO[]
     */
    public array $products;

    /**
     * @param Product[] $products
     * @param int $total
     * @param int $currentPage
     * @param int $lastPage
     * @param int $limit
     */
    public function __construct(
        array      $products,
        public int $total,
        public int $currentPage,
        public int $lastPage,
        public int $limit,
    )
    {
        $this->products = array_map(fn(Product $product) => ProductDetailDTO::fromProduct($product), $products);
    }
}
