<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRenewableRequest extends FormRequest
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
            'area' => 'required|numeric',
            'construction_year' => 'required|numeric',
            'electricity' => 'required|boolean',
            'heating' => 'required|boolean',
            'water' => 'required|boolean',
            'comment' => 'nullable|string',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Bitte geben Sie den Typ der Anlage an.',
            'area.required' => 'Bitte geben Sie die Fläche der Anlage an.',
            'construction_year.required' => 'Bitte geben Sie das Baujahr der Anlage an.',
            'electricity.required' => 'Bitte geben Sie an, ob die Anlage Strom erzeugt.',
            'heating.required' => 'Bitte geben Sie an, ob die Anlage Wärme erzeugt.',
            'water.required' => 'Bitte geben Sie an, ob die Anlage Warmwasser erzeugt.',
        ];
    }
}
