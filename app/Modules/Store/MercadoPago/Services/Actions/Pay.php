<?php

namespace App\Modules\Store\MercadoPago\Services\Actions;

use App\Models\Cart;
use App\Models\Enums\PaymentMethod;
use App\Models\Enums\ProductType;
use App\Models\Order;
use App\Modules\Store\MercadoPago\DTO\ResponseMercadoPagoDTO;
use App\Support\Util\DateUtil;
use App\Support\Util\PhoneUtil;
use App\Support\Util\StringUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

readonly class Pay
{
    public function __construct(
        public Cart    $cart,
        public Order   $order,
        public string  $paymentMethodId,
        public ?string $issuerId,
        public ?string $cardHash,
        public float   $totalAmount,
        public int     $installments,
    ) {
        MercadoPagoConfig::setAccessToken(config('services.mercado_pago.access_token'));
    }

    public function execute(): ResponseMercadoPagoDTO
    {

        if (!$this->cart) {
            return new ResponseMercadoPagoDTO(null, false, null, null, 'Carrinho não encontrado');
        }

        try {

            $parameters = [
                'transaction_amount' => $this->totalAmount,
                'description' => "Nova Compra",
                'payment_method_id' => $this->paymentMethodId,
                'payer' => [
                    'email' => $this->cart->user->email,
                    'first_name' => StringUtil::extractNames($this->cart->user->name)['firstName'],
                    'last_name' => StringUtil::extractNames($this->cart->user->name)['lastName'],
                    'identification' => [
                        'type' => 'CPF',
                        'number' => str_replace(['.', '-'], '', $this->cart->user->document)
                    ]
                ]
            ];

            $parameters = match ($this->paymentMethodId) {
                PaymentMethod::PIX->value => $this->addPixParameters($parameters),
                PaymentMethod::TICKET->value => $this->addTicketParameters($parameters),
                PaymentMethod::VISA->value, PaymentMethod::MASTERCARD->value => $this->addCreditCardParameters($parameters),
                default => $parameters,
            };


            Log::info('--- Enviando pagamento para Mercado Pago ---');
            Log::info(json_encode($parameters, JSON_PRETTY_PRINT));

            $payment = (new PaymentClient())->create($parameters);

            Log::info(json_encode($payment, JSON_PRETTY_PRINT));

            Log::info("--------------------------");

            return new ResponseMercadoPagoDTO($payment, true, $this->issuerId, $this->paymentMethodId);
        } catch (MPApiException $throwable) {
            Log::error($throwable->getMessage());
            Log::error($throwable);

            return new ResponseMercadoPagoDTO(null, false, null, null, null);
        }
    }

    private function addCreditCardParameters(array  $parameters): array
    {
        $parameters['issuer_id'] = $this->issuerId;
        $parameters['token'] = $this->cardHash;
        $parameters['installments'] = $this->installments;

        $items = [];
        foreach ($this->cart->items as $item) {
            $items[] = [
                'id' => $item->product->sku,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->getFinalPrice(),
                'title' => $item->product->name,
                'category_id' => $this->getCategoryId($item->product->type),
                'description' => $item->product->name
            ];
        }

        $parameters['additional_info'] = [
            'items' => $items,
            'payer' => [
                'first_name' => StringUtil::extractNames($this->cart->user->name)['firstName'],
                'last_name' => StringUtil::extractNames($this->cart->user->name)['lastName'],
                'registration_date' => DateUtil::convertToAmericaSaoPaulo($this->cart->user->created_at)->format('Y-m-d H:i:s'),
                'phone' => [
                    'number' => PhoneUtil::getNumber($this->cart->user->phone),
                    'area_code' => PhoneUtil::getDDD($this->cart->user->phone)
                ],
                'address' => [
                    'zip_code' => $this->cart->user->zip_code,
                    'street_name' => $this->cart->user->street_name,
                    'street_number' => $this->cart->user->street_number ? $this->keepOnlyNumbers($this->cart->user->street_number) : 'N/A'
                ]
            ]
        ];

        return $parameters;
    }

    private function addTicketParameters(array  $parameters): array
    {
        $parameters['payer']['address'] = [
            'zip_code' => str_replace(['.', '-'], '', $this->cart->user->zip_code),
            'city' => $this->cart->user->city,
            'street_name' => $this->cart->user->street_name,
            'street_number' => $this->cart->user->street_number ? $this->keepOnlyNumbers($this->cart->user->street_number) : 'N/A',
            'neighborhood' => $this->cart->user->street_neighborhood,
            'federal_unit' => $this->cart->user->state,
        ];

        return $parameters;
    }

    private function addPixParameters(array $parameters): array
    {
        $parameters['date_of_expiration'] = Carbon
            ::now()
            ->addWeekDays(5)
            ->isoFormat('YYYY-MM-DDTHH:mm:ss.SSSZ');

        return $parameters;
    }

    private function getCategoryId(string $type): string
    {
        return match ($type) {
            ProductType::SHIRT->value, ProductType::SHORTS->value => "clothing_and_accessories",
            default => "others",
        };
    }

    private function keepOnlyNumbers(string $inputString): ?string
    {
        $numbers = preg_replace('/[^0-9]/', '', $inputString);
        if (empty($numbers)) {
            return null;
        }
        return $numbers;
    }
}
