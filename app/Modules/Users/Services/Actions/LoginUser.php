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
            JWTAuth::invalidate($token);
            return [
                'success' => false,
                'msg' => 'Acesso não autorizado!',
            ];
        }

        // Configure token in cookie
        $cookie = cookie('jwt_token', $token, 60 * 24 * 7); // 7 days

        return [
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'cookie' => $cookie
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
