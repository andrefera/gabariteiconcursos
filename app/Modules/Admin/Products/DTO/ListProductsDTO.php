<?php

namespace App\Modules\Admin\Products\DTO;

class ListProductsDTO
{
    /**
     * @var ProductDetailDTO[]
     */
    public array $products;

    public function __construct(
        array      $products,
        public int $total,
        public int $currentPage,
        public int $lastPage,
        public int $limit,
    )
    {
        $this->products = array_map(fn($product) => ProductDetailDTO::fromArray($product), $products);
    }
}
