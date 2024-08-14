<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkAssignDiscountRequest extends FormRequest
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
            'fee_discount_id' => 'required',
            'program_id' => 'required',
            'year_semester_id' => 'required',
            'section_id' => 'required',
            'students' => 'required|array',
            //            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'students.required' => 'Please select students'
        ];
    }
}
