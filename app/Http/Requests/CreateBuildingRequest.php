<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBuildingRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'place_id' => 'nullable|string',
            'street' => 'required|string',
            'house_number' => 'required|numeric',
            'postal_code' => 'required|digits:5',
            'city' => 'required|string',
            'type' => 'required|string',
            'additional_type' => 'required|string',
            'construction_year' => 'required|integer|min:1300|max:'.(date('Y')),
            'construction_year_heating' => 'required|integer|min:1300|max:'.(date('Y')),
            'floor_area' => 'required|numeric|min:1|max:10000',
            'floors' => 'required|numeric|min:1|max:100',
            'housing_units' => 'required|integer|min:1|max:100',
            'ventilation' => 'required|string',
            'cellar' => 'required|string',
            'cooling' => 'nullable|string',
            'cooling_count' => 'nullable|integer|min:0|max:10',
            'cooling_service' => 'nullable|date',
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
            'street.required' => 'Bitte geben Sie die Straße an.',
            'street.string' => 'Bitte geben Sie die Straße als Text an.',
            'house_number.required' => 'Bitte geben Sie die Hausnummer an.',
            'house_number.numeric' => 'Bitte geben Sie die Hausnummer als Zahl an.',
            'postal_code.required' => 'Bitte geben Sie die Postleitzahl an.',
            'postal_code.digits' => 'Bitte geben Sie die Postleitzahl als fünfstellige Zahl an.',
            'city.required' => 'Bitte geben Sie den Ort an.',
            'city.string' => 'Bitte geben Sie den Ort als Text an.',
            'type.required' => 'Bitte wählen Sie einen Gebäudetypen aus.',
            'type.string' => 'Bitte wählen Sie einen Gebäudetypen aus.',
            'additional_type.required' => 'Bitte wählen Sie einen Gebäudeuntertypen aus.',
            'additional_type.string' => 'Bitte wählen Sie einen Gebäudeuntertypen aus.',
            'construction_year.required' => 'Bitte geben Sie das Baujahr des Gebäudes an.',
            'construction_year.integer' => 'Bitte geben Sie das Baujahr des Gebäudes als Zahl an.',
            'construction_year.min' => 'Das Baujahr muss größer 1300 sein.',
            'construction_year.max' => 'Das Baujahr darf nicht in der Zukunft liegen.',
            'construction_year_heating.required' => 'Bitte geben Sie das Baujahr der Heizung an.',
            'construction_year_heating.integer' => 'Bitte geben Sie das Baujahr der Heizung als Zahl an.',
            'construction_year_heating.min' => 'Das Baujahr der Heizung muss größer 1300 sein.',
            'construction_year_heating.max' => 'Das Baujahr der Heizung darf nicht in der Zukunft liegen.',
            'floor_area.required' => 'Bitte geben Sie die Wohnfläche des Gebäudes an.',
            'floor_area.numeric' => 'Bitte geben Sie die Wohnfläche des Gebäudes als Zahl an.',
            'floor_area.min' => 'Bitte geben Sie die Wohnfläche des Gebäudes als Zahl an.',
            'floor_area.max' => 'Die Wohnfläche ist zu groß.',
            'floors.required' => 'Bitte geben Sie die Anzahl der Stockwerke an.',
            'floors.numeric' => 'Bitte geben Sie die Anzahl der Stockwerke als Zahl an.',
            'floors.min' => 'Bitte geben Sie die Anzahl der Stockwerke als Zahl an.',
            'floors.max' => 'Zu viele Stockwerke angegeben.',
            'housing_units.required' => 'Bitte geben Sie die Anzahl der Wohnungen an.',
            'housing_units.integer' => 'Bitte geben Sie die Anzahl der Wohnungen als Zahl an.',
            'housing_units.min' => 'Bitte geben Sie die Anzahl der Wohnungen als Zahl an.',
            'housing_units.max' => 'Zu viele Wohnungen angegeben.',
            'ventilation.required' => 'Bitte wählen Sie eine Lüftungsart aus.',
            'cellar.required' => 'Bitte wählen Sie aus, ob das Gebäude einen Keller hat.',
            'cooling.string' => 'Bitte wählen Sie aus, ob das Gebäude eine Klimaanlage hat.',
            'cooling_count.integer' => 'Bitte geben Sie die Anzahl der Klimaanlagen als Zahl an.',
            'cooling_count.min' => 'Bitte geben Sie die Anzahl der Klimaanlagen als Zahl an.',
            'cooling_count.max' => 'Bitte geben Sie die Anzahl der Klimaanlagen als Zahl an.',
            'cooling_service.date' => 'Bitte geben Sie das Datum der nächsten Wartung der Klimaanlage an.',
        ];
    }
}
