<?php

namespace App\Http\Requests\Receptionist\StudentInquiry;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentInquiryRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student_inquiries,email,' . $this->student_inquiry . ',id',

            'ethnicity' => 'required|max:255',
            'level_id' => 'nullable|exists:levels,id',
            'program_id' => 'nullable|exists:programs,id',
            'year_semester_id' => 'nullable|exists:year_semesters,id',
            'section_id' => 'nullable|exists:sections,id',
            'phone' => 'required|min:10',

            'dob' => ['required', new ValidDate],
            'gender' => 'required|in:Male,Female,Other',
            'caddress' => 'required',
            'paddress' => 'required',
            'caste' => 'nullable|max:255',
            'religion' => 'nullable|max:255',

            'parent_email' => 'nullable|email|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_contact' => 'nullable|string|max:20',
            'father_job' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_contact' => 'nullable|string|max:20',
            'mother_job' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_email' => 'nullable|email|max:255',
            'guardian_relation' => 'nullable|string|max:255',
            'guardian_job' => 'nullable|string|max:255',
            'guardian_contact' => 'nullable|string|max:20',
            'guardian_address' => 'nullable|string|max:500',
        ];
    }
}
