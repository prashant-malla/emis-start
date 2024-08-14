<?php

namespace App\Http\Requests;

use App\Rules\DateAfterOrEqual;
use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class FiscalYearRequest extends FormRequest
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
            'title' => 'required|max:255',
            'start_date' => ['required', new ValidDate],
            'end_date' => ['required', new ValidDate, new DateAfterOrEqual($this->start_date)],
            'is_active' => 'boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->is_active ? 1 : 0]);
    }
}
