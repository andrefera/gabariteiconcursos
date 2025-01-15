<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Products\Services\Actions\CreateOrUpdateProduct;
use App\Modules\Admin\Products\Services\Actions\ListProducts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(ListProducts::fromRequest($request)->execute());
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        return response()->json(CreateOrUpdateProduct::fromRequest($request)->execute());
    }
}
