<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'program_id' => 'sometimes|exists:programs,id',
            'batch_id' => 'sometimes|exists:batches,id',
            'year_semester_id' => 'sometimes|exists:year_semesters,id',
            'section_id' => 'sometimes|exists:sections,id'
        ];
    }
}
