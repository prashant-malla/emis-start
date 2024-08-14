<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePhoneCallLogRequest extends FormRequest
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
            'phone'=>'required',
            'date' => ['required', new ValidDate],
            'follow_up_date' => ['required', new ValidDate],
            'call_type'=>'required'
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages(){
        return [
            'name.required' => 'Name is required.',
            'phone.required' => 'Caller Phone Number is required.',
            'date.required' => 'Date is required.',
            'follow_up_date.required' => 'Next Follow Up Date is required.',
            'call_type.required' => 'Call Type is required.',
        ];
    }
}
