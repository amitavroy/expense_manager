<?php

namespace App\Actions;

use App\Models\Bill;
use App\Models\User;
use Carbon\Carbon;

class AddBillAction
{
    public function execute(array $data, User $user): Bill
    {
        $data['user_id'] = $user->id;
        $data['next_payment_date'] = Carbon::parse($data['next_payment_date']);

        return Bill::create($data);
    }
}
