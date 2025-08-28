<?php

namespace App\Modules\Store\Users\Services\Actions;

use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Modules\Store\Orders\Mappers\PaymentMethodMapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetOrderDetails
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function execute(): array
    {
        try {
            // Verificar se o pedido pertence ao usuário logado
            if ($this->order->user_id !== Auth::id()) {
                return [
                    'success' => false,
                    'message' => 'Pedido não encontrado'
                ];
            }

            // Carregar relacionamentos
            $this->order->load(['items.product.images', 'payments']);

            $orderData = [
                'id' => $this->order->id,
                'order_number' => $this->order->increment_id ?? $this->order->id,
                'status' => OrderStatus::toPortuguese($this->order->status),
                'total_price' => "R$ " . number_format($this->order->total_price, 2, ',', '.'),
                'final_price' => "R$ " . number_format($this->order->final_price, 2, ',', '.'),
                'discount' => $this->order->discount > 0 ? "R$ " . number_format($this->order->discount, 2, ',', '.') : null,
                'shipping_price' => "R$ " . number_format($this->order->shipping_price, 2, ',', '.'),
                'created_at' => Carbon::parse($this->order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i'),
                'delivered_at' => $this->order->delivered_at ? Carbon::parse($this->order->delivered_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i') : null,
                'shipping_company' => $this->order->shipping_company,
                'shipping_method' => $this->order->shipping_method,
                'shipping_days' => $this->order->shipping_days,
                'installments' => $this->order->installments,
                'installment_price' => $this->order->installment_price ? "R$ " . number_format($this->order->installment_price, 2, ',', '.') : null,
                'items' => $this->getOrderItems(),
                'payments' => $this->getOrderPayments()
            ];

            return [
                'success' => true,
                'data' => $orderData
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao carregar detalhes do pedido: ' . $e->getMessage()
            ];
        }
    }

    private function getOrderItems(): array
    {
        return $this->order->items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->images->first()?->url ?? asset('images/icon.png'),
                'size' => $item->size,
                'quantity' => $item->quantity,
                'price' => "R$ " . number_format($item->price, 2, ',', '.'),
                'total' => "R$ " . number_format($item->price * $item->quantity, 2, ',', '.')
            ];
        })->toArray();
    }

    private function getOrderPayments(): array
    {
        return $this->order->payments->map(function ($payment) {
            return [
                'method' => (new PaymentMethodMapper())($payment->method),
                'status' => $payment->status,
                'amount' => "R$ " . number_format($payment->amount, 2, ',', '.'),
                'created_at' => $payment->created_at->format('d/m/Y H:i')
            ];
        })->toArray();
    }
}
