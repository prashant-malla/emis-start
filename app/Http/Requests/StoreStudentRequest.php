<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'sname' => 'required',
            'email' => 'required|unique:students',
            //'password' => 'required|confirmed',
            'admission' => 'nullable',
            'ethnicity' => 'required',
            'academic_year_id' => 'required',
            'batch_id' => 'required',
            'level_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required',
            'section_id' => 'required',
            'phone' => 'required|min:10',
            'roll' => 'nullable|unique:students,roll,NULL,id,year_semester_id,' . $this->input('year_semester_id') . ',section_id,' . $this->input('section_id'),
            'profile_image' => 'nullable|file|image:png,jpeg,jpg,gif',
            //'slc_certificate'=> 'required',
            //'high_school_certificate'=> 'required',
            'dob' => ['required', new ValidDate],
            'gender' => 'required|in:Male,Female,Other',
            'caddress' => 'required',
            'paddress' => 'required',
            'parent_email' => 'required',
            'fathername' => 'required',
            'fathercontact' => 'required',
            'mothername' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'sname.required' => 'Full name is  required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'Email should be unique.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation is required.',
            'admission.required' => 'Admission no is required.',
            'ethnicity.required' => 'Please select ethnicity.',
            'level_id.required' => 'Please select level.',
            'program_id.required' => 'Please select program.',
            'year_semester_id.required' => 'Please select year/semester.',
            'section_id.required' => 'Please select group.',
            'slc_certificate.required' => 'Please upload a file.',
            'high_school_certificate.required' => 'Please upload a file.',
            'caddress' => 'Current address is required',
            'paddress' => 'Permanent address is required',
            'parent_email' => 'Parent email is rquired',
            'fathername' => 'Father name is required',
            'fathercontact' => 'Father contact number is required',
            'mothername' => 'Mother name is required',
        ];
    }
}
