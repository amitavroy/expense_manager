<?php

namespace App\Http\Controllers;

use App\Actions\AddTransactionAction;
use App\Actions\UpdateTransactionAction;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
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

    public function show(Transaction $transaction): Response
    {
        $accounts = $this->getDropdownData()['accounts'];
        $categories = $this->getDropdownData()['categories'];

        return Inertia::render('transactions/show', [
            'accounts' => $accounts,
            'categories' => $categories,
            'transaction' => $transaction,
        ]);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction, UpdateTransactionAction $action)
    {
        $data = $request->validated();

        // Pull the data from context
        $oldAccount = Context::pull('old_account');
        $newAccount = Context::pull('new_account');
        $oldCategory = Context::pull('old_category');
        $newCategory = Context::pull('new_category');
        $oldAmount = Context::pull('old_amount');

        $action->execute(
            transaction: $transaction,
            data: $data,
            newAccount: $newAccount,
            oldAccount: $oldAccount,
            newCategory: $newCategory,
            oldCategory: $oldCategory,
            oldAmount: $oldAmount,
        );

        return redirect()->route('transactions.show', $transaction);
    }

    public function create(): Response
    {
        $accounts = $this->getDropdownData()['accounts'];
        $categories = $this->getDropdownData()['categories'];
        $transaction = new Transaction;

        return Inertia::render('transactions/create', [
            'accounts' => $accounts,
            'categories' => $categories,
            'transaction' => $transaction,
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

    private function getDropdownData(): array
    {
        $accounts = Account::query()
            ->select('id', 'name')
            ->where('user_id', Auth::user()->id)
            ->get();

        $categories = Category::query()
            ->select('id', 'name')
            ->where('type', TransactionTypeEnum::EXPENSE)
            ->get();

        return [
            'accounts' => $accounts,
            'categories' => $categories,
        ];
    }
}
