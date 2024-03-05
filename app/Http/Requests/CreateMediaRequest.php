<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
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
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'images' => 'required|array',
            // max 10MB
            'images.*' => 'required|image|max:10000',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Bitte wählen Sie mindestens ein Bild aus.',
            'images.*.required' => 'Bitte wählen Sie mindestens ein Bild aus.',
            'images.*.image' => 'Bitte wählen Sie ein Bild aus.',
            'images.*.max' => 'Das Bild darf nicht größer als 10MB sein.',
        ];
    }
}
