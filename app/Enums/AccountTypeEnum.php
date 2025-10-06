<?php

namespace App\Enums;

enum AccountTypeEnum: string
{
    case BANK = 'bank';
    case CASH = 'cash';
    case CREDIT_CARD = 'credit_card';
}
