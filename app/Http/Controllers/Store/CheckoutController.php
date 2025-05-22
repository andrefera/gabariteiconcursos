<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Modules\Store\Carts\DTO\CartDTO;
use App\Modules\Store\Orders\Services\Actions\StoreOrder;
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
            return redirect()->to('/carrinho');
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

        try {
            // Preparar os dados para a API do Melhor Envio
            $payload = [
                'from' => [
                    'postal_code' => '37131652' // CEP de origem (seu depósito/loja)
                ],
                'to' => [
                    'postal_code' => str_replace(['-', '.'], '', $address->zip_code)
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
                'Authorization' => 'Bearer ' . env('MELHOR_ENVIO_TOKEN'),
                'User-Agent' => 'Aplicação contato@ellonsports.com.br'
            ])->post(env('MELHOR_ENVIO_URL'), $payload);

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
            
            // Em caso de erro, retorna opções padrão
            $fallbackOptions = [
                [
                    'name' => 'PAC',
                    'price' => 8.50,
                    'days' => 5,
                    'company' => 'Correios',
                ],
                [
                    'name' => 'SEDEX',
                    'price' => 12.50,
                    'days' => 2,
                    'company' => 'Correios',
                ],
                [
                    'name' => 'Mini Envios',
                    'price' => 6.50,
                    'days' => 7,
                    'company' => 'Correios',
                ]
            ];

            // Cache the fallback rates for 30 minutes
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
            $cart->shippings()->delete(); // Remove shipping anterior se existir
            
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
            return redirect()->to('/carrinho');
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
}
