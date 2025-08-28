<?php

namespace App\Modules\Users\Services\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

readonly class ChangePassword
{
    public function __construct(
        public string $current_password,
        public string $new_password
    )
    {
    }

    public function execute(): array
    {
        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            return [
                'success' => false,
                'message' => 'A senha atual está incorreta.',
            ];
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        return [
            'success' => true,
            'message' => 'Senha alterada com sucesso!'
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('current_password'),
            $request->get('new_password')
        );
    }
}
