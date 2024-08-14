<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
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
            'name' => 'required',
            'background_image' => 'nullable|image|max:5120',
            'header_height' => 'nullable|integer|min:70|max:200',
            'title_height' => 'nullable|integer|min:60|max:100',
            'content_height' => 'nullable|integer|min:200|max:350',
            'footer_height' => 'nullable|integer|min:42|max:100',
        ];
    }
}
