<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreStaffDirectoryRequest extends FormRequest
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
            'staff_id' => 'required|unique:staff_directories',
            'role_id' => 'required',
            'designation_id' => 'required',
            'department_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|size:10',
            'gender' => 'required',
            'dob' => ['required', new ValidDate],
            'marital_status' => 'required',
            'permanent_address' => 'required',
            'current_address' => 'required',
            'qualification' => 'required',
            'work_experience' => 'required',
            'father_name' => 'nullable',
            'mother_name' => 'nullable',
            'emergency_phone' => 'nullable|size:10',
            'date_of_joining' => ['nullable', new ValidDate],
            'pan_number' => 'nullable',
            'service_type' => 'required',
            'work_shift' => 'nullable',
            'basic_salary' => 'nullable',
            'bank_name' => 'nullable',
            'bank_account_name' => 'nullable',
            'bank_account_number' => 'nullable',
            'bank_branch_name' => 'nullable',
            'facebook_link' => 'nullable',
            'instagram_link' => 'nullable',
            'twitter_link' => 'nullable',
            'linkedin_link' => 'nullable',
            'profile_image' => 'nullable|file|image:png,jpeg,jpg,gif',
            'resume' => 'nullable|file|mimes:docx,doc,pdf,xls,xlsx',
            'joining_letter' => 'nullable|file|mimes:docx,doc,pdf,xls,xlsx',
            'document' => 'nullable|file|mimes:docx,doc,pdf,xls,xlsx',
            'level_id' => 'nullable',
            'program_id' => 'nullable',
            'year_semester_id' => 'nullable',
            'section_id' => 'nullable',
            'ethnicity' => 'required',
            'contract_type' => 'required'
        ];
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['profile_image'] = 'nullable|file|image:png, jpeg,jpg,gif';
            $rules['resume'] = 'nullable|file|mimes:docx,doc,pdf,xls,xlsx';
            $rules['joining_letter'] = 'nullable|file|mimes:docx,doc,pdf,xls,xlsx';
            $rules['document'] = 'nullable|file|mimes:docx,doc,pdf,xls,xlsx';
            $rules['staff_id'] = 'required';
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
            'staff_id.required' => 'Please enter staff id.',
            'name.required' => 'Please enter full name.',
            'email.required' => 'Please enter email address.',
            'phone.required' => 'Please enter phone number.',
            'role_id.required' => 'Please select role.',
            'contract_type.required' => 'Please choose Tenure',
        ];
    }
}
