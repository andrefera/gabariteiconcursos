<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Store\Products\DTO\ProductDetailDTO;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
    }

    public function index(): View
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

        return view('details.index', ['product' => ProductDetailDTO::fromProduct($product)]);
    }

}
