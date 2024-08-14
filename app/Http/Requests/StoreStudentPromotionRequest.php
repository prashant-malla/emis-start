<?php

namespace App\Http\Requests;

use App\Enum\StudentStatusEnum;
use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentPromotionRequest extends FormRequest
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
            'student_id' => 'required|array',
            'student_id.*' => 'required|exists:students,id',
            'action' => 'required|in:promote,update_status',
            'date' => ['required', new ValidDate],
        ];

        if ($this->action === 'promote') {
            $addRules = [
                'to_academic_year_id' => 'required|exists:academic_years,id',
                'to_batch_id' => 'required|exists:batches,id',
                'to_program_id' => 'required|exists:programs,id',
                'to_section_id' => 'required|array',
                'to_year_semester_id' => 'required|exists:year_semesters,id|different:from_year_semester_id',
                'from_year_semester_id' => 'required|exists:year_semesters,id',
                'to_section_id' => 'required|array',
                'to_roll' => 'sometimes|array',
            ];
        } else {
            $addRules = [
                'status' => ['required', Rule::in(StudentStatusEnum::toArray())],
                'remarks' => 'required|array',
            ];
        }

        $rules = array_merge($rules, $addRules);

        return $rules;
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Please select students.',
            'to_section_id.required' => 'Please select sections.',
        ];
    }
}
