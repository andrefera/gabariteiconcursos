<?php

namespace App\Modules\Users\Services\Actions;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

readonly class LoginUser
{
    public function __construct(
        public string $email,
        public string $password
    )
    {
    }

    public function execute(): array
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Credenciais inválidas!',
            ];
        }

        return [
            'success' => true,
            'token' => $token
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('email'),
            $request->get('password')
        );
    }
}
