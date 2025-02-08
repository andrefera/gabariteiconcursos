<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Enums\PaymentMethod;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\InvalidArgumentException;
use MercadoPago\MercadoPagoConfig;


class CheckoutController extends Controller
{
    protected PaymentClient $paymentClient;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
        $this->paymentClient = new PaymentClient();
    }

    public function index(): View|Factory|Application
    {
        return view('checkout.index');
    }

    public function pay(Request $request): JsonResponse
    {
        $paymentMethod = $request->get('payment_method_id');

        $paymentData = [
            "transaction_amount" => (float)$request->get('amount'),
            "description" => "Compra na Loja Ellon Sports",
            "payer" => [
                "email" => $request->get('email')
            ],
        ];

        if ($paymentMethod === PaymentMethod::VISA->value || $paymentMethod === PaymentMethod::MASTERCARD->value) {
            $paymentData["token"] = $request->get('token');
            $paymentData["installments"] = (int)$request->get('installments', 1);
            $paymentData["payment_method_id"] = $paymentMethod;
            $paymentData["payer"]["identification"] = [
                "type" => "CPF",
                "number" => $request->get('docNumber')
            ];
        } elseif ($paymentMethod === PaymentMethod::PIX->value) {
            $paymentData["payment_method_id"] = "pix";
        } elseif ($paymentMethod === PaymentMethod::TICKET->value) {
            $paymentData["payment_method_id"] = "bolbradesco";
        }

        try {
            $payment = $this->paymentClient->create($paymentData);

            if ($payment->status == 'approved' || $payment->status == 'pending') {
                $response = [
                    'success' => true,
                    'message' => 'Pagamento processado com sucesso!',
                    'payment_id' => $payment->id,
                ];

                if ($paymentMethod === PaymentMethod::PIX->value) {
                    $response['qr_code'] = $payment->point_of_interaction->transaction_data->qr_code_base64;
                }

                if ($paymentMethod === PaymentMethod::TICKET->value) {
                    $response['boleto_url'] = $payment->transaction_details->external_resource_url;
                }

                return response()->json($response);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao processar pagamento: ' . $payment->status_detail
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na API do Mercado Pago: ' . $e->getMessage()
            ]);
        }
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function failure()
    {
        return view('checkout.failure');
    }

    public function pending()
    {
        return view('checkout.pending');
    }
}
