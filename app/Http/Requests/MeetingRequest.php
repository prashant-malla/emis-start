<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
            'level_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required',
            'section_id' => 'required',
            'teacher_id' => 'required',
            'meeting_date' => ['required', new ValidDate],
            'meeting_time' => 'required',
            'link' => 'required',
            'document' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'level_id.required' => 'Level is required.',
            'program_id.required' => 'Program is required.',
            'year_semester_id.required' => 'Year/Semester is required.',
            'section_id.required' => 'Section is required.',
            'teacher_id.required' => 'Teacher is required.',
            'meeting_date.required' => 'Meeting Date is required.',
            'meeting_time.required' => 'Meeting Time is required.',
        ];
    }
}
