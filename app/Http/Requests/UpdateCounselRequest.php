<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCounselRequest extends FormRequest
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
            'counselt_name' => 'required',
            'counselling_type' => 'required',
            'level_id' => 'required_unless:counselling_type,Enrollment Counselling',
            'program_id' => 'required_unless:counselling_type,Enrollment Counselling',
            'year_semester_id' => 'required_unless:counselling_type,Enrollment Counselling',
            'section_id' => 'required_unless:counselling_type,Enrollment Counselling',
            'student_id' => 'required_unless:counselling_type,Enrollment Counselling',
            'counselte_name' => 'required_if:counselling_type,Enrollment Counselling',
            'ethnicity' => 'required_if:counselling_type,Enrollment Counselling',
            'issue' => 'required',
            'recommendation' => 'required',
            'counsel_date' => ['nullable', new ValidDate],
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
            'counselt_name.required' => 'Name of counsellor is required.',
            'ethnicity.required' => 'Please select Ethnicity.',
            'counselling_type.required' => 'Please select Types of Counselling.',
            'level_id.required_unless' => 'Please select Level',
            'program_id.required_unless' => 'Please select Program',
            'year_semester_id.required_unless' => 'Please select Year/Semester',
            'section_id.required_unless' => 'Please select Group',
            'student_id.required_unless' => 'Please select Student Name',
            'counselte_name.required_if' => 'Name of Counselee is required',
            'ethnicity.required_if' => 'Ethnicity is required',
            'issue.required' => 'Issue is required.',
            'recommendation.required' => 'Recommendation is required.',
        ];
    }
}
