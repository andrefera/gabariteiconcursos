<?php

namespace App\Modules\Users\Services\Actions;

use App\Models\Enums\UserRole;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

readonly class LoginUser
{
    public function __construct(
        public string $email,
        public string $password,
        public string $path,
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
                'msg' => 'Credenciais inválidas!',
            ];
        }

        $user = JWTAuth::user();

        if (str_starts_with($this->path, 'api/admin') && $user->role !== UserRole::ADMIN->value) {

            return [
                'success' => false,
                'msg' => 'Acesso não autorizado!',
            ];
        }

        return [
            'success' => true,
            'token' => $token,
            'name' => $user->name
        ];
    }

    public static function fromRequest(Request $request, string $path): self
    {
        return new self(
            $request->get('email'),
            $request->get('password'),
            $path
        );
    }
}
