<?php

namespace App\Http\Requests;

use App\Rules\UniqueYearSemester;
use Illuminate\Foundation\Http\FormRequest;

class StoreYearSemesterRequest extends FormRequest
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
            'program_id' => 'required|integer|exists:programs,id',
            'batch_id' => 'required|integer|exists:batches,id',
            'rowIndex' => 'required|array',
            'id' => 'nullable|array',
            'name' => 'required|array',
            'term_number' => 'required|array',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
            'is_active' => 'required|array',
            'master_section_id' => 'required|array',
            'is_deleted' => 'required|array',
            'academic_year_id' => 'required|array',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'program_id.required' => 'Please select program.',
            'batch_id.required' => 'Please select Batch.',
            'name.required' => 'Year/Semester name is required.',
        ];
    }
}
