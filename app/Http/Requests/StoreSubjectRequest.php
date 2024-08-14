<?php

namespace App\Http\Requests;

use App\Models\Program;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'program_id' => 'required',
            'year_semester_number' => 'required|integer',
            // 'section_id' => 'required',
            'code' => 'required|unique:subjects,code,NULL,id,program_id,' . request()->input('program_id'),
            'name' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'credit_hour' => 'required',
            'theory_full_marks' => 'required_unless:type,is_practical',
            'theory_pass_marks' => 'required_unless:type,is_practical',
            'practical_full_marks' => 'required_unless:type,is_theory',
            'practical_pass_marks' => 'required_unless:type,is_theory',
            'is_optional' => 'boolean',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['is_optional' => $this->input('is_optional', 0)]);
    }

    protected function getCourseType()
    {
        return $this->program_id ? Program::find($this->program_id)?->type : null;
    }

    public function messages()
    {
        return [
            'program_id.required' => 'Please select program.',
            'year_semester_number.required' => 'Please select year/semester.',
            // 'section_id.required' => 'Please select group.',
            'code.required' => 'Subject code is required.',
            'code.unique' => 'Subject code should be unique.',
            'name.required' => 'Subject name is required.',
            'type.required' => 'Please select type.',
            'credit_hour.required' => getCreditHourLabel($this->getCourseType()) . ' is required.',
            'theory_full_marks.required_unless' => 'Theory Full Marks is required.',
            'theory_pass_marks.required_unless' => 'Theory Pass Marks is required.',
            'practical_full_marks.required_unless' => 'Practical Full Marks is required.',
            'practical_pass_marks.required_unless' => 'Practical Pass Marks is required.',
        ];
    }
}
