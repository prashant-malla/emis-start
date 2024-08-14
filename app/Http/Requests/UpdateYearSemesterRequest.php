<?php

namespace App\Http\Requests;

use App\Rules\UniqueYearSemester;
use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateYearSemesterRequest extends FormRequest
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
            'batch_id' => 'required|integer|exists:batches,id',
            'program_id' => 'required|integer|exists:programs,id',
            'name' => ['required', 'string', 'max:255', new UniqueYearSemester($this->batch_id, $this->program_id, $this->yearSemester->id)],
            'term_number' => 'required|integer',
            'is_active' => 'boolean',
            'start_date' => ['nullable', new ValidDate],
            'end_date' => ['nullable', new ValidDate],
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
            'batch_id.required' => 'Please select Batch.',
            'program_id.required' => 'Please select program.',
            'name.required' => 'Year/Semester name is required.',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['is_active' => $this->input('is_active', 0)]);
    }
}
