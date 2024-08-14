<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
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
            'level_id' => 'required',
            'faculty_id' => 'nullable|exists:faculties,id',
            'name' => 'required|unique:programs,name' . ($this->method == 'PUT' || $this->method() == 'PATCH' ? ',' . $this->program->id : ''),
            'type' => 'required',
            'admission_fee' => 'required',
        ];
    }
/*    public function rules()
    {
        $rules = [
            'name' => 'required|unique:levels',
        ];
        if ($this->method == 'PUT' || $this->method() == 'PATCH'){
            $rules['name'] = 'required|unique:levels';
        }
        return $rules;
    }*/
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'level_id.required' => 'Please select level.',
            'name.required' => 'Program is required.',
            'name.unique' => 'Program with same name already exists.',
            'type.required' => 'Please select program type.',
            'admission_fee.required' => 'Admission fee is required.',
        ];
    }
}
