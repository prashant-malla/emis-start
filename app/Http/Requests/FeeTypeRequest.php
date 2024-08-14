<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeTypeRequest extends FormRequest
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
            'fee_code' => 'required',
            'account_category_id' => 'required',
            'submission_type' => 'required',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'account_category_id.required' => 'Account Category is required.',
            'fee_code.required' => 'Fee Code is required.',
            'submission_type.required' => 'Submission Type is required.',
        ];
    }
}
