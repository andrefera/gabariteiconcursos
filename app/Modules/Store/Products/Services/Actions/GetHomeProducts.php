<?php

namespace App\Modules\Store\Products\Services\Actions;

use App\Models\Product;
use App\Modules\Store\Products\DTO\HomeProductDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class GetHomeProducts
{
    private const CACHE_KEY = 'home_products';
    private const CACHE_TTL = 3600; // 1 hora em segundos

    public function __construct()
    {
        // Construtor vazio conforme solicitado
    }

    public function execute(): array
    {
        return $this->getProductsFromDatabase();
    }

    private function getProductsFromDatabase(): array
    {
        // Buscar produtos nacionais (BR) mais vendidos
        $productIds = DB::table('products')
            ->select('products.id', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')
            ->join('teams', 'products.team_id', '=', 'teams.id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->where('products.is_active', true)
            ->where('product_sizes.stock', '>', 0)
            ->where('teams.country', 'BR')
            ->whereNull('products.deleted_at')
            ->whereNull('teams.deleted_at')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->orderByDesc('products.id')
            ->limit(8)
            ->pluck('products.id')
            ->toArray();

        if (empty($productIds)) {
            return [];
        }

        // Buscar produtos mantendo a ordem de mais vendidos
        $products = Product::whereIn('id', $productIds)
            ->with(['team', 'images', 'sizes'])
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                // Manter a ordem baseada na posição no array de IDs
                return array_search($product->id, $productIds);
            })
            ->values();

        return $products->map(fn($product) => HomeProductDTO::fromProduct($product)->toArray())->toArray();
    }
} 