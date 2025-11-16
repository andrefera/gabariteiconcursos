<?php

namespace App\Modules\Admin\Orders\Services\Actions;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Support\Util\MercadoPagoUtil;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

readonly class MercadoPagoWebhookHandlerAction
{
    public function __construct(
        private string $type,
        private string $id
    ) {

        MercadoPagoConfig::setAccessToken(config('services.mercado_pago.access_token'));
    }

    public function execute(): void
    {

        if ($this->type !== 'payment') {
            return;
        }

        try {
            $paymentClient = new PaymentClient();
            $payment = $paymentClient->get($this->id);
            Log::info("MercadoPago $payment->id -> $payment->status ($payment->status_detail)");

            $this->changeStatusOrderPayment($payment->id, MercadoPagoUtil::convertStatusPayment($payment->status, $payment->status_detail));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function changeStatusOrderPayment(string $paymentId, string $status): void
    {
        $orderPayment = OrderPayment::query()->where('transaction_id', $paymentId)->first();
        if (!$orderPayment) {
            return;
        }

        /**
         * @var Order $order
         */
        $order = $orderPayment->order;

        $lastPayment = $order?->payments()->orderByDesc('id')->first();
        if (!$lastPayment || $lastPayment->id !== $orderPayment->id) {
            Log::info("Gateway notify $order->increment_id $order->status last payment $lastPayment->id diferent notify payment $orderPayment->id");
            return;
        }

        if ($order->changeStatus($status)) {
            $order->save();
            Log::info("Gateway notify $order->increment_id $order->status");
        } else {
            Log::info("Gateway Redundant $status $order->increment_id");
        }
    }
}
