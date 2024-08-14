<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
            'level_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
        ];
        if ($this->method == 'PUT' || $this->method() == 'PATCH') {
            $rules = [
                'level_id' => 'required',
                'program_id' => 'required',
                'year_semester_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required',
            ];
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
            'level_id.required' => 'Please select level.',
            'program_id.required' => 'Please select program.',
            'year_semester_id.required' => 'Please select year/semester',
            'section_id.required' => 'Please select group.',
            'subject_id.required' => 'Please select subject.',
        ];
    }
}
