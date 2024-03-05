<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateHeatingRequest extends FormRequest
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
            'type' => 'required|string',
            'system' => 'required|string',
            'construction_year' => 'required|numeric',
            'water_included' => 'required|boolean',
            'is_main' => 'required|boolean',
            'comment' => 'nullable|string',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Bitte geben Sie den Typ der Heizung an.',
            'system.required' => 'Bitte geben Sie das System der Heizung an.',
            'construction_year.required' => 'Bitte geben Sie das Baujahr der Heizung an.',
            'water_included.required' => 'Bitte geben Sie an, ob die Warmwasserversorgung in der Heizung enthalten ist.',
            'is_main.required' => 'Bitte geben Sie an, ob die Heizung die Hauptheizung ist.',
        ];
    }
}
