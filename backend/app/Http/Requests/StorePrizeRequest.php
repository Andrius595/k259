<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrizeRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1',
            'prize_codes' => 'required|array|min:1',
            'prize_codes.*.code' => 'required|string',
            'prize_codes.*.is_redeemed' => 'nullable|boolean',
        ];
    }
}
