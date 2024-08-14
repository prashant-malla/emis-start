<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitorBookRequest extends FormRequest
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
            'purpose_id' => 'required',
            'visitor_name' => 'required',
            'phone' => 'required',
            'date' => ['required', new ValidDate],
            'in_time' => 'required',
            'out_time' => 'required',
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
            'purpose_id.required'=> 'Please select purpose.',
            'visitor_name.required' => 'Name is required.',
            'phone.required' => 'Phone is required',
            'date.required' => 'Date is required',
            'in_time.required' => 'In Time is required',
            'out_time.required' => 'Out Time is required',
        ];
    }
}
