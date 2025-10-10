<?php

namespace Database\Seeders;

use App\Enums\TransactionTypeEnum;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::firstOrCreate(
            ['email' => 'reachme@amitavroy.com'],
            [
                'name' => 'Amitav Roy',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'jhon.doe@gmail.com'],
            [
                'name' => 'Jhon Doe',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        collect([
            'HDFC Bank Saving',
            'ICICI Bank Credit Card',
            'Axis Bank Credit Card',
        ])->each(function ($account) use ($user) {
            Account::factory()->create([
                'user_id' => $user->id,
                'name' => $account,
            ]);
        });

        collect([
            'Food',
            'Transport',
            'Rent',
            'Bills',
            'Entertainment',
            'Other',
        ])->each(function ($category) {
            Category::factory()->create([
                'name' => $category,
                'type' => TransactionTypeEnum::EXPENSE,
            ]);
        });

        collect([
            'Salary',
            'Freelance',
            'Other',
        ])->each(function ($category) {
            Category::factory()->create([
                'name' => $category,
                'type' => TransactionTypeEnum::INCOME,
            ]);
        });

        collect([
            [
                'user_id' => $user->id,
                'account_id' => 1,
                'category_id' => 1,
                'amount' => 500,
                'description' => 'Dinner with friends',
                'date' => now(),
            ],
            [
                'user_id' => $user->id,
                'account_id' => 1,
                'category_id' => 1,
                'amount' => 250,
                'description' => 'Lunch with friends',
                'date' => now(),
            ],
            [
                'user_id' => $user->id,
                'account_id' => 1,
                'category_id' => 2,
                'amount' => 150,
                'description' => 'Going to office',
                'date' => now(),
            ],
        ])->each(function ($transaction) {
            Transaction::create($transaction);
        });

        collect([
            'HDFC Bank Saving',
        ])->each(function ($account) use ($user2) {
            Account::factory()->create([
                'user_id' => $user2->id,
                'name' => $account,
            ]);
        });
    }
}
