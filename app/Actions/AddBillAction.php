<?php

namespace App\Actions;

use App\Enums\BillFrequencyEnum;
use App\Models\Bill;
use App\Models\User;
use Carbon\Carbon;

class AddBillAction
{
    public function execute(array $data, User $user): Bill
    {
        $date = Carbon::parse($data['day_of_month']);

        $nextPaymentDate = match ($data['frequency']) {
            BillFrequencyEnum::WEEKLY->value => $date->addWeek(),
            BillFrequencyEnum::MONTHLY->value => $date->addMonth(),
            BillFrequencyEnum::QUARTERLY->value => $date->addQuarter(),
            BillFrequencyEnum::HALF_YEARLY->value => $date->addMonths(6),
            BillFrequencyEnum::YEARLY->value => $date->addYear(),
            BillFrequencyEnum::CUSTOM->value => $date->addDays($data['interval_days']),
        };

        $data['user_id'] = $user->id;
        $data['next_payment_date'] = $nextPaymentDate;

        return Bill::create($data);
    }
}
