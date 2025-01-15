<?php

namespace App\Modules\Shop\Users\Services\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

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
        $user = JWTAuth::parseToken()->authenticate();

        if (!Hash::check($this->current_password, $this->password)) {
            return [
                'success' => false,
                'message' => 'A senha atual está incorreta.',
            ];
        }


        $user->password = Hash::make($this->new_password);
        $user->save();

        $newToken = JWTAuth::fromUser($user);

        return [
            'success' => true,
            'message' => 'Senha alterada com sucesso!',
            'token' => $newToken
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
