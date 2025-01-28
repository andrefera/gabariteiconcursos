<?php

namespace App\Modules\Admin\Category\DTO;

use App\Models\Category;

class ListCategoriesDTO
{
    /**
     * @var CategoryDetailDTO[]
     */
    public array $categories;

    /**
     * @param Category[] $categories
     * @param int $total
     * @param int $currentPage
     * @param int $lastPage
     * @param int $limit
     */
    public function __construct(
        array      $categories,
        public int $total,
        public int $currentPage,
        public int $lastPage,
        public int $limit,
    )
    {
        $this->categories = array_map(fn(Category $category) => CategoryDetailDTO::fromCategory($category), $categories);
    }
}
