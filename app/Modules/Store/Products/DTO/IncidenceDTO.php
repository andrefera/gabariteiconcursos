<?php

namespace App\Modules\Store\Products\DTO;

readonly class IncidenceDTO
{
    public function __construct(
        public string $value,
        public int    $total,
    )
    {
    }
}
