<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Store\Carts\Services\CartService;
use App\Modules\Store\Products\DTO\ProductDetailDTO;
use App\Modules\Store\Products\Services\Actions\GetRelatedProducts;
use App\Modules\Store\Products\Services\Actions\ListStoreProducts;
use App\Modules\Store\Teams\Services\Actions\GetTeamByUrl;
use App\Modules\Store\Teams\Services\Actions\GetTeams;
use App\Support\Util\SeoUrlHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    )
    {
    }

    public function index(Request $request, ?string $filters = null): View|RedirectResponse
    {
        return view('list.index');
    }

    public function detail(Request $request): View
    {
        $url = $request->getPathInfo();
        $product = Product::query()
            ->where('url', $url)
            ->where('is_active', true)
            ->first();

        if (!$url || !$product) {
            abort(404);
        }

        // Buscar todos os tamanhos do produto
        $sizes = $product->sizes()->get();
        
        // Buscar o carrinho atual
        $cart = $this->cartService->getCart();
        
        // Calcular stocks disponíveis por tamanho (subtraindo itens do carrinho)
        $stocksBySize = [];
        foreach ($sizes as $size) {
            $availableStock = $size->stock;
            
            // Se houver carrinho, subtrair a quantidade no carrinho para este produto e tamanho
            if ($cart) {
                $cartItem = $cart->items()
                    ->where('product_id', $product->id)
                    ->where('size', $size->name)
                    ->first();
                
                if ($cartItem) {
                    $availableStock -= $cartItem->quantity;
                }
            }
            
            // Garantir que o stock não seja negativo
            $stocksBySize[$size->name] = max(0, $availableStock);
        }

        return view('details.index', [
            'product' => ProductDetailDTO::fromProduct($product),
            'related_products' => (new GetRelatedProducts($product->id))->execute(),
            'stocks_by_size' => $stocksBySize
        ]);
    }


}
