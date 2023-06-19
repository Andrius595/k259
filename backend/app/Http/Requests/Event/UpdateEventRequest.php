<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'starting_at' => 'required|string',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'image' => 'nullable|image',
            

            //$table->string('title');
            //$table->text('description')->nullable();
           // $table->dateTime('starting_at');
           // $table->decimal('latitude', 10, 8);
           // $table->decimal('longitude', 11, 8);
           // $table->string('image_path')->nullable();
        ];
    }
}
