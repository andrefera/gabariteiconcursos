<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Admin\Products\Services\Actions\ListProducts;

class ProductSearchController extends Controller    
{
    public function search(Request $request)
    {
        $service = new ListProducts(
            null,
            $request->get('q'),
            null, null, 'true', null, null, null, 1, 8
        );
        $result = $service->execute();

        // Retorne apenas os campos necessários para o dropdown
        $products = array_map(function ($product) {
            return [
                'id'    => $product->id,
                'name'  => $product->name,
                'sku'   => $product->sku,
                'image' => $product->image_url ?? '',
                'url'   => $product->url,
            ];
        }, $result->products);

        return response()->json($products);
    }
}