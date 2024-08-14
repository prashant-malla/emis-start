<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonPlanRequest extends FormRequest
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
            'unit' => 'required',
            'topic' => 'required',
            'department' => 'required',
            'level_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required',
            'subject_id' => 'required',
            'completion_days' => 'required',
            'learning_objective' => 'required',
            'learning_tool' => 'required',
            'learning_outcome' => 'required',
            'methods' => 'required_without:other_method',
            'other_method' => 'required_without:methods',
        ];
    }
    public function messages()
    {
        return [
            'unit.required' => 'Unit is required',
            'topic.required' => 'Topic is required',
            'level_id.required' => 'Level is required',
            'program_id.required' => 'Programme is required',
            'year_semester_id.required' => 'Year/Semester is required',
            'subject_id.required' => 'Subject is required',
            'completion_days.required' => 'Completion Days is required',
            'learning_objective.required' => 'Learning Objective is required',
            'learning_tool.required' => 'Learning Tool is required',
            'learning_outcome.required' => 'Learning Outcome is required',
        ];
    }
}
