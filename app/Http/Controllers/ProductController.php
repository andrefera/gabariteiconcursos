<?php

namespace App\Http\Controllers;

use App\Modules\Products\Services\Actions\CreateOrUpdateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        return response()->json(CreateOrUpdateProduct::fromRequest($request)->execute());
    }
}
