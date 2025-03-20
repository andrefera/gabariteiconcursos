<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Admin\Products\DTO\EditProductDTO;
use App\Modules\Admin\Products\Services\Actions\CreateOrUpdateProduct;
use App\Modules\Admin\Products\Services\Actions\ListProducts;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(ListProducts::fromRequest($request)->execute());
    }

    public function edit(Product $product): JsonResponse
    {
        return response()->json(EditProductDTO::fromProduct($product));
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        return response()->json(CreateOrUpdateProduct::fromRequest($request)->execute());
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $product->images()->delete();
            $product->sizes()->delete();
            $product->delete();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }
}
