<?php

namespace App\Modules\Admin\Orders\Services\Actions;

use App\Models\Order;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;

readonly class UpdateOrderAddress
{
    public function __construct(
        private int $orderId,
        private string $addressType,
        private array $addressData
    )
    {
    }

    public function execute(): array
    {
        try {
            $order = Order::query()->find($this->orderId);
            
            if (!$order) {
                return ['success' => false, 'msg' => 'Pedido não encontrado.'];
            }

            if ($this->addressType === 'billing') {
                $this->updateBillingAddress($order);
            } elseif ($this->addressType === 'shipping') {
                $this->updateShippingAddress($order);
            } else {
                return ['success' => false, 'msg' => 'Tipo de endereço inválido.'];
            }

            return ['success' => true, 'msg' => 'Endereço atualizado com sucesso.'];
        } catch (Exception $exception) {
            return ['success' => false, 'msg' => 'Erro ao atualizar endereço: ' . $exception->getMessage()];
        }
    }

    private function updateBillingAddress(Order $order): void
    {
        $user = $order->user;
        
        if (!$user) {
            throw new Exception('Usuário não encontrado para o pedido.');
        }

        $user->update([
            'street_name' => $this->addressData['street'],
            'street_number' => $this->addressData['number'],
            'street_neighborhood' => $this->addressData['neighborhood'],
            'street_complement' => $this->addressData['complement'] ?? null,
            'city' => $this->addressData['city'],
            'state' => $this->addressData['state'],
            'zip_code' => $this->addressData['zipcode'],
        ]);
    }

    private function updateShippingAddress(Order $order): void
    {
        $cartShipping = $order->cart?->shipping();
        
        if (!$cartShipping) {
            throw new Exception('Endereço de entrega não encontrado para o pedido.');
        }

        $address = $cartShipping->address;
        
        if (!$address) {
            throw new Exception('Endereço de entrega não encontrado.');
        }

        $address->update([
            'street' => $this->addressData['street'],
            'number' => $this->addressData['number'],
            'neighborhood' => $this->addressData['neighborhood'],
            'complement' => $this->addressData['complement'] ?? null,
            'city' => $this->addressData['city'],
            'state' => $this->addressData['state'],
            'zip_code' => $this->addressData['zipcode'],
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('order_id'),
            $request->get('address_type'),
            $request->get('address_data')
        );
    }
}
