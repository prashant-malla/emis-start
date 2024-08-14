<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateComplainRequest extends FormRequest
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
            'complainType_id' => 'required',
            'source_id' => 'required',
            'complain_by' => 'required',
            'phone' => 'required',
            'complain_date' => ['required', new ValidDate],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages(){
        return [
            'complainType_id.required' => 'Please Select Feedback Type.',
            'source_id.required' => 'Please Select Source.',
            'complain_by.required' => 'Feedback Given By is required.',
            'phone.required' => 'Phone Number is required.',
            'complain_date.required' => 'Feedback Date is required.',
        ];
    }
}
