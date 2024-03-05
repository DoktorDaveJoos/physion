<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdatePositionRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'layout' => 'required|string',
            'side_a' => 'required|numeric|min:0|max:100',
            'side_b' => 'required|numeric|min:0|max:100',
            'side_c' => 'nullable|numeric|min:0|max:100',
            'side_d' => 'nullable|numeric|min:0|max:100',
            'side_e' => 'nullable|numeric|min:0|max:100',
            'maps' => 'required|string',
            'orientation' => 'required_unless:maps,agreed',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'side_a.required' => 'Bitte geben Sie die Länge der Seite A an.',
            'side_a.numeric' => 'Bitte geben Sie die Länge der Seite A als Zahl an.',
            'side_a.min' => 'Bitte geben Sie die Länge der Seite A als Zahl an.',
            'side_a.max' => 'Die Länge der Seite A ist zu groß.',
            'side_b.required' => 'Bitte geben Sie die Länge der Seite B an.',
            'side_b.numeric' => 'Bitte geben Sie die Länge der Seite B als Zahl an.',
            'side_b.min' => 'Bitte geben Sie die Länge der Seite B als Zahl an.',
            'side_b.max' => 'Die Länge der Seite B ist zu groß.',
            'side_c.numeric' => 'Bitte geben Sie die Länge der Seite C als Zahl an.',
            'side_c.min' => 'Bitte geben Sie die Länge der Seite C als Zahl an.',
            'side_c.max' => 'Die Länge der Seite C ist zu groß.',
            'side_d.numeric' => 'Bitte geben Sie die Länge der Seite D als Zahl an.',
            'side_d.min' => 'Bitte geben Sie die Länge der Seite D als Zahl an.',
            'side_d.max' => 'Die Länge der Seite D ist zu groß.',
            'orientation.required' => 'Bitte geben Sie die Ausrichtung des Gebäudes an.',
            'maps.required' => 'Bitte geben Sie die Lage des Gebäudes an.',
        ];
    }
}
