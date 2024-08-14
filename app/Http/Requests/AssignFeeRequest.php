<?php

namespace App\Http\Requests;

use App\Models\FeeMaster;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignFeeRequest extends FormRequest
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
        $feeMaster = $this->route('feeMaster');

        return [
            'students' => 'required',
            'month_name' => ['nullable', Rule::requiredIf(fn () => $feeMaster->fee_type->submission_type === 'Monthly'), Rule::in(MONTHNAMES)],
        ];
    }

    public function messages()
    {
        return [
            'students.required' => 'Please select students.'
        ];
    }
}
