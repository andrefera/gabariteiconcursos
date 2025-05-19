<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Modules\Store\Carts\DTO\CartDTO;
use App\Modules\Store\Orders\Services\Actions\StoreOrder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


class CheckoutController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $cart = Session::get('cart');
        if (!$cart) {
            return redirect()->to('/carrinho');
        }

        $user = Auth::user();
        $addresses = UserAddress::query()
        ->where('user_id', $user->id)
        ->orderBy('is_default', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();
        $cartDTO = CartDTO::fromCart($cart);

        return view('checkout.shipping', [
            'addresses' => $addresses,
            'cart' => $cartDTO,
        ]);
    }

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id'
        ]);

        $address = UserAddress::findOrFail($request->address_id);
        $cart = Session::get('cart');
        
        $cacheKey = "shipping_" . $address->zip_code . "_" . $cart->total;
        
        // Try to get cached shipping rates
        if ($cachedRates = Cache::get($cacheKey)) {
            return response()->json($cachedRates);
        }
        
        // TODO: Implement real Correios API integration
        $shippingOptions = [
            [
                'name' => 'PAC',
                'price' => 8.50,
                'days' => 5,
                'company' => 'Correios',
            ],
            [
                'name' => 'SEDEX',
                'price' => 12.50,
                'days' => 2,
                'company' => 'Correios',
            ],
            [
                'name' => 'Mini Envios',
                'price' => 6.50,
                'days' => 7,
                'company' => 'Correios',
            ]
        ];

        // Cache the shipping rates for 1 hour
        Cache::put($cacheKey, $shippingOptions, 3600);

        return response()->json($shippingOptions);
    }

    public function deleteAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id'
        ]);

        $address = UserAddress::where('user_id', Auth::user()->id)
            ->findOrFail($request->address_id);
            
        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Endereço removido com sucesso'
        ]);
    }

    public function payment(): Factory|Application|View|RedirectResponse
    {
        $cart = Session::get('cart');
        if (!$cart) {
            return redirect()->to('/carrinho');
        }

        return view('checkout.payment', ['cart' => CartDTO::fromCart($cart)]);
    }

    public function pay(Request $request): JsonResponse
    {
        return response()->json(StoreOrder::fromRequest($request)->execute());
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function failure()
    {
        return view('checkout.failure');
    }

    public function pending()
    {
        return view('checkout.pending');
    }
}
