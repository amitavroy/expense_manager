<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\User;

class AddAccountAction
{
    public function execute(array $data, User $user): Account
    {
        $data['currency'] = 'INR';
        $data['is_active'] = true;
        $data['user_id'] = $user->id;

        return Account::create($data);
    }
}
