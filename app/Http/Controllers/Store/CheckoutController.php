<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Store\Orders\Services\Actions\StoreOrder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    public function __construct()
    {
    }

    public function index(): View|Factory|Application
    {
        return view('checkout.index');
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
