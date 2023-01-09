<?php

namespace App\Http\Requests\Verbrauch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateConsumptionPeriodRequest extends FormRequest
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
            'period' => 'required|array|size:2',
            'period.0' => 'required|date',
            'period.1' => 'required|date',
            'consumption' => 'required|numeric',
            'water' => 'nullable|numeric',
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
            'period.required' => 'Bitte geben Sie einen Zeitraum an.',
            'consumption.required' => 'Der Verbrauch ist ein Pflichtfeld.',
            'consumption.numeric' => 'Der Verbrauch muss eine Zahl sein.',
            'water.numeric' => 'Der Wasserverbrauch muss eine Zahl sein.',
        ];
    }
}
