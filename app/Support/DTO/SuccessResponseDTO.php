<?php

namespace App\Support\DTO;

readonly class SuccessResponseDTO
{
    public function __construct(
        public bool    $success,
        public ?string $message = null,
    )
    {
    }
}
