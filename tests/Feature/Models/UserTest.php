<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('user has fillable attributes', function () {
    $user = new User();

    expect($user->getFillable())
        ->toBe([
            'name',
            'email',
            'password',
        ]);
});

test('user has correct hidden fields', function () {
    $user = new User();

    expect($user->getHidden())->toBe([
        'password',
        'remember_token',
    ]);
});

test('user has correct casts', function () {
    $user = new User();

    expect($user->getCasts())->toMatchArray([
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ]);
});

test('user has accounts', function () {
    $user = new User();

    expect($user->accounts())
        ->toBeInstanceOf(HasMany::class);
});
