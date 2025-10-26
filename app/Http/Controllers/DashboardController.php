<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $transactions = Transaction::query()
            ->with(['account', 'category'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(10);

        $accounts = Account::query()
            ->where('user_id', Auth::user()->id)
            ->orderBy('name')
            ->paginate(10);

        return Inertia::render('dashboard', [
            'transactions' => $transactions,
            'accounts' => $accounts,
        ]);
    }
}
