<?php

namespace App\Modules\Admin\Dashboard\Services\Actions;

use App\Models\Enums\OrderPaymentStatus;
use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Modules\Admin\Dashboard\DTO\DashboardDTO;
use Carbon\Carbon;

class GetDataDashboard
{

    public function __construct()
    {
    }

    public function execute(): DashboardDTO
    {
        $orders = Order::query()
            ->whereHas('payments', function ($query) {
                $query->whereNotNull('paid_at');
                $query->where('status', OrderPaymentStatus::PAID->value);
            })
            ->whereNotIn('status', [OrderStatus::NEW->value, OrderStatus::CANCELLED->value, OrderStatus::REFUNDED->value])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get();

        $finalPrice = "R$" . number_format($orders->sum('final_price'), 2, ',', '.');
        $totalFreight = "R$" . number_format($orders->sum('freight'), 2, ',', '.');

        $costTotal = $orders->map(function ($order) {
            return $order->items->sum(function ($item) {
                    return $item->product->cost;
                });
        })->sum();

        $costTotal = "R$" . number_format($costTotal, 2, ',', '.');

        $liquidTotal = $orders->map(function ($order) {
            return $order->final_price - $order->items->sum(function ($item) {
                    return $item->product->cost;
                });
        })->sum();

        $liquidTotal = "R$" . number_format($liquidTotal, 2, ',', '.');

        $orderPrices = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('d/m/Y');
        })->map(function ($ordersForDay, $day) {
            $sum = $ordersForDay->sum(function ($order) {
                return $order->final_price + $order->freight;
            });

            return [
                'day' => $day,
                'value' => $sum,
            ];
        })->values()->toArray();

        return new DashboardDTO(
            $finalPrice,
            $totalFreight,
            $orderPrices,
            $liquidTotal,
            $costTotal,
            $orders->count()
        );
    }

    public static function instantiate(): self
    {
        return new self();
    }
}
