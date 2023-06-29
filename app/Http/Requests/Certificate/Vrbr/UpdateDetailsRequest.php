<?php

namespace App\Http\Requests\Certificate\Vrbr;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailsRequest extends FormRequest
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
            'construction_year' => 'required|integer|min:1977|max:'.(date('Y')),
            'construction_year_heating' => 'required|integer|min:1977|max:'.(date('Y')),
            'floor_area' => 'required|numeric|min:1|max:100000',
            'housing_units' => 'required|integer|min:1|max:1000',
            'ventilation' => 'required|string',
            'cellar' => 'required|string',
            'renewables' => 'nullable|string',
            'renewables_reason' => 'nullable|string',
            'cooling' => 'nullable|string',
            'cooling_count' => 'nullable|integer|min:0|max:1000',
            'cooling_service' => 'nullable|date',
            'suggestion_check' => 'present',
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
            'construction_year.required' => 'Bitte geben Sie das Baujahr des Gebäudes an.',
            'construction_year.integer' => 'Bitte geben Sie das Baujahr des Gebäudes als Zahl an.',
            'construction_year.min' => 'Das Baujahr muss größer 1977 sein. Sonst brauchen Sie einen Bedarfsausweis.',
            'construction_year.max' => 'Das Baujahr darf nicht in der Zukunft liegen.',
            'construction_year_heating.required' => 'Bitte geben Sie das Baujahr der Heizung an.',
            'construction_year_heating.integer' => 'Bitte geben Sie das Baujahr der Heizung als Zahl an.',
            'construction_year_heating.min' => 'Das Baujahr muss größer 1977 sein.',
            'construction_year_heating.max' => 'Das Baujahr darf nicht in der Zukunft liegen.',
            'floor_area.required' => 'Bitte geben Sie die Wohnfläche des Gebäudes an.',
            'floor_area.numeric' => 'Bitte geben Sie die Wohnfläche des Gebäudes als Zahl an.',
            'floor_area.min' => 'Bitte geben Sie die Wohnfläche des Gebäudes als Zahl an.',
            'floor_area.max' => 'Die Wohnfläche ist zu groß.',
            'housing_units.required' => 'Bitte geben Sie die Anzahl der Wohnungen an.',
            'housing_units.integer' => 'Bitte geben Sie die Anzahl der Wohnungen als Zahl an.',
            'housing_units.min' => 'Bitte geben Sie die Anzahl der Wohnungen als Zahl an.',
            'housing_units.max' => 'Zu viele Wohneinheiten angegeben.',
            'ventilation.required' => 'Bitte geben Sie an, ob das Gebäude über eine Lüftungsanlage verfügt.',
            'cellar.required' => 'Bitte geben Sie an, ob das Gebäude über einen Keller verfügt.',
            'renewables.string' => 'Bitte geben Sie an, ob das Gebäude über erneuerbare Energien verfügt.',
            'renewables_reason.string' => 'Bitte geben Sie an, ob das Gebäude über erneuerbare Energien verfügt.',
            'cooling.string' => 'Bitte geben Sie an, ob das Gebäude über eine Klimaanlage verfügt.',
            'cooling_count.integer' => 'Bitte geben Sie die Anzahl der Klimaanlagen als Zahl an.',
            'cooling_count.min' => 'Bitte geben Sie die Anzahl der Klimaanlagen als Zahl an.',
            'cooling_count.max' => 'Bitte geben Sie die Anzahl der Klimaanlagen als Zahl an.',
            'cooling_service.date' => 'Bitte geben Sie das Datum des nächsten Service Termin an.',
        ];
    }
}