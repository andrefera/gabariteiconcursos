<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Modules\Store\Carts\DTO\CartDTO;
use App\Modules\Store\Orders\Services\Actions\StoreOrder;
use App\Support\Util\ShippingUtil;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $cart = Session::get('cart');
        if (!$cart) {
            return redirect()->to('/cart');
        }

        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        $cartDTO = CartDTO::fromCart($cart);

        return view('checkout.shipping', [
            'addresses' => $addresses,
            'cart' => $cartDTO,
        ]);
    }

    public function calculateShipping(UserAddress $address)
    {
        $cart = Session::get('cart');

        $cacheKey = "shipping_" . $address->zip_code . "_" . $cart->total;
        $zipCode = str_replace(['-', '.'], '', $address->zip_code);

        try {
            // Preparar os dados para a API do Melhor Envio
            $payload = [
                'from' => [
                    'postal_code' => '37131652' // CEP de origem (seu depósito/loja)
                ],
                'to' => [
                    'postal_code' => $zipCode
                ],
                'packages' => [
                    [
                        'width' => 20,
                        'height' => 10,
                        'length' => 15,
                        'weight' => 1
                    ]
                ]
            ];


            // Fazer a requisição para a API do Melhor Envio
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('services.melhor_envio.token'),
                'User-Agent' => 'Aplicação contato@ellonsports.com.br'
            ])->post(config('services.melhor_envio.url'), $payload);

            Log::info('Resposta Melhor Envio:', $response->json());

            if ($response->successful()) {
                $shippingOptions = [];
                $data = $response->json();

                foreach ($data as $option) {
                    if ($option['price'] !== null) {
                        $shippingOptions[] = [
                            'name' => $option['name'],
                            'price' => (float) $option['price'],
                            'days' => (int) $option['delivery_time'],
                            'company' => $option['company']['name']
                        ];
                    }
                }

                if (!empty($shippingOptions)) {
                    Cache::put($cacheKey, $shippingOptions, 3600); // Cache por 1 hora
                    return response()->json($shippingOptions);
                }
            }

            throw new \Exception('Não foi possível calcular o frete.');

        } catch (\Exception $e) {
            Log::error('Erro ao calcular frete:', ['error' => $e->getMessage()]);

            $fallbackOptions = ShippingUtil::getDefaultShipping($zipCode);

            Cache::put($cacheKey, $fallbackOptions, 1800);

            return response()->json($fallbackOptions);
        }
    }

    public function deleteAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id'
        ]);

        $address = UserAddress::where('user_id', Auth::user()->id)
            ->findOrFail($request->address_id);

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Endereço removido com sucesso'
        ]);
    }

    public function saveShipping(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_method' => 'required|string',
            'shipping_price' => 'required|numeric',
            'shipping_days' => 'required|integer',
            'shipping_company' => 'required|string'
        ]);

        $cart = Session::get('cart');
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Carrinho não encontrado'
            ], 404);
        }

        try {
            $cart->shippings()->delete();

            $cart->shippings()->create([
                'address_id' => $request->address_id,
                'name' => $request->shipping_method,
                'price' => $request->shipping_price,
                'days' => $request->shipping_days,
                'company' => $request->shipping_company
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Informações de envio salvas com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar informações de envio'
            ], 500);
        }
    }

    public function payment(): Factory|Application|View|RedirectResponse
    {
        $cart = Session::get('cart');
        if (!$cart) {
            return redirect()->to('/cart');
        }

        return view('checkout.payment', ['cart' => CartDTO::fromCart($cart)]);
    }

    public function pay(Request $request): JsonResponse
    {
        return response()->json(StoreOrder::fromRequest($request)->execute());
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

    public function confirmacaoPagamento($id)
    {
        $order = \App\Models\Order::with(['items', 'payments'])->find($id);
        if (!$order) {
            return view('checkout.payment-confirmed', ['order' => null]);
        }

        $paymentStatus = $order->status;
        $paymentStatusLabel = \App\Models\Enums\OrderStatus::toPortuguese($paymentStatus);
        $payment = $order->payments()->orderByDesc('id')->first();
        $paymentMethod = $payment->method ?? null;
        $paymentData = $payment ? json_decode($payment->payment_data ?? '{}', true) : [];

        // PIX
        $pixQrCode = $paymentData['pixData'] ?? $paymentData['pix_qr_code'] ?? null;
        $pixCode = $paymentData['pixQrCode'] ?? $paymentData['pix_code'] ?? null;
        // Boleto
        $boletoBarcode = $paymentData['ticketBarcode'] ?? $paymentData['boleto_barcode'] ?? null;
        $boletoUrl = $paymentData['ticketUrl'] ?? $paymentData['boleto_url'] ?? null;

        $orderSummary = [
            'payment_status' => $paymentStatus,
            'payment_status_label' => $paymentStatusLabel,
            'payment_method' => $paymentMethod,
            'pix_qr_code' => $pixQrCode,
            'pix_code' => $pixCode,
            'boleto_barcode' => $boletoBarcode,
            'boleto_url' => $boletoUrl,
            'final_price' => $order->final_price,
            'shipping_price' => $order->shipping_price,
            'items' => $order->items->map(function($item) {
                return [
                    'product_name' => $item->product->name ?? '',
                    'size' => $item->size,
                    'quantity' => $item->quantity,
                    'price_label' => \App\Support\Util\NumberUtil::formatPrice($item->price),
                ];
            }),
            'payment_message' => $paymentData['message'] ?? null,
        ];

        return view('checkout.payment-confirmed', ['order' => (object)$orderSummary]);
    }
}
