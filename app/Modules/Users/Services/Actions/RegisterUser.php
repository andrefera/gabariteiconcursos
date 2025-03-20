<?php

namespace App\Modules\Users\Services\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

readonly class RegisterUser
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $passwordConfirmation,
    )
    {
    }

    public function execute(): array
    {
        $exist = User::query()->where('email', $this->email)->first();
        if ($exist) {
            return [
                'success' => false,
                'message' => 'E-mail já cadastrado!',
                'token' => null
            ];
        }

        if (trim($this->password) !== trim($this->passwordConfirmation)) {
            return [
                'success' => false,
                'message' => 'As senhas são diferentes.'
            ];
        }

        if (strlen(trim($this->password)) < 6) {
            return [
                'success' => false,
                'message' => 'A senha deve conter no mínimo 6 caracteres.'
            ];
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make(trim($this->password)),
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'success' => true,
            'message' => 'Usuário cadastrado com sucesso!',
            'token' => $token
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
            $request->get('password_confirmation')
        );
    }
}
