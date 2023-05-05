<?php

namespace App\Http\Requests\Litter;

use Illuminate\Foundation\Http\FormRequest;

class CleanLitterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'cleaned_image' => 'required|image',
        ];
    }
}
