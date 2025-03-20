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
use Throwable;

readonly class Pay
{

    protected PaymentClient $paymentClient;

    public function __construct(
        public Cart    $cart,
        public Order    $order,
        public string  $paymentMethodId,
        public ?string $issuerId,
        public ?string $cardHash,
        public float   $totalAmount,
        public int     $installments,
    )
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        $this->paymentClient = new PaymentClient();
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

            if ($this->paymentMethodId === PaymentMethod::PIX->value) {
                $parameters['date_of_expiration'] = Carbon::now()
                    ->addWeekDays(env('MERCADOPAGO_PIX_DIAS_VENCIMENTO', 5))
                    ->isoFormat('YYYY-MM-DDTHH:mm:ss.SSSZ');

            } elseif ($this->paymentMethodId === PaymentMethod::TICKET->value) {
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
                            'street_number' => $this->keepOnlyNumbers($this->cart->user->street_number)
                        ]
                    ]
                ];

                $parameters['additional_info']['shipments']['receiver_address'] = [
                    'street_name' => $this->order->address->street,
                    'street_number' => $this->keepOnlyNumbers($this->order->address->number),
                    'zip_code' => $this->order->address->zip_code,
                    'apartment' => $this->order->address->complement,
                    'floor' => null,
                ];
            }

            Log::info("--------------------------");

            Log::info(json_encode($parameters, JSON_PRETTY_PRINT));
            $payment = $this->paymentClient->create($parameters);

            Log::info("--------------------------");

            return new ResponseMercadoPagoDTO($payment, true, $this->issuerId, $this->paymentMethodId);

        } catch (Throwable $e) {
            Log::info($e->getApiResponse()->getContent());
            Log::error($e);

            return new ResponseMercadoPagoDTO(null, false, null, null, null);
        }
    }

    private function getCategoryId(string $type): string
    {
        return match ($type) {
            ProductType::SHIRT->value, ProductType::SHORTS->value => "MLB3530", // Roupas e acessórios
            "chuteira", "tenis" => "MLB271597", // Chuteiras
            "bola" => "MLB271601", // Bolas de futebol
            "meião", "luva", "caneleira" => "MLB271601", // Acessórios esportivos
            default => "MLB3530", // Padrão para roupas e acessórios
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
