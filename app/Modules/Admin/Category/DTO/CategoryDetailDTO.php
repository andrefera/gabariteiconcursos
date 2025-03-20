<?php

namespace App\Modules\Admin\Category\DTO;

use App\Models\Category;
use Carbon\Carbon;

readonly class CategoryDetailDTO
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $products,
        public string $created_at,
    )
    {
    }

    public static function fromCategory(Category $category): self
    {
        return new self(
            $category->id,
            $category->name,
            $category->products()->count(),
            Carbon::parse($category->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),
        );
    }
}
