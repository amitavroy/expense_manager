<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypeEnum;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // validate the request
        $data = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // check the account balance
        $account = Account::findOrFail($data['account_id']);
        $category = Category::findOrFail($data['category_id']);
        if ($account->balance < $data['amount']) {
            // need to handle
        }

        // create the transaction
        $transaction = DB::transaction(function () use ($data, $account, $category) {
            $transaction = Transaction::create([
                'user_id' => 1, // TODO: get the user id
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
