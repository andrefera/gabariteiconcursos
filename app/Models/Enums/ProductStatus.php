<?php

namespace App\Models\Enums;

enum ProductStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
