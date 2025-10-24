<?php

namespace App\Enums;

enum BillStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case SKIPPED = 'skipped';
    case CANCELLED = 'cancelled';
}
