<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class ListEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'page' => 'required|integer|min:1',
            'perPage' => 'nullable|integer|min:1|max:100',
            'showJoined' => 'required|boolean',
            'showUpcoming' => 'required|boolean',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'showJoined' => filter_var($this->showJoined ?? false, FILTER_VALIDATE_BOOLEAN),
            'showUpcoming' => filter_var($this->showUpcoming ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
