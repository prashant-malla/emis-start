<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGrievanceRequest extends FormRequest
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
            'grievance_date' => ['required', new ValidDate],
            'location' => 'required',
            'tormentor_name' => 'required',
            'options' => 'required|array',
            'inform_to' => 'required',
            'grievant_mobile' => 'required|min:10',
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
            'location.required' => 'Location of incident is required.',
            'tormentor_name.required' => 'Name of the tormentor is required.',
            'options.required' => 'Please select complaints.',
            'inform_to.required' => 'Inform to is required.',
            'grievant_mobile.required' => 'Grievant Mobile Number to is required.',
        ];
    }
}
