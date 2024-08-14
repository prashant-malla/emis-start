<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'emergency_phone' => 'required|size:10',
            'role_id' => 'required',
            'designation_id' => 'required',
            'department_id' => 'required',
            'date_of_joining' => ['required', new ValidDate],
            'pan_number' => 'nullable',
            'basic_salary' => 'nullable',
            'facebook_link' => 'nullable',
            'instagram_link' => 'nullable',
            'twitter_link' => 'nullable',
            'linkedin_link' => 'nullable',
            'profile_image' => 'nullable|file|image:png,jpeg,jpg,gif',
            'resume' => 'nullable|file|mimes:docx,doc,pdf,xls,xlsx',
            'joining_letter' => 'nullable|file|mimes:docx,doc,pdf,xls,xlsx',
            'document' => 'nullable|file|mimes:docx,doc,pdf,xls,xlsx',
        ];
 /*       if($this->method() == 'PATCH' || $this->method() == 'PUT'){
            $rules['profile_image'] = 'nullable|file|image:png, jpeg,jpg,gif';
            $rules['resume'] = 'nullable|file|mimes:docx,doc,pdf,xls,xlsx';
            $rules['joining_letter'] = 'nullable|file|mimes:docx,doc,pdf,xls,xlsx';
            $rules['document'] = 'nullable|file|mimes:docx,doc,pdf,xls,xlsx';
        }*/
        return $rules;
    }
}
