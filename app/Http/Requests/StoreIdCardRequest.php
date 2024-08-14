<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdCardRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:30',
            'signature_title' => 'nullable|string|max:50',
            'valid_upto' => 'nullable|string|max:30',
            'background_image' => 'nullable|image|max:5120',
            'logo' => 'nullable|image|max:5120',
            'signature' => 'nullable|image|max:5120',
            'seal_image' => 'nullable|image|max:5120',
            'theme' => 'required|string|max:255',
            'logo_height' => 'nullable|integer|min:40|max:60',
            'header_height' => 'nullable|integer|min:24|max:40',
            'image_width' => 'nullable|integer|min:60|max:90',
            'image_height' => 'nullable|integer|min:60|max:90',
            'field_item_height' => 'nullable|integer|min:10|max:15',
        ];
    }
}
