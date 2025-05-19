<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteProfileRequest;
use App\Modules\Store\Users\Services\CompleteProfile;
use App\Rules\ValidCep;
use App\Rules\ValidCpf;
use App\Rules\ValidPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
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
} 