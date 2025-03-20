<?php

namespace App\Modules\Users\DTO;

use App\Models\User;

readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $role,
    )
    {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            $user->id,
            $user->name,
            $user->email,
            $user->role,
        );
    }
}
