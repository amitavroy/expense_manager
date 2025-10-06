<?php

namespace Database\Seeders;

use App\Models\Account;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}
