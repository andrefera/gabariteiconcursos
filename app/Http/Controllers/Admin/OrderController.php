<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Modules\Admin\Orders\DTO\OrderDTO;
use App\Modules\Admin\Orders\DTO\OrderShippingLabelDTO;
use App\Modules\Admin\Orders\Services\Actions\MercadoPagoWebhookHandlerAction;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Modules\Admin\Orders\Services\Actions\ListOrders;
use App\Modules\Admin\Orders\Services\Actions\UpdateOrderAddress;
use Carbon\Carbon;
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

    public function edit(Order $order): JsonResponse
    {
        return response()->json(OrderDTO::fromOrder($order));
    }

    public function downloadShippingLabels(Request $request): Response
    {
        $orders = Order::query()
            ->whereIn('id', $request->get('ids'))
            ->orderByDesc('id')
            ->get()
            ->map(fn(Order $order) => OrderShippingLabelDTO::fromOrder($order));

        $pdf = Pdf::loadView(self::BASE_VIEW . '.shipping_label', compact('orders'))->setPaper('a4');

        return $pdf->download('etiquetas' . Carbon::now()->setTimezone('America/Sao_Paulo')->format('d-m-y H:i:s') . '.pdf');
    }

    public function updateStatus(Request $request): JsonResponse
    {
        try {
            $status = $request->get('status');
            if (!in_array($status, [OrderStatus::PAID->value, OrderStatus::WAITING_FOR_CARRIER->value, OrderStatus::CANCELLED->value, OrderStatus::REFUNDED->value])) {
                return response()->json(['success' => false, 'msg' => 'Status inválido']);
            }

            $ids = $request->get('ids');
            if (!$ids || !is_array($ids) || count($ids) === 0) {
                return response()->json(['success' => false, 'msg' => 'Nenhum registro encontrado.']);
            }

            Order::query()
                ->whereIn('id', $ids)
                ->get()
                ->map(function (Order $order) use ($status) {
                    $order->changeStatus($status, false);
                    $order->save();

                    return $order;
                });

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'msg' => 'Erro ao atualizar status dos pedidos']);
        }
    }

    public function updateOrderStatus(Request $request): JsonResponse
    {
        try {
            $order = Order::query()->find($request->get('id'));
            if (!$order) {
                return response()->json(['success' => false, 'msg' => 'Nenhum registro encontrado.']);
            }

            $status = $request->get('status');
            if (!OrderStatus::exist($status)) {
                return response()->json(['success' => false, 'msg' => 'Status inválido']);
            }

            if ($request->get('tracking_number')) {
                $trackingData = $order->getTrackingData() ?? [];
                $trackingData['number'] = $request->get('tracking_number');

                $order->tracking_data = json_encode($trackingData);
            }

            $order->status = $status;
            $order->save();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'msg' => 'Erro ao atualizar status do pedido']);
        }
    }

    public function updateAddress(Request $request): JsonResponse
    {
        return response()->json(UpdateOrderAddress::fromRequest($request)->execute());
    }

    public function webhookMercadoPago(Request $request): JsonResponse
    {
        Log::info("------Mercado Pago Webhook------");
        Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));
        $params = $request->all();
        if (isset($params['type']) && isset($params['data']['id'])) {
            (new MercadoPagoWebhookHandlerAction($params['type'], $params['data']['id']))->execute();
        }
        Log::info("--------------------------------");

        return response()->json(['ok']);
    }
}
