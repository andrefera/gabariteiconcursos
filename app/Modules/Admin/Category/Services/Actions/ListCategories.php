<?php

namespace App\Modules\Admin\Category\Services\Actions;

use App\Models\Category;
use App\Modules\Admin\Category\DTO\ListCategoriesDTO;
use Illuminate\Http\Request;

readonly class ListCategories
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private int     $page = 1,
        private int     $limit = 50
    )
    {
    }

    public function execute(): ListCategoriesDTO
    {
        $categories = Category::query()
            ->when($this->id, fn($query) => $query->where('id', $this->id))
            ->when($this->name, fn($query) => $query->where('name', 'like', '%' . $this->name . '%'))
            ->orderByDesc('id')
            ->paginate($this->limit, ['*'], 'page', $this->page);


        return new ListCategoriesDTO(
            $categories->items(),
            $categories->total(),
            $categories->currentPage(),
            $categories->lastPage(),
            $this->limit
        );

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('id'),
            $request->get('name'),
            $request->get('page'),
            $request->get('limit')
        );
    }
}
