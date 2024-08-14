<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
        $isAdmin = Auth::check();
        $isStaff = !$isAdmin && Auth::guard('staff')->check();
        $isStudent = !$isAdmin && !$isStaff && Auth::guard('student')->check();
        $validFileMimes = 'docx,doc,pdf,xls,xlsx';

        if ($isAdmin) {
            return [
                'name' => 'required',
                'email' => 'required|email',
                'profile_image' => 'nullable|image|max:5120',
            ];
        }

        if ($isStaff) {
            return [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|size:10',
                'gender' => 'required',
                'dob' => ['required', new ValidDate],
                'marital_status' => 'required',
                'current_address' => 'nullable',
                'permanent_address' => 'nullable',
                'emergency_phone' => 'nullable|size:10',
                'father_name' => 'nullable',
                'mother_name' => 'nullable',
                'pan_number' => 'nullable',
                'work_shift' => 'nullable',
                'bank_name' => 'nullable',
                'bank_account_name' => 'nullable',
                'bank_account_number' => 'nullable',
                'bank_branch_name' => 'nullable',
                'facebook_link' => 'nullable',
                'instagram_link' => 'nullable',
                'twitter_link' => 'nullable',
                'linkedin_link' => 'nullable',
                'profile_image' => 'nullable|image|max:5120',
                'resume' => 'nullable|max:10240|mimes:'.$validFileMimes,
                'joining_letter' => 'nullable|max:10240|mimes:'.$validFileMimes,
                'document' => 'nullable|max:10240|mimes:'.$validFileMimes,
            ];
        }

        if ($isStudent) {
            return [
                'sname' => 'required',
                'email' => 'required',
                'phone' => 'required|size:10',
                'gender' => 'required',
                'bloodgroup' => 'required',
                'dob' => ['required', new ValidDate],
                'caste' => 'nullable',
                'religion' => 'nullable',
                'caddress' => 'nullable',
                'paddress' => 'nullable',
                'parent_email' => 'required',
                'father_name' => 'required',
                'father_contact' => 'required|size:10',
                'father_job' => 'nullable',
                'mother_name' => 'required',
                'mother_contact' => 'nullable',
                'mother_job' => 'nullable',
                'profile_image' => 'nullable|image|max:5120',
                'slc_certificate' => 'nullable|max:10240|mimes:'.$validFileMimes,
                'high_school_certificate' => 'nullable|max:10240|mimes:'.$validFileMimes,
                'other_certificate' => 'nullable|max:10240|mimes:'.$validFileMimes,
            ];
        }
    }
}
