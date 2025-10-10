<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Context;

class StoreTransactionRequest extends FormRequest
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
            'account_id' => ['required'],
            'category_id' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $data = $validator->safe()->only(['account_id', 'category_id', 'amount']);
            $account = Account::find($data['account_id']);

            // TODO: check if the account belongs to the user
            if (! $account) {
                $validator->errors()->add('account_id', 'Account not found');
            }

            if ($account->balance < $data['amount']) {
                $validator->errors()->add('amount', 'Insufficient balance');
            }

            $category = Category::find($data['category_id']);
            if (! $category) {
                $validator->errors()->add('category_id', 'Category not found');
            }

            Context::add('account', $account);
            Context::add('category', $category);
        });
    }
}
