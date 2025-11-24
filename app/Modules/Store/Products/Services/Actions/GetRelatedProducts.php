<?php

namespace App\Modules\Store\Products\Services\Actions;

use App\Models\Product;
use App\Modules\Store\Products\DTO\HomeProductDTO;
use Illuminate\Support\Facades\DB;

class GetRelatedProducts
{
    public function __construct(
        private int $productId,
    )
    {
    }

    public function execute(): array
    {
        return $this->getProductsFromDatabase();
    }

    private function getProductsFromDatabase(): array
    {
        // Buscar o produto atual para obter o team_id
        $currentProduct = Product::with('team')->find($this->productId);
        
        if (!$currentProduct) {
            return [];
        }

        $teamId = $currentProduct->team_id;
        $collectedProductIds = [$this->productId]; // Evitar duplicatas incluindo o produto atual

        // Primeiro: buscar produtos do mesmo time
        $sameTeamProductIds = DB::table('products')
            ->select('products.id')
            ->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')
            ->join('teams', 'products.team_id', '=', 'teams.id')
            ->where('products.is_active', true)
            ->where('product_sizes.stock', '>', 0)
            ->where('products.team_id', $teamId)
            ->where('products.id', '!=', $this->productId)
            ->whereNull('products.deleted_at')
            ->whereNull('teams.deleted_at')
            ->distinct()
            ->orderByDesc('products.id')
            ->pluck('products.id')
            ->toArray();

        $collectedProductIds = array_merge($collectedProductIds, $sameTeamProductIds);
        $remainingSlots = 4 - count($sameTeamProductIds);

        // Segundo: se não tiver 4 produtos, completar com produtos internacionais
        if ($remainingSlots > 0) {
            $internationalProductIds = DB::table('products')
                ->select('products.id')
                ->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')
                ->join('teams', 'products.team_id', '=', 'teams.id')
                ->where('products.is_active', true)
                ->where('product_sizes.stock', '>', 0)
                ->whereNotIn('teams.country', ['BR'])
                ->where('products.team_id', '!=', $teamId) // Excluir produtos do mesmo time
                ->whereNotIn('products.id', $collectedProductIds) // Excluir produtos já coletados
                ->whereNull('products.deleted_at')
                ->whereNull('teams.deleted_at')
                ->distinct()
                ->orderByDesc('products.id')
                ->limit($remainingSlots)
                ->pluck('products.id')
                ->toArray();

            $collectedProductIds = array_merge($collectedProductIds, $internationalProductIds);
        }

        // Remover o produto atual da lista final
        $finalProductIds = array_filter($collectedProductIds, fn($id) => $id != $this->productId);
        $finalProductIds = array_slice($finalProductIds, 0, 4); // Garantir máximo de 4 produtos

        if (empty($finalProductIds)) {
            return [];
        }

        $products = Product::whereIn('id', $finalProductIds)
            ->with(['team', 'images', 'sizes'])
            ->orderByDesc('id')
            ->get();

        return $products->map(fn($product) => HomeProductDTO::fromProduct($product)->toArray())->toArray();
    }
} 