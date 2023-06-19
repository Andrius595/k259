<?php

namespace App\Http\Requests\Litter;

use Illuminate\Foundation\Http\FormRequest;

class ListLitterRequest extends FormRequest
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
            'page' => 'required|integer|min:1',
            'perPage' => 'nullable|integer|min:1|max:100',
            'showMine' => 'required|boolean',
            'showCleaned' => 'required|boolean',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'showMine' => filter_var($this->showMine ?? false, FILTER_VALIDATE_BOOLEAN),
            'showCleaned' => filter_var($this->showCleaned ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
