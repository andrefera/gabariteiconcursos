<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteProfileRequest;
use App\Modules\Store\Users\Services\CompleteProfile;
use App\Modules\Store\Users\Services\Actions\GetUserProfile;
use App\Modules\Store\Users\Services\Actions\GetOrderDetails;
use App\Modules\Store\Users\Services\Actions\GetUserOrders;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $result = (new GetUserProfile())->execute();

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return view('orders.index', $result['data']);
    }

    public function complete()
    {
        $user = Auth::user();
        
        $data = [
            'user' => $user,
            'address' => [
                'street' => $user->street_name,
                'number' => $user->street_number,
                'complement' => $user->street_complement,
                'neighborhood' => $user->street_neighborhood,
                'city' => $user->city,
                'state' => $user->state,
                'zipcode' => $user->zip_code,
            ]
        ];

        return view('profile.complete', $data);
    }

    public function completeStore(CompleteProfileRequest $request)
    {
        $result = CompleteProfile::fromRequest($request)->execute();

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'errors' => ['error' => $result['message']]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso!',
            'redirect' => route('checkout.index')
        ]);
    }

    public function getOrderDetails(Order $order)
    {
        $result = (new GetOrderDetails($order))->execute();

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $result['data']
        ]);
    }

    public function orders()
    {
        $result = (new GetUserOrders())->execute();

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return view('orders.orders', $result['data']);
    }

    public function addresses()
    {
        $result = (new GetUserProfile())->execute();

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return view('orders.addresses', $result['data']);
    }

    public function data()
    {
        $result = (new GetUserProfile())->execute();

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return view('orders.data', $result['data']);
    }

    public function updateData(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validar dados pessoais
            $request->validate([
                'name' => 'required|string|max:255',
                'document' => 'required|string|max:20',
                'phone' => 'nullable|string|max:20',
                'zip_code' => 'nullable|string|max:10',
                'street' => 'nullable|string|max:255',
                'number' => 'nullable|string|max:20',
                'complement' => 'nullable|string|max:255',
                'neighborhood' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:2',
            ]);

            // Atualizar dados pessoais
            $user->fill([
                'name' => $request->name,
                'document' => $request->document,
                'phone' => $request->phone,
                'zip_code' => $request->zip_code,
                'street_name' => $request->street,
                'street_number' => $request->number,
                'street_complement' => $request->complement,
                'street_neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state,
            ]);
            $user->save();

            return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar dados: ' . $e->getMessage());
        }
    }
} 