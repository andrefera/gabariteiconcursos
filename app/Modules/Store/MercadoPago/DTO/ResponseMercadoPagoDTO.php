<?php

namespace App\Modules\Store\MercadoPago\DTO;

use App\Models\Enums\PaymentStatus;
use App\Support\Util\MercadoPagoUtil;
use MercadoPago\Resources\Payment;

readonly class ResponseMercadoPagoDTO
{
    public ?string $id;
    public ?string $statusDetail;

    public ?string $status;

    public ?string $message;
    public ?string $cardBrand;
    public ?int $installments;
    public ?string $paymentMethod;
    public ?string $pixData;
    public ?string $pixQrCode;
    public ?string $pixUrl;
    public ?string $pixExpirationDate;
    public ?string $ticketUrl;
    public ?string $ticketBarcode;

    public function __construct(
        ?Payment       $response,
        public bool    $success,
        public ?string $issuerId,
        public ?string $paymentMethodId,
        ?string        $message = null,

    )
    {
        $this->id = $response->id ?? null;
        $this->statusDetail = $response->status_detail ?? null;
        $this->status = $response ? MercadoPagoUtil::convertStatusPayment($response->status, $response->status_detail) : PaymentStatus::WAITING_PAYMENT->value;
        $this->message = $response ? MercadoPagoUtil::getMessage($response->status, $response->status_detail) : ($message ?: 'Erro ao processar pedido');
        $this->cardBrand = $response->payment_method_id ?? null;
        $this->installments = $response->installments ?? 1;
        $this->paymentMethod = $response->payment_type_id ?? null;
        $this->pixData = $response->point_of_interaction->transaction_data->qr_code_base64 ?? null;
        $this->pixQrCode = $response->point_of_interaction->transaction_data->qr_code ?? null;
        $this->pixUrl = $response->point_of_interaction->transaction_data->ticket_url ?? null;
        $this->pixExpirationDate = $response->date_of_expiration ?? null;
        $this->ticketUrl = $response->transaction_details?->external_resource_url ?? null;
        $this->ticketBarcode = $response->transaction_details?->barcode['content'] ?? null;
    }
}
