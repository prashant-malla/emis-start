<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeDiscountRequest extends FormRequest
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
            'name' => 'required',
            'discount_code' => 'required',
            'fee_type_id' => 'required',
            'discount_type' => 'required',
            'amount' => 'nullable|integer',
            'percentage' => 'nullable|integer',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'discount_code.required' => 'Discount Code is required.',
            'fee_type_id.required' => 'Fee Type is required.',
            'discount_type.required' => 'Discount Type is required.',
        ];
    }
}
