<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
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
            'organize' => 'required',
            'staff' => 'required',
            'employees'=>'required',
            'objective' => 'required',
            'receivers' => 'required',
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

            'organize.required'  => 'Please select type.',
            'staff.required' => 'title is required.',
            'employees.required'     => 'datee is required.',
            'objective.required'  => 'objective is required.',
         
        ];
    }
}
