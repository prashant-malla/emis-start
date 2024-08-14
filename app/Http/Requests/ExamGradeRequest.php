<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamGradeRequest extends FormRequest
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
            'grade_name' => 'required',
            'percentage_from' => 'required',
            'percentage_to' => 'required',
            'grade_point' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'grade_name.required' => 'Grade name is required.',
            'percentage_from.required' => 'Percentage from is required.',
            'percentage_to.required' => 'Percentage to is required.',
            'grade_point.required' => 'Grade point is required.'
        ];
    }
}
