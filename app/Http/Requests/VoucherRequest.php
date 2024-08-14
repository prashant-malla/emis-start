<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class VoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'type' => ['required'],
            'payment_method' => ['nullable', Rule::RequiredIf($request->type !== 'Journal'), Rule::in(PAYMENT_METHODS)],
            'cheque_number' => ['nullable', Rule::RequiredIf($request->payment_method === 'Bank'), 'string', 'max:15'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required'],
            'total_debit_amount' => ['same:total_credit_amount'],
            'ledger_account_id.*' => ['required']
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['amount' => floatval($this->total_credit_amount)]);
    }

    public function messages()
    {
        return [
            'total_debit_amount.same' => 'Total Debit Amount must be equal to Total Credit Amount.',
            'ledger_account_id.*' => 'Please select Ledger Accounts in all rows.'
        ];
    }
}
