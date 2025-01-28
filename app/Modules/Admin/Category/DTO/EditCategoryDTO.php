<?php

namespace App\Modules\Admin\Category\DTO;

use App\Models\Category;

readonly class EditCategoryDTO
{
    public function __construct(
        public int    $id,
        public string $name
    )
    {
    }

    public static function fromCategory(Category $category): self
    {
        return new self(
            $category->id,
            $category->name,
        );
    }
}
