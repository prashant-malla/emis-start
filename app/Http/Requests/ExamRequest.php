<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'batch_id' => 'nullable|exists:batches,id',
            'level_id' => 'required|exists:levels,id',
            'program_id' => 'required|exists:programs,id',
            'year_semester_id' => 'required|exists:year_semesters,id',
            'result_date' => ['nullable', new ValidDate],
        ];
    }

    public function messages()
    {
        return [
            'academic_year_id.required' => 'Please choose Academic Year',
            'program_id.required' => 'Please choose Program',
            'year_semester_id.required' => 'Please choose Year/Semester',
        ];
    }
}
