<?php

namespace App\Http\Controllers;

use App\Actions\AddTransactionAction;
use App\Actions\UpdateTransactionAction;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Services\DropdownService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function __construct(
        private readonly DropdownService $dropdownService
    ) {}

    public function index(): Response
    {
        $transactions = Transaction::query()
            ->with(['account', 'category'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(10);

        return Inertia::render('transactions/index', [
            'transactions' => $transactions,
        ]);
    }

    public function show(Transaction $transaction): Response
    {
        $accounts = $this->dropdownService->getAccounts(Auth::user());
        $categories = $this->dropdownService->getCategories();

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
        $accounts = $this->dropdownService->getAccounts(Auth::user());
        $categories = $this->dropdownService->getCategories();
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

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->load(['account', 'category']);
        abort_if($transaction->user_id !== Auth::user()->id, 403);

        if (
            $transaction->category->type === TransactionTypeEnum::INCOME &&
            $transaction->account->balance < $transaction->amount
        ) {
            abort(403, 'Insufficient funds');
        }

        DB::transaction(function () use ($transaction) {
            match ($transaction->category->type) {
                TransactionTypeEnum::EXPENSE => $transaction->account->increment('balance', $transaction->amount),
                TransactionTypeEnum::INCOME => $transaction->account->decrement('balance', $transaction->amount),
            };

            $transaction->delete();
        });

        return redirect()->route('transactions.index');
    }
}
