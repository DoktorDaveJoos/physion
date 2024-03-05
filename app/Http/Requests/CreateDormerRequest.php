<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDormerRequest extends FormRequest
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
            'count' => 'numeric|required',
            'form' => 'string|required',
            'height' => 'numeric|required|min:0|max:1000',
            'width' => 'numeric|required|min:0|max:1000',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'count.required' => 'Bitte geben Sie eine Anzahl an.',
            'count.numeric' => 'Bitte geben Sie eine gültige Anzahl an.',
            'form.required' => 'Bitte wählen Sie eine Bauweise aus.',
            'form.string' => 'Bitte wählen Sie eine gültige Bauweise aus.',
            'height.required' => 'Bitte geben Sie eine Höhe an.',
            'height.numeric' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.min' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.max' => 'Bitte geben Sie eine gültige Höhe an.',
            'width.required' => 'Bitte geben Sie eine Breite an.',
            'width.numeric' => 'Bitte geben Sie eine gültige Breite an.',
            'width.min' => 'Bitte geben Sie eine gültige Breite an.',
            'width.max' => 'Bitte geben Sie eine gültige Breite an.',
        ];
    }
}
