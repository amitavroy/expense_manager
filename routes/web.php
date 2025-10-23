<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::resource('accounts', AccountController::class)
        ->except(['edit']);

    Route::resource('transactions', TransactionController::class)
        ->except(['edit']);

    Route::resource('categories', CategoryController::class)
        ->except(['edit']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
