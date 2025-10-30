<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Modules\Store\CartItems\DTO\CartItemDTO;
use App\Modules\Store\CartItems\Services\CartItemService;
use App\Modules\Store\Carts\DTO\CartDTO;
use App\Modules\Store\Carts\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService     $cartService,
        private readonly CartItemService $cartItemService
    )
    {
    }

    public function index(): View
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', ['cart' => $cart ? CartDTO::fromCart($cart) : null]);
    }

    public function addItem(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string'
        ]);

        $cart = $this->cartService->getOrCreateCart();
        $success = $this->cartItemService->addItem(
            $cart,
            $request->all()
        );

        return response()->json(['success' => $success, 'msg' => $success ? "Item adicionado com sucesso!" : "Ocorreu um erro!"]);
    }

    public function updateItem(Request $request, CartItem $item): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->cartService->getCart();

        if (!$cart || !$this->cartItemService->validateCartItem($cart, $item)) {
            return response()->json([
                'success' => false,
                'msg' => 'Item não encontrado no carrinho'
            ], 404);
        }

        $success = $this->cartItemService->updateQuantity($item, $request->quantity);

        return response()->json([
            'msg' => $success ? 'Item atualizado' : 'Limite de produtos atingido',
            'success' => $success
        ]);
    }

    public function removeItem(CartItem $item): JsonResponse
    {
        $cart = $this->cartService->getCart();

        if (!$cart || !$this->cartItemService->validateCartItem($cart, $item)) {
            return response()->json([
                'success' => false,
                'message' => 'Item não encontrado no carrinho'
            ], 404);
        }

        $this->cartItemService->removeItem($item);

        return response()->json([
            'success' => true,
            'message' => 'Item removido do carrinho',
            'cart' => $cart->load('items.product')
        ]);
    }

    public function clear(): JsonResponse
    {
        $cart = $this->cartService->getCart();

        if ($cart) {
            $this->cartService->clear($cart);
        }

        return response()->json([
            'message' => 'Carrinho esvaziado',
            'cart' => $cart ? $cart->load('items.product') : null
        ]);
    }
}
