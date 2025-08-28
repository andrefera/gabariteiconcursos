<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function show(UserAddress $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }

        return response()->json($address);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'zip_code' => 'required|size:9',
            'street' => 'required|max:255',
            'number' => 'required|max:20',
            'complement' => 'nullable|max:255',
            'neighborhood' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|size:2',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $user = Auth::user();
            $data['user_id'] = $user->id;
            
            // Se não há endereços, o primeiro deve ser padrão
            $userAddressesCount = $user->addresses()->count();
            if ($userAddressesCount === 0) {
                $data['is_default'] = true;
            } else {
                $data['is_default'] = $request->boolean('is_default', false);
            }

            $address = UserAddress::create($data);
            
            // Se este endereço foi marcado como padrão, remove o padrão dos outros
            if ($data['is_default']) {
                $user->addresses()
                    ->where('id', '!=', $address->id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Endereço cadastrado com sucesso',
                'address' => $address
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar endereço'
            ], 500);
        }
    }

    public function update(Request $request, UserAddress $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'zip_code' => 'required|size:9',
            'street' => 'required|max:255',
            'number' => 'required|max:20',
            'complement' => 'nullable|max:255',
            'neighborhood' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|size:2',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $user = Auth::user();
            
            // Se este endereço foi marcado como padrão, remove o padrão dos outros
            if ($request->boolean('is_default', false)) {
                $user->addresses()
                    ->where('id', '!=', $address->id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
            
            $address->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Endereço atualizado com sucesso',
                'address' => $address
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar endereço'
            ], 500);
        }
    }

    public function destroy(UserAddress $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }

        try {
            $user = Auth::user();
            $wasDefault = $address->is_default;
            
            $address->delete();
            
            // Se o endereço deletado era padrão, define outro como padrão
            if ($wasDefault) {
                $newDefaultAddress = $user->addresses()->first();
                if ($newDefaultAddress) {
                    $newDefaultAddress->update(['is_default' => true]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Endereço removido com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover endereço'
            ], 500);
        }
    }
}
