<?php

namespace App\Http\Requests\Verbrauch;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|numeric',
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
            'reason.required' => 'Bitte geben Sie einen Grund an.',
            'street_address.required' => 'Bitte geben Sie Ihre Straße und Hausnummer an.',
            'zip.required' => 'Bitte geben Sie Ihre Postleitzahl an.',
            'zip.digits' => 'Bitte geben Sie eine gültige Postleitzahl an.',
            'city.required' => 'Bitte geben Sie Ihren Wohnort an.',
            'type.required' => 'Bitte geben Sie den Typ des Gebäudes an.',
            'additional_type.required' => 'Bitte geben Sie den Zusatztyp des Gebäudes an.',
            'phone.numeric' => 'Die Telefonnummer darf nur aus Zahlen bestehen.',
        ];
    }
}
