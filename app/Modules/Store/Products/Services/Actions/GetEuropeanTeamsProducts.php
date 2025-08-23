<?php

namespace App\Modules\Store\Products\Services\Actions;

use App\Models\Product;
use App\Modules\Store\Products\DTO\HomeProductDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GetEuropeanTeamsProducts
{
    public function __construct()
    {
        // Construtor vazio conforme solicitado
    }

    public function execute(): array
    {
        $productIds = DB::table('products')
            ->select('products.id')
            ->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')
            ->join('teams', 'products.team_id', '=', 'teams.id')
            ->where('products.is_active', true)
            ->where('product_sizes.stock', '>', 0)
            ->whereIn('teams.country', ['ES', 'EN', 'IT', 'DE', 'FR', 'PT', 'NL', 'BE', 'CH', 'AT', 'SE', 'NO', 'DK', 'FI', 'PL', 'CZ', 'HU', 'RO', 'BG', 'HR', 'RS', 'SI', 'SK', 'LT', 'LV', 'EE', 'IE', 'IS', 'MT', 'CY', 'LU', 'MC', 'LI', 'VA', 'SM', 'AD', 'GR', 'TR', 'UA', 'BY', 'MD', 'AL', 'MK', 'ME', 'BA', 'XK', 'GE', 'AM', 'AZ', 'KZ', 'RU'])
            ->whereNull('products.deleted_at')
            ->whereNull('teams.deleted_at')
            ->distinct()
            ->pluck('products.id');

        $products = Product::whereIn('id', $productIds)
            ->with(['team', 'images', 'sizes'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return $products->map(fn($product) => HomeProductDTO::fromProduct($product)->toArray())->toArray();
    }
} 