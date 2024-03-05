<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConsumptionRequest extends FormRequest
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
            'energy_source' => 'required|string',
            'water_included' => 'required|boolean',
            'start' => 'required|date',
            'end' => 'required|date',
            'consumption' => 'required|numeric',
            'comment' => 'nullable|string',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'energy_source.required' => 'Bitte wählen Sie eine Energiequelle aus.',
            'water_included.required' => 'Bitte wählen Sie aus, ob Wasser in den Nebenkosten enthalten ist.',
            'start.required' => 'Bitte wählen Sie ein Startdatum aus.',
            'end.required' => 'Bitte wählen Sie ein Enddatum aus.',
            'consumption.required' => 'Bitte geben Sie den Verbrauch ein.',
        ];
    }
}
