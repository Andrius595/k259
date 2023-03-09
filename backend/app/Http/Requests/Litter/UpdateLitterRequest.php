<?php

namespace App\Http\Requests\Litter;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLitterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'size' => 'required|integer',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            'is_accessible_by_car' => 'required|boolean',
            'is_located_in_hole' => 'required|boolean',
            'is_under_water' => 'required|boolean',
            'is_on_the_waterside' => 'required|boolean',
            'is_hard_to_reach' => 'required|boolean',
            'is_cleaned' => 'required|boolean',
            'trash_types' => 'required|array|min:1',
        ];
    }
}
