<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class  UpdateStudentRequest extends FormRequest
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
        $promoted = $this->student->promotions()->exists();

        $rules = [
            'batch',
            'sname' => 'required',
            'email' => 'required',
            // 'password' => 'required|confirmed',
            'admission' => 'nullable',
            'ethnicity' => 'required',
            'section_id' => 'required',
            'roll' => 'nullable|unique:students,roll,' . $this->route('student')->id . ',id,year_semester_id,' . $this->input('year_semester_id') . ',section_id,' . $this->input('section_id'),
            'parent_email' => 'required',
            'profile_image' => 'nullable|file|image:png,jpeg,jpg,gif',
            'dob' => ['required', new ValidDate],
            'gender' => 'required|in:Male,Female,Other',
            'caddress' => 'required',
            'paddress' => 'required',
            'fathername' => 'required',
            'fathercontact' => 'required',
            'mothername' => 'required',
            'status' => 'required',
            'remarks' => 'nullable|string|max:255',
            'status_updated_at' => ['nullable', new ValidDate],
        ];

        if (!$promoted) {
            $rules['academic_year_id'] = 'required';
            $rules['level_id'] = 'required';
            $rules['program_id'] = 'required';
            $rules['year_semester_id'] = 'required';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'sname.required' => 'Full name is  required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation is required.',
            'ethnicity.required' => 'Please select ethnicity.',
            'level_id.required' => 'Please select level.',
            'program_id.required' => 'Please select program.',
            'type_id.required' => 'Please select year/semester.',
            'section_id.required' => 'Please select group.',
            'parent_email' => 'Parent email is required',
            'caddress' => 'Current address is required',
            'paddress' => 'Permanent address is required',
            'fathername' => 'Father name is required',
            'fathercontact' => 'Father contact number is required',
            'mothername' => 'Mother name is required',
        ];
    }
}
