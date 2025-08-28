<?php

namespace App\Modules\Store\Users\Services\Actions;

use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Modules\Store\Orders\Mappers\PaymentMethodMapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetUserOrders
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function execute(): array
    {
        try {
            $orders = $this->getUserOrders();
            $userData = $this->getUserData();

            return [
                'success' => true,
                'data' => [
                    'user' => $userData,
                    'orders' => $orders
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao carregar pedidos: ' . $e->getMessage()
            ];
        }
    }

    private function getUserData(): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email
        ];
    }

    private function getUserOrders(): array
    {
        $orders = Order::where('user_id', $this->user->id)
            ->with(['items', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->increment_id ?? $order->id,
                'total' => "R$ " . number_format($order->final_price, 2, ',', '.'),
                'status' => OrderStatus::toPortuguese($order->status),
                'payment_method' => isset($order->payments->first()?->method) ? (new PaymentMethodMapper())($order->payments->first()->method) : 'N/A',
                'created_at' => Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),
                'delivered_at' => $order->delivered_at ? Carbon::parse($order->delivered_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s') : null,
                'items_count' => $order->items->count(),
                'progress_steps' => $this->getProgressSteps($order)
            ];
        })->toArray();
    }

    private function getProgressSteps(Order $order): array
    {
        $steps = [];
        
        // Sempre mostra "Pedido Realizado" com data
        $steps[] = [
            'label' => 'Pedido Realizado',
            'date' => Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),
            'done' => true,
            'show_date' => true
        ];

        // Adiciona "Em Separação" se o status for >= in_separation
        if (in_array($order->status, ['in_separation', 'waiting_for_carrier', 'in_transport', 'delivered'])) {
            $steps[] = [
                'label' => 'Em Separação',
                'date' => null,
                'done' => true,
                'show_date' => false
            ];
        }

        // Adiciona "Produto Enviado" se o status for >= waiting_for_carrier
        if (in_array($order->status, ['waiting_for_carrier', 'in_transport', 'delivered'])) {
            $steps[] = [
                'label' => 'Produto Enviado',
                'date' => null,
                'done' => true,
                'show_date' => false
            ];
        }

        // Adiciona "Produto Entregue" se o status for delivered
        if ($order->status === 'delivered') {
            $steps[] = [
                'label' => 'Produto Entregue',
                'date' => $order->delivered_at ? Carbon::parse($order->delivered_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s') : null,
                'done' => true,
                'show_date' => true
            ];
        }

        return $steps;
    }
}
