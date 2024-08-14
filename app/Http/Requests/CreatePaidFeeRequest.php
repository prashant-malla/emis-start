<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePaidFeeRequest extends FormRequest
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
    public function rules()
    {
        return [
            "student_id" => ['required', Rule::exists('students', 'id')],
            "date" => ['required', new ValidDate],
            "payment_mode" => 'required',
            "advance_amount" => 'nullable',
            "fine_amount" => 'nullable',
            "discount_amount" => 'nullable',
            "paid_amount" => 'nullable',
            "note" => 'nullable|string|max:255',
            "assign_fee_id" => 'present|array',
            "fine_id" => 'present|array',
            // "old_dues_id" => 'nullable',
            "old_balance" => 'nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'assign_fee_id' => $this->assign_fee_id ?? [],
            'fine_id' => $this->fine_id ?? [],
            'paid_amount' => $this->paid_amount ?? 0,
            'fine_amount' => $this->fine_amount ?? 0,
            'discount_amount' => $this->discount_amount ?? 0,
            'advance_amount' => $this->advance_amount ?? 0,
            'old_balance' => $this->old_balance ?? 0,
        ]);
    }

    public function messages()
    {
        return [
            'assign_fee_id.required' => 'Please choose Fee items.',
        ];
    }
}
