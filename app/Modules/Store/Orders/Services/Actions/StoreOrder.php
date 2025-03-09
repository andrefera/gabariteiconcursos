<?php

namespace App\Modules\Store\Orders\Services\Actions;

use App\Models\Coupon;
use App\Models\Enums\OrderStatus;
use App\Models\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Modules\Store\MercadoPago\Services\Actions\Pay;
use App\Modules\Store\Orders\DTO\PaymentResponseDTO;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class StoreOrder
{

    public function __construct(
        public int     $addressId,
        public ?string $cardHash,
        public string  $paymentMethodId,
        public ?string $issuerId,
        public string  $method,
        public int     $installments,
        public float   $totalPrice,
        public float   $finalPrice,
        public float   $installmentPrice,
        public ?string $coupon,
        public string  $shippingCompany,
        public float   $shippingPrice,
        public string  $shippingMethod,
        public string  $shippingDays,
        public ?string $ip,
        public ?string $userAgent,
    )
    {
    }

    public function execute(): PaymentResponseDTO
    {
        $cart = Session::get('cart');

        if (!$cart) {
            return new PaymentResponseDTO('Carrinho não encontrado.', false);
        }

        if (!$cart->address) {
            return new PaymentResponseDTO('Selecione um endereço de entrega.', false);
        }

        $redisKey = "pending_order_{$cart->user->id}";

        DB::beginTransaction();

        try {
            $cart->refresh();

            $pendingId = Redis::get($redisKey);

            $coupon = Coupon::query()->where('code', trim($this->coupon))->first();
            $order = $pendingId ? Order::find($pendingId) : new Order();

            $order->fill([
                'user_id' => $cart->user->id,
                'cart_id' => $cart->id,
                'address_id' => $this->addressId,
                'status' => OrderStatus::NEW->value,
                'method' => $this->method,
                'total_price' => $this->totalPrice,
                'final_price' => $this->finalPrice,
                'discount' => $this->totalPrice - $this->finalPrice,
                'installments' => $this->installments,
                'installment_price' => $this->installmentPrice,
                'coupon_id' => $coupon?->id,
                'shipping_company' => $this->shippingCompany,
                'shipping_price' => $this->shippingPrice,
                'shipping_method' => $this->shippingMethod,
                'shipping_days' => $this->shippingDays,
                'remote_ip' => $this->ip,
                'user_agent' => substr($this->userAgent, 0, 510),
            ]);
            $order->save();

            foreach ($cart->items as $cartItem) {
                $orderItem = OrderItem::query()
                    ->where('order_id', $order->id)
                    ->where('product_id', $cartItem->product_id)
                    ->first();

                if (!$orderItem) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $cartItem->product_id;
                }

                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->product->getFinalPrice();
                $orderItem->save();

            }

            DB::commit();
        } catch (Exception $exception) {
            Log::error("Erro ao processar pedido: " . $exception->getMessage());
            DB::rollBack();

            return new PaymentResponseDTO('Erro ao processar pedido: ' . $exception->getMessage(), false);
        }

        $response = (new Pay(
            $cart,
            $order,
            $this->paymentMethodId,
            $this->issuerId,
            $this->cardHash,
            $this->finalPrice,
            $this->installments,
        ))->execute();

        $orderPayment = OrderPayment::query()->where('order_id', $order->id)->first();
        if (!$orderPayment) {
            $orderPayment = new OrderPayment();
        }

        $orderPayment->fill([
            'method' => $this->method,
            'installments' => $this->installments,
            'installment_value' => $this->installmentPrice,
            'amount' => $this->finalPrice,
            'card_hash' => $this->cardHash,
            'payment_data' => json_decode(json_encode($response), true)
        ]);
        $orderPayment->save();

        $invalid = $response->status === PaymentStatus::REFUSED->value
            || $response->status === PaymentStatus::CHARGEDBACK->value || $response->status === PaymentStatus::REJECTED->value
            || $response->status === PaymentStatus::ERROR_INFRASTRUCTURE->value;

        $order->refresh();
        $order->changeStatus($response->status);
        $order->save();

        if ($invalid) {
            Redis::set($redisKey, $order->id, 'EX', 3600);
            return new PaymentResponseDTO($response->message, false);
        }

        if ($response->success) {
            Redis::set($redisKey, null);
        } else {
            Redis::set($redisKey, $order->id, 'EX', 3600);
        }

        $cart->close();
        $order->refresh();

        return new PaymentResponseDTO($response->message, $response->success, $order->id);
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('address_id'),
            $request->get('card_hash'),
            $request->get('paymentMethodId'),
            $request->get('issuerId'),
            $request->get('method'),
            $request->get('installments', 1),
            $request->get('total_price'),
            $request->get('final_price'),
            $request->get('installment_price'),
            $request->get('coupon'),
            $request->get('shipping_company'),
            $request->get('shipping_price'),
            $request->get('shipping_method'),
            $request->get('shipping_days'),
            $request->getClientIp(),
            $request->userAgent()
        );
    }
}
