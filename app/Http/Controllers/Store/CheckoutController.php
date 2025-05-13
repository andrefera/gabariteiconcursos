<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Store\Carts\DTO\CartDTO;
use App\Modules\Store\Orders\Services\Actions\StoreOrder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{
    public function __construct()
    {
    }

    public function index(): View|Factory|Application
    {
        return view('checkout.index');
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
