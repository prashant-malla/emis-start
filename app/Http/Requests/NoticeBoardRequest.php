<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class NoticeBoardRequest extends FormRequest
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
            'title' => 'required',
            'notice_date' => ['required', new ValidDate],
            'notice_to' => 'required',
            'message' => 'required',
            'role_id' => 'nullable',
            'level_id' => 'nullable',
            'program_id' => 'nullable',
            'section_id' => 'nullable',
        ];
    }
}
