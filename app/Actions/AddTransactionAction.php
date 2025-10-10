<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Enums\TransactionTypeEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AddTransactionAction
{
    public function execute(array $data, Category $category, Account $account, User $user): Transaction
    {
        $transaction = DB::transaction(function () use ($data, $account, $category, $user) {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
                'category_id' => $category->id,
                'amount' => $data['amount'],
                'date' => $data['date'],
                'description' => $data['description'],
            ]);

            match ($category->type) {
                TransactionTypeEnum::EXPENSE => $account->decrement('balance', $data['amount']),
                TransactionTypeEnum::INCOME => $account->increment('balance', $data['amount']),
            };

            return $transaction;
        });

        return $transaction;
    }
}
