<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case EXPENSE = 'expense';
    case INCOME = 'income';
}
