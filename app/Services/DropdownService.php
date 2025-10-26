<?php

namespace App\Services;

use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Collection;

class DropdownService
{
    /**
     * Get all categories for the user
     * 
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return Category::query()
            ->select('id', 'name')
            ->where('type', TransactionTypeEnum::EXPENSE)
            ->get();
    }

    /**
     * Get all accounts for the user
     * 
     * @param User $user
     * @return Collection<int, Account>
     */
    public function getAccounts(User $user): Collection
    {
        return Account::query()
            ->select('id', 'name')
            ->where('user_id', $user->id)
            ->get();
    }
}
