<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubDepartmentRequest extends FormRequest
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
            'department_id' => 'required',
            'name' => 'required|unique:sub_departments',
        ];
        if ($this->method() == 'PATCH' || $this->method == 'PUT'){
            $rules['name'] = 'required';
        }
        return $rules;
    }
}
