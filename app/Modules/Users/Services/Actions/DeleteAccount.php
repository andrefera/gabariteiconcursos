<?php

namespace App\Modules\Users\Services\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

readonly class DeleteAccount
{
    public function __construct(
        public string $password
    )
    {
    }

    public function execute(): array
    {
        $user = Auth::user();

        if (!Hash::check($this->password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Senha incorreta.',
            ];
        }

        try {
            // Alterar email para .disabled
            $originalEmail = $user->email;
            $user->email = $originalEmail . '.disabled';
            
            // Limpar informações pessoais
            $user->name = 'Usuário Excluído';
            $user->phone = null;
            $user->document = null;
            $user->birth_date = null;
            $user->zip_code = null;
            $user->city = null;
            $user->state = null;
            $user->street_name = null;
            $user->street_neighborhood = null;
            $user->street_number = null;
            $user->street_complement = null;
            
            // Limpar senha
            $user->password = '';
            
            // Salvar alterações
            $user->save();
            
            // Fazer logout
            Auth::logout();

            return [
                'success' => true,
                'message' => 'Conta excluída com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao excluir conta: ' . $e->getMessage()
            ];
        }
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('password')
        );
    }
}
