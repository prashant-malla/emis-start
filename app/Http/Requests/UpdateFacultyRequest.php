<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
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
            'name' => 'required|unique:faculties,name,' . $this->faculty->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Faculty name is required.',
            'name.unique' => 'Faculty with same name already exists.',
        ];
    }
}
