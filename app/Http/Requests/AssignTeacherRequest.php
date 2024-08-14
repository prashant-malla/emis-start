<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherRequest extends FormRequest
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
            'teacher_id.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'teacher_id.*.required' => 'Some of the teacher fields are empty! Please select teacher in all the fields.'
        ];
    }
}
