<?php

use App\Enums\TransactionTypeEnum;
use App\Models\Category;

test('category has fillable attributes', function () {
    $category = new Category;

    expect($category->getFillable())
        ->toBe([
            'name',
            'type',
            'is_active',
        ]);
});

test('category has correct casts', function () {
    $category = new Category;

    expect($category->getCasts())->toMatchArray([
        'is_active' => 'boolean',
        'type' => TransactionTypeEnum::class,
    ]);
});
