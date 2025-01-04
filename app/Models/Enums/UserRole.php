<?php

namespace App\Models\Enums;

enum UserRole: string
{
    case CUSTOMER = 'customer';

    case ADMIN = 'admin';
}
