<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Admin\Category\DTO\EditCategoryDTO;
use App\Modules\Admin\Category\Services\Actions\CreateOrUpdateCategory;
use App\Modules\Admin\Orders\Services\Actions\MercadoPagoWebhookHandlerAction;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Modules\Admin\Orders\Services\Actions\ListOrders;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    const BASE_VIEW = 'orders';

    public function index(Request $request): JsonResponse
    {
        return response()->json(ListOrders::fromRequest($request)->execute());
    }

    public function edit(Category $category): JsonResponse
    {
        return response()->json(EditCategoryDTO::fromCategory($category));
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        return response()->json(CreateOrUpdateCategory::fromRequest($request)->execute());
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            if ($category->products()->count() > 0) {
                throw new Exception("A categoria possui produtos atrelados.");
            }

            $category->delete();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }

    public function downloadShippingLabels(Request $request): Response
    {
        $pdf = Pdf::loadView(self::BASE_VIEW . '.shipping_label')->setPaper('a4');
        return $pdf->download('etiquetas.pdf');
    }

    public function webhookMercadoPago(Request $request): JsonResponse
    {
        Log::info("------Mercado Pago Webhook------");
        Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));
        $params = $request->all();
        if(isset($params['type']) && isset($params['data']['id'])) {
            (new MercadoPagoWebhookHandlerAction($params['type'], $params['data']['id']))->execute();
        }
        Log::info("--------------------------------");

        return response()->json(['ok']);
    }

}
