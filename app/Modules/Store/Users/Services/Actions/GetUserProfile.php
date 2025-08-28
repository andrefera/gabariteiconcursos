<?php

namespace App\Modules\Store\Users\Services\Actions;

use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
use App\Modules\Store\Orders\Mappers\PaymentMethodMapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetUserProfile
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function execute(): array
    {
        try {
            $userData = $this->getUserData();
            $addresses = $this->getUserAddresses();
            $recentOrders = $this->getRecentOrders();

            return [
                'success' => true,
                'data' => [
                    'user' => $userData,
                    'addresses' => $addresses,
                    'recentOrders' => $recentOrders
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao carregar dados do perfil: ' . $e->getMessage()
            ];
        }
    }

    private function getUserData(): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'document' => $this->user->document,
            'birth_date' => $this->user->birth_date,
            'created_at' => $this->user->created_at,
            'profile_completed' => $this->user->profile_completed ?? false
        ];
    }

    private function getUserAddresses(): array
    {
        $addresses = UserAddress::where('user_id', $this->user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $addresses->map(function ($address) {
            return [
                'id' => $address->id,
                'name' => $this->user->name,
                'street' => $address->street,
                'number' => $address->number,
                'complement' => $address->complement,
                'neighborhood' => $address->neighborhood,
                'city' => $address->city,
                'state' => $address->state,
                'zipcode' => $address->zip_code,
                'phone' => $this->user->phone,
                'is_default' => $address->is_default
            ];
        })->toArray();
    }

    private function getRecentOrders(): array
    {
        $orders = Order::where('user_id', $this->user->id)
            ->with(['items', 'payments'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->increment_id ?? $order->id,
                'total' => "R$" . number_format($order->final_price, 2, ',', '.'),
                'status' => OrderStatus::toPortuguese($order->status),
                'payment_method' => isset($order->payments->first()?->method) ? (new PaymentMethodMapper())($order->payments->first()->method) :  'N/A',
                'created_at' => Carbon::parse($order->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i'),
                'delivered_at' => $order->delivered_at ? Carbon::parse($order->delivered_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i') : null,
                'items_count' => $order->items->count()
            ];
        })->toArray();
    }
}
