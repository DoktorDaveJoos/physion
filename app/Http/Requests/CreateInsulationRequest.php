<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInsulationRequest extends FormRequest
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
            'type' => 'string|required',
            'thickness' => 'numeric|required',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Bitte wählen Sie eine Dämmung aus.',
            'type.string' => 'Bitte wählen Sie eine Dämmung aus.',
            'thickness.required' => 'Bitte geben Sie eine Stärke an.',
            'thickness.numeric' => 'Bitte geben Sie eine gültige Stärke an.',
        ];
    }
}
