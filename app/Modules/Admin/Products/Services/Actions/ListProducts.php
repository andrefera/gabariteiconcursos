<?php

namespace App\Modules\Admin\Products\Services\Actions;

use App\Models\Product;
use App\Modules\Admin\Products\DTO\ListProductsDTO;
use Illuminate\Http\Request;

readonly class ListProducts
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private ?string $sku,
        private ?string $category,
        private ?bool   $is_active,
        private ?int    $team_id,
        private ?string $gender,
        private int     $page = 1,
        private int     $limit = 50
    )
    {
    }

    public function execute(): ListProductsDTO
    {
        $products = Product::query()
            ->when($this->id, fn($query) => $query->where('id', $this->id))
            ->when($this->name, fn($query) => $query->where('name', 'like', '%' . $this->name . '%'))
            ->when($this->sku, fn($query) => $query->where('sku', 'like', '%' . $this->sku . '%'))
            ->when($this->category, fn($query) => $query->where('category', $this->category))
            ->when(is_bool($this->is_active), fn($query) => $query->where('is_active', $this->is_active))
            ->when($this->team_id, fn($query) => $query->where('team_id', $this->team_id))
            ->when($this->gender, fn($query) => $query->where('gender', $this->gender))
            ->orderByDesc('id')
            ->paginate($this->limit, ['*'], 'page', $this->page);


        return new ListProductsDTO(
            $products->items(),
            $products->total(),
            $products->currentPage(),
            $products->lastPage(),
            $this->limit
        );

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('id'),
            $request->get('name'),
            $request->get('sku'),
            $request->get('category'),
            !$request->get('is_active') ? null : $request->get('is_active') === 'true',
            $request->get('team_id'),
            $request->get('gender'),
            $request->get('page'),
            $request->get('limit')
        );
    }
}
