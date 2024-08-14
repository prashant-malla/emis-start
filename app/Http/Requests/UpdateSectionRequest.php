<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
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
        return  [
            'academic_year_id' => 'required|integer|exists:academic_years,id',
            'batch_id' => 'nullable|integer|exists:batches,id',
            'level_id' => 'required|integer|exists:levels,id',
            'program_id' => 'required|integer|exists:programs,id',
            'year_semester_id'  => 'required|integer|exists:year_semesters,id',
            'group_name' => 'required|string|max:255|unique:sections,group_name,' . $this->section->id . ',id,year_semester_id,' . $this->year_semester_id,
        ];
    }
}
