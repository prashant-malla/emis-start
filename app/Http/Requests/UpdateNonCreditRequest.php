<?php

namespace App\Http\Requests;

use App\Rules\AtLeastTwoWords;
use App\Rules\RequireFeeIfCourseIsPaidRule;
use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNonCreditRequest extends FormRequest
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
            'course_year' => 'required',
            'title' => 'required',
            'full_name' => ['required', new AtLeastTwoWords],
            'level_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'mv_address' => 'nullable',
            'tole' => 'nullable',
            'ward' => 'nullable',
            'contact' => 'required',
            'mail' => 'required|email',
            'dob' => ['required', new ValidDate],
            'course_cost' => 'required',
            'tuition_fee' => [new RequireFeeIfCourseIsPaidRule],
            'student_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'course_year.required' => 'Please enter course year.',
            'title.required' => 'Please enter title of course.',
            'full_name.required' => 'Please enter full name.',
            'level_id.required' => 'Please select level.',
            'program_id.required' => 'Please select program.',
            'year_semester_id.required' => 'Please select year/semester.',
            'province.required' => 'Please enter province.',
            'district.required' => 'Please enter district.',
            'mv_address.required' => 'Please enter address.',
            'tole.required' => 'Please enter tole.',
            'ward.required' => 'Please enter ward.',
            'contact.required' => 'Please enter contact.',
            'mail.required' => 'Please enter email.',
            'dob.required' => 'Please select date of birth.',
            'course_cost.required' => 'Please enter cost.',
            'student_id.required' => 'Please enter student id.',
        ];
    }

    public function prepareForValidation()
    {
        $fullName = $this->full_name;

        $explodedName = explode(' ', $fullName);

        if (count($explodedName) > 2) {
            $this->merge([
                'first_name' => $explodedName[0],
                'middle_name' => $explodedName[1],
                'last_name' => $explodedName[2],
            ]);
        } elseif (count($explodedName) > 1) {
            $this->merge([
                'first_name' => $explodedName[0],
                'last_name' => $explodedName[1],
            ]);
        } else {
            $this->merge([
                'first_name' => $explodedName[0],
            ]);
        }
    }
}
