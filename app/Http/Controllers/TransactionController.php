<?php

namespace App\Http\Controllers;

use App\Actions\AddTransactionAction;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;

class TransactionController extends Controller
{
    public function store(StoreTransactionRequest $request, AddTransactionAction $action)
    {
        // TODO: get the authentication in place
        $user = User::find(1);
        Auth::login($user);
        $data = $request->validated();

        $category = Context::pull('category');
        $account = Context::pull('account');

        // create the transaction
        $transaction = $action->execute($data, $category, $account, $user);

        return response()->json($transaction);
    }
}
