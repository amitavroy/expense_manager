<?php

use App\Enums\AccountTypeEnum;
use App\Models\Account;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

test('account has fillable attributes', function () {
    $account = new Account;

    expect($account->getFillable())->toBe([
        'name',
        'type',
        'balance',
        'currency',
        'is_active',
    ]);
});

test('account has correct casts', function () {
    $account = new Account;

    expect($account->getCasts())->toMatchArray([
        'is_active' => 'boolean',
        'type' => AccountTypeEnum::class,
    ]);
});

test('account belongs to user', function () {
    $account = new Account;

    expect($account->user())
        ->toBeInstanceOf(BelongsTo::class);
});
