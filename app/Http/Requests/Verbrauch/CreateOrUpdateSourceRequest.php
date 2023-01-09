<?php

namespace App\Http\Requests\Verbrauch;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateSourceRequest extends FormRequest
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
            'source' => 'required|string',
            'water' => 'required|string',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'source.required' => 'Bitte wählen Sie eine Energieträger aus.',
            'water.required' => 'Bitte wählen Sie eine Option aus.',
        ];
    }
}
