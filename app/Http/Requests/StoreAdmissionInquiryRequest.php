<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionInquiryRequest extends FormRequest
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
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'inquiry_date' => ['required', new ValidDate],
            'follow_up' => ['required', new ValidDate],
            'source_id' => 'required',
            'reference_id' => 'required|integer',
            'level_id' => 'required|integer',
            'program_id' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'full_name.required' => 'Name is required.',
            'phone.required' => 'Phone Number is required.',
            'email.required' => 'Email Address is required.',
            'address.required' => 'Address is required.',
            'inquiry_date.required' => 'Inquiry Date is required.',
            'follow_up.required' => 'Follow Up Date is required.',
            'source_id.required' => 'Please select Source.',
            'reference_id.required' => 'Please select Reference.',
            'level_id.required' => 'Please select Level.',
            'program_id.required' => 'Please select Program.',
        ];
    }
}
