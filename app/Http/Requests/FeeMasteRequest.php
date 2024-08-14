<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeeMasteRequest extends FormRequest
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
        $feeMaster = $this->route('feeMaster');

        return [
            'year_semester_id' => 'required',
            // 'fee_title_id' => 'required',
            'fee_type_id' => [
                'required', 
                Rule::unique('fee_masters', 'fee_type_id')->where('year_semester_id', $this->year_semester_id)->ignore($feeMaster?->id)
            ],
            'due_date' => ['required', new ValidDate],
            'amount' => 'required',
            'fine_type' => 'required',
            'percentage' => 'nullable|numeric',
            'fine_amount' => 'nullable|numeric',
        ];
    }
    
    public function messages()
    {
        return [
            'year_semester_id' => 'Year/Semester is required.',
            // 'fee_title_id.required' => 'Fee Title is required.',
            'fee_type_id.required' => 'Fee Type is required.',
            'fee_type_id.unique' => 'Selected Fee has already been assigned to given Year/Semester',
            'due_date.required' => 'Due Date is required.',
            'fine_type.required' => 'Fine Type is required.',
            'fine_amount.required' => 'Fine Amount is required.',
        ];
    }
}
