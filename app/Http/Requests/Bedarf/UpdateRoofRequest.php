<?php

namespace App\Http\Requests\Bedarf;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoofRequest extends FormRequest
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
            'beheizt' => 'required|boolean',
            'dachform' => 'required|string',
            'bauweise' => 'required|string',
            'u_wert' => 'nullable|numeric|between:0.01,10.0',
            'dachneigung' => [
                'nullable',
                'integer',
                Rule::requiredIf(fn() => $this->get('dachform') !== 'Flachdach' && $this->get('beheizt') === true),
            ],
            'kniestock' => 'nullable|integer',
            'zwischendecke' => 'nullable|integer',
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
            'dachneigung.integer' => 'Die Dachneigung muss eine ganze Zahl sein.',
            'dachneigung.required' => 'Die Dachneigung ist erforderlich.',
            'kniestock.integer' => 'Der Kniestock muss eine ganze Zahl sein.',
            'zwischendecke.integer' => 'Die Zwischendecke muss eine ganze Zahl sein.',
            'u_wert.between' => 'Der U-Wert muss zwischen 0.01 und 10.0 liegen.',
            'u_wert.numeric' => 'Der U-Wert muss eine Zahl sein.',
            'dachform.required' => 'Die Dachform ist erforderlich.',
            'dachform.string' => 'Die Dachform muss ein String sein.',
            'bauweise.required' => 'Die Bauweise ist erforderlich.',
            'bauweise.string' => 'Die Bauweise muss ein String sein.',
        ];
    }
}
