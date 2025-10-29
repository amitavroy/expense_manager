<?php

namespace App\Http\Requests;

use App\Enums\BillFrequencyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'biller_id' => ['required', 'exists:billers,id'],
            'default_amount' => ['required', 'numeric', 'min:0'],
            'frequency' => ['required', Rule::enum(BillFrequencyEnum::class)],
            'day_of_month' => ['nullable', 'date'],
            'interval_days' => ['nullable', 'integer', 'min:1'],
            'auto_generate_bill' => ['required', 'boolean'],
        ];
    }
}
