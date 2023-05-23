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
            'heated' => 'required|boolean',
            'roof_shape' => 'required|string',
            'construction' => 'required|string',
            'u_value' => 'nullable|numeric|between:0.01,10.0',
            'pitch' => [
                'nullable',
                'integer',
                Rule::requiredIf(fn() => $this->get('roof_shape') !== 'Flachdach' && $this->get('heated') === true),
            ],
            'knee_wall' => 'nullable|integer',
            'ceiling' => 'nullable|integer',
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
            'pitch.integer' => 'Die Dachneigung muss eine ganze Zahl sein.',
            'pitch.required' => 'Die Dachneigung ist erforderlich.',
            'knee_wall.integer' => 'Der Kniestock muss eine ganze Zahl sein.',
            'ceiling.integer' => 'Die Zwischendecke muss eine ganze Zahl sein.',
            'u_value.between' => 'Der U-Wert muss zwischen 0.01 und 10.0 liegen.',
            'u_value.numeric' => 'Der U-Wert muss eine Zahl sein.',
            'roof_shape.required' => 'Die Dachform ist erforderlich.',
            'roof_shape.string' => 'Die Dachform muss ein String sein.',
            'construction.required' => 'Die Bauweise ist erforderlich.',
            'construction.string' => 'Die Bauweise muss ein String sein.',
        ];
    }
}
