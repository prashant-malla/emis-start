<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'department' => 'required|unique:departments',
        ];
        if ($this->method() == 'PATCH' || $this->method == 'PUT'){
            $rules['department'] = 'required|unique:departments,department,'.$this->id;
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
            'department.required' => 'Department name is required.',
            'department.unique' => 'Department with similar name already exists.',
        ];
    }
}
