<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurposeRequest extends FormRequest
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
        $rules = [
            'purpose' => 'required|unique:purposes',
        ];
        if ($this->method == 'PUT' || $this->method() == 'PATCH'){
            $rules['purpose'] = 'required|unique:purposes';
        }
        return $rules;
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'purpose.required' => 'Purpose is required.',
            'purpose.unique' => 'Purpose already exists.',
        ];
    }
}
