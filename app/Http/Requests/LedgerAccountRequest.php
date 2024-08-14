<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LedgerAccountRequest extends FormRequest
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
            'account_category_id' => ['required', 'exists:account_categories,id'],
            'account_name' => ['required', 'string', 'max:255'],
            'balance' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'account_category_id.required' => 'Account Category is requierd'
        ];
    }
}
