<?php

namespace App\Http\Controllers;

use App\Actions\AddTransactionAction;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function index(): Response
    {
        $transactions = Transaction::query()
            ->with(['account', 'category'])
            ->orderByDesc('date')
            ->paginate(10);

        return Inertia::render('transactions/index', [
            'transactions' => $transactions,
        ]);
    }

    public function create(): Response
    {
        $accounts = Account::query()
            ->select('id', 'name')
            ->where('user_id', Auth::user()->id)
            ->get();

        $categories = Category::query()
            ->select('id', 'name')
            ->where('type', TransactionTypeEnum::EXPENSE)
            ->get();

        return Inertia::render('transactions/create', [
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    public function store(StoreTransactionRequest $request, AddTransactionAction $action): RedirectResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $category = Context::pull('category');
        $account = Context::pull('account');

        // create the transaction
        $transaction = $action->execute($data, $category, $account, $user);

        return redirect()->route('transactions.index');
    }
}
