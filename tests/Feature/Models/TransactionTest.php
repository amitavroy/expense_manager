<?php

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

test('transaction has fillable attributes', function () {
    $transaction = new Transaction;

    expect($transaction->getFillable())->toBe([
        'user_id',
        'account_id',
        'category_id',
        'amount',
        'date',
        'description',
    ]);
});

test('transaction has correct casts', function () {
    $transaction = new Transaction;

    expect($transaction->getCasts())->toMatchArray([
        'amount' => 'decimal:2',
        'date' => 'date',
    ]);
});

test('transaction belongs to user', function () {
    $transaction = new Transaction;

    expect($transaction->user())
        ->toBeInstanceOf(BelongsTo::class);
});

test('transaction belongs to account', function () {
    $transaction = new Transaction;

    expect($transaction->account())
        ->toBeInstanceOf(BelongsTo::class);
});

test('transaction belongs to category', function () {
    $transaction = new Transaction;

    expect($transaction->category())
        ->toBeInstanceOf(BelongsTo::class);
});
