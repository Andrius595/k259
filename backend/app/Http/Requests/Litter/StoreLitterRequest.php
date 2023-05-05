<?php

namespace App\Http\Requests\Litter;

use Illuminate\Foundation\Http\FormRequest;

class StoreLitterRequest extends FormRequest
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
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'size' => 'required|integer',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'image' => 'required|image',
            'description' => 'nullable|string',
            'is_accessible_by_car' => 'required|boolean',
            'is_located_in_hole' => 'required|boolean',
            'is_under_water' => 'required|boolean',
            'is_on_the_waterside' => 'required|boolean',
            'is_hard_to_reach' => 'required|boolean',
            'trash_types' => 'required|array|min:1',
            'trash_types.*' => 'required|integer|exists:trash_types,id',
        ];
    }
}
