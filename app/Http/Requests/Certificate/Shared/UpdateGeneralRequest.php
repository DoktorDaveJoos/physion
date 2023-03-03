<?php

namespace App\Http\Requests\Certificate\Shared;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralRequest extends FormRequest
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
     * @return array<string, array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|phone:DE',
            'reason' => 'required|string',
            'street_address' => 'required|string',
            'zip' => 'required|digits:5',
            'city' => 'required|string',
            'type' => 'required|string',
            'additional_type' => 'required|string',
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
            'name.required' => 'Bitte geben Sie Ihren Namen an.',
            'email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse an.',
            'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
            'phone.phone' => 'Bitte geben Sie eine gültige Telefonnummer an.',
            'reason.required' => 'Bitte geben Sie einen Grund an.',
            'street_address.required' => 'Bitte geben Sie die Straße und Hausnummer des Gebäudes an.',
            'zip.required' => 'Bitte geben Sie die Postleitzahl des Gebäudes an.',
            'zip.digits' => 'Bitte geben Sie eine gültige Postleitzahl an.',
            'city.required' => 'Bitte geben Sie den Ort des Gebäudes an.',
            'type.required' => 'Bitte geben Sie den Typ des Gebäudes an.',
            'additional_type.required' => 'Bitte geben Sie den Zusatztyp des Gebäudes an.',
        ];
    }
}
