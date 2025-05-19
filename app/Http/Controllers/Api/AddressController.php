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
            $data['is_default'] = true;

            $address = UserAddress::create($data);
            $user->addresses()
                ->where('id', '!=', $address->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);

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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $address->update($request->all());

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
            $address->delete();

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
