<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreHomeworkRequest extends FormRequest
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
            'academic_year_id' => 'required|exists:academic_years,id',
            'batch_id' => 'nullable|exists:batches,id',
            'level_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required|exists:year_semesters,id',
            'section_id' => 'required',
            'subject_id' => 'required',
            'assign' => ['required', new ValidDate],
            'submission' => ['required', new ValidDate],
            'submission_time' => 'required',
            'teacher_id' => 'required',
            'image' => 'mimes:png,jpg,jpeg,pdf|max:2048',
            'report' => 'required'
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
            'level_id.required' => 'Please select level.',
            'program_id.required' => 'Please select program.',
            'section_id.required' => 'Please select group.',
            'subject_id.required' => 'Please select the subject.',
            'assign.required' => 'Assign date is required.',
            'submission.required' => 'Submission date is required.',
            'submission_time.required' => 'Submission time is required.',
            'description.required' => 'Description is required.',
            'teacher_id.required' => 'Please select the teacher.',
            'image.required' => 'Please upload the file.',
            'image.mimes' => 'Please upload jpeg,jpg,png or pdf only.',
            'teacher_id' => 'Please select the teacher.',
        ];
    }
}
