<?php

namespace App\Modules\Store\Orders\Services\Actions;

use App\Models\Cart;
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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

readonly class StoreOrder
{

    public function __construct(
        public ?string $cardHash,
        public string  $paymentMethodId,
        public ?string $issuerId,
        public string  $method,
        public int     $installments,
        public float   $totalPrice,
        public float   $finalPrice,
        public float   $installmentPrice,
        public ?string $coupon,
        public ?string $ip,
        public ?string $userAgent,
    )
    {
    }

    public function execute(): PaymentResponseDTO
    {
        /**
         * @var Cart|null $cart
         */
        $cart = Session::get('cart');

        if (!$cart) {
            return new PaymentResponseDTO('Carrinho não encontrado.', false);
        }

        $cart->refresh();

        $cacheKey = "pending_order_{$cart->user->id}";

        DB::beginTransaction();

        try {

            $pendingId = Cache::get($cacheKey);

            // Validate cart items stock
            foreach ($cart->items as $item) {
                if (!$item->product->checkStock($item->size, $item->quantity) || !$item->product->updateStock($item->size, $item->quantity)) {
                    throw new Exception("Produto {$item->product->name} não possui estoque suficiente.");
                }
            }

            $coupon = $this->coupon ? Coupon::query()->where('code', trim($this->coupon))->first() : null;
            $order = $pendingId ? Order::find($pendingId) : new Order();

            $order->fill([
                'user_id' => $cart->user->id,
                'cart_id' => $cart->id,
                'status' => OrderStatus::NEW->value,
                'method' => $this->method,
                'total_price' => $this->totalPrice,
                'final_price' => $this->installmentPrice * $this->installments,
                'discount' => $this->totalPrice - $this->finalPrice,
                'installments' => $this->installments,
                'installment_price' => $this->installmentPrice,
                'coupon_id' => $coupon?->id,
                'shipping_company' => $cart->shipping()->company,
                'shipping_price' => $cart->shipping()->price,
                'shipping_method' => $cart->shipping()->name,
                'shipping_days' => $cart->shipping()->days,
                'remote_ip' => $this->ip,
                'user_agent' => substr($this->userAgent, 0, 510),
            ])->save();

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

                $orderItem->size = $cartItem->size;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->product->getFinalPrice();
                $orderItem->save();

            }

            DB::commit();
        } catch (Exception $exception) {
            Log::error("Erro ao processar pedido: " . $exception->getMessage());
            Log::error($exception);
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
            $orderPayment->order_id = $order->id;
        }

        $orderPayment->fill([
            'method' => $this->method,
            'installments' => $this->installments,
            'installment_value' => $this->installmentPrice,
            'amount' => $this->finalPrice,
            'card_hash' => $this->cardHash,
            'payment_data' => json_encode($response),
            'transaction_id' => $response->id
        ]);
        $orderPayment->save();

        $invalid = !in_array($response->status, [PaymentStatus::PAID->value, PaymentStatus::WAITING_PAYMENT->value]);

        $order->refresh();
        $order->changeStatus($response->status);
        $order->save();

        if ($invalid) {
            Cache::put($cacheKey, $order->id, 3600);
            return new PaymentResponseDTO($response->message, false);
        }

        if ($response->success) {
            Cache::forget($cacheKey);
        } else {
            Cache::put($cacheKey, $order->id, 3600);
        }

        $cart->close();
        $order->refresh();

        return new PaymentResponseDTO($response->message, $response->success, $order->id);
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('token'),
            $request->get('payment_method_id'),
            $request->get('issuer_id'),
            $request->get('method'),
            $request->get('installments'),
            $request->get('total_price'),
            $request->get('final_price'),
            $request->get('installment_price'),
            $request->get('coupon'),
            $request->getClientIp(),
            $request->userAgent()
        );
    }
}
