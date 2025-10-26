<?php

namespace App\Actions;

use App\Models\Biller;
use Illuminate\Support\Facades\Auth;

class AddBillerAction
{
    public function execute(array $data): Biller
    {
        $data['is_active'] = true;
        $data['user_id'] = Auth::user()->id;

        return Biller::create($data);
    }
}
