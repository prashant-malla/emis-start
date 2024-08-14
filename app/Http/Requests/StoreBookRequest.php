<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        $rules = [
            'title' => 'required',
            'book_number' => 'required',
            'isbn_number' => 'required',
            'publisher' => 'required',
            'author' => 'required',
            'subject' => 'required',
            'rack_number' => 'required',
            'quantity' => 'required',
            'book_price' => 'required',
            'post_date' => ['sometimes', new ValidDate],
            'description' => 'nullable',
            'document' => 'nullable|mimes:pdf|max:51200',
            'cover_image' => 'nullable|image|mimes:jpeg,png,gif|max:1024',
            'book_type' => 'required',
            'book_edition' => 'required',
            'delete_document' => 'nullable',
            'delete_cover_image' => 'nullable',

        ];
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['document'] = 'nullable';
        }
        return $rules;
    }
}
