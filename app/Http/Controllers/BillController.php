<?php

namespace App\Http\Controllers;

use App\Actions\AddBillAction;
use App\Http\Requests\StoreBillRequest;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function store(StoreBillRequest $request, AddBillAction $addBillAction)
    {
        $data = $request->validated();

        $bill = $addBillAction->execute($data, Auth::user());

        return redirect()->route('billers.show', $bill->biller_id);
    }

    public function update(StoreBillRequest $request, Bill $bill)
    {
        return ['bill' => $bill];
    }
}
