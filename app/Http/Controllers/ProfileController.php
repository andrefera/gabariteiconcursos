<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteProfileRequest;
use App\Modules\Store\Users\Services\CompleteProfile;
use App\Modules\Store\Users\Services\Actions\GetUserProfile;
use App\Modules\Store\Users\Services\Actions\GetOrderDetails;
use App\Modules\Store\Users\Services\Actions\GetUserOrders;
use App\Models\Order;
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
} 