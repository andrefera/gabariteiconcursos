<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, insira um e-mail válido.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Verifica se o e-mail já existe
            $existing = Newsletter::where('email', $request->email)->first();
            
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este e-mail já está cadastrado na nossa newsletter.'
                ], 409);
            }

            // Cria o registro
            Newsletter::create([
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'E-mail cadastrado com sucesso! Obrigado por se inscrever.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar sua solicitação. Tente novamente mais tarde.'
            ], 500);
        }
    }
}
