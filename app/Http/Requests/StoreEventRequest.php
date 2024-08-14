<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'organize' => 'required',
            'objective' => 'required',
            'date' => ['required', new ValidDate],
            'venue' => 'required',
            'participants' => 'required',
            'documents' => 'nullable',
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
            'title.required' => 'Title is required.',
            'organize.required'  => 'Please Select Organized By.',
            'objective.required'  => 'Objective is required.',
            'date.required'     => 'Date is required.',
            'venue.required'   => 'Venue is required.',
            'participants.required'   => 'Participants is required.',
        ];
    }
}
