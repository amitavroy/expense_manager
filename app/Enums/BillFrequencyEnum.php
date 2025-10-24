<?php

namespace App\Enums;

enum BillFrequencyEnum: string
{
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case HALF_YEARLY = 'half_yearly';
    case YEARLY = 'yearly';
    case CUSTOM = 'custom';
}
