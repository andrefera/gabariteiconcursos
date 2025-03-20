<?php

namespace App\Models\Enums;

enum CartStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
}
