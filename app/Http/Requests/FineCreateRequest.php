<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class FineCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'date' => ['required', new ValidDate]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => $this->date ?? getTodaySystemDate(),
        ]);
    }
}
