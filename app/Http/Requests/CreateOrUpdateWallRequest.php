<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateWallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'u_value' => 'numeric|nullable',
            'construction' => 'string|required',
            'variant' => 'string|required',
            'thickness' => 'numeric|nullable',
            'height' => 'numeric|required',
        ];
    }

    public function messages(): array
    {
        return [
            'u_wert.numeric' => 'Bitte geben Sie einen gültigen U-Wert an.',
            'construction.required' => 'Bitte wählen Sie eine Konstruktion aus.',
            'variant.required' => 'Bitte wählen Sie eine Variante aus.',
            'thickness.numeric' => 'Bitte geben Sie eine gültige Stärke an.',
            'height.numeric' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.required' => 'Bitte geben Sie eine Geschosshöhe an.',
        ];
    }
}
