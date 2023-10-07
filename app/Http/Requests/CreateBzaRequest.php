<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBzaRequest extends FormRequest
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
            'type' => 'required|string',
            'title' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street' => 'required|string',
            'house_number' => 'required|string',
            'postal_code' => 'required|numeric|digits:5',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'vollmacht' => 'required|file|mimes:pdf|max:20000',
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
            'type' => 'Bitte geben Sie an welcher Art der Rechnungsempfänger ist.',
            'type.required' => 'Bitte geben Sie an welcher Art der Rechnungsempfänger ist.',
            'title' => 'Bitte geben Sie den Titel an.',
            'title.required' => 'Bitte geben Sie den Titel an.',
            'first_name' => 'Bitte geben Sie den Vornamen an.',
            'first_name.required' => 'Bitte geben Sie den Vornamen an.',
            'last_name' => 'Bitte geben Sie den Nachnamen an.',
            'last_name.required' => 'Bitte geben Sie den Nachnamen an.',
            'street' => 'Bitte geben Sie die Straße an.',
            'street.required' => 'Bitte geben Sie die Straße an.',
            'house_number' => 'Bitte geben Sie die Hausnummer an.',
            'house_number.required' => 'Bitte geben Sie die Hausnummer an.',
            'house_number.numeric' => 'Bitte geben Sie die Hausnummer als Zahl an.',
            'postal_code' => 'Bitte geben Sie die Postleitzahl an.',
            'postal_code.required' => 'Bitte geben Sie die Postleitzahl an.',
            'postal_code.numeric' => 'Bitte geben Sie die Postleitzahl als Zahl an.',
            'postal_code.digits' => 'Bitte geben Sie die Postleitzahl als fünfstellige Zahl an.',
            'city' => 'Bitte geben Sie den Ort an.',
            'city.required' => 'Bitte geben Sie den Ort an.',
            'country' => 'Bitte geben Sie das Land an.',
            'country.required' => 'Bitte geben Sie das Land an.',
            'phone' => 'Bitte geben Sie die Telefonnummer an.',
            'phone.required' => 'Bitte geben Sie die Telefonnummer an.',
            'email' => 'Bitte geben Sie die E-Mail-Adresse an.',
            'email.required' => 'Bitte geben Sie die E-Mail-Adresse an.',
            'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
            'vollmacht' => 'Bitte laden Sie die Vollmacht hoch.',
            'vollmacht.file' => 'Bitte laden Sie die Vollmacht hoch.',
            'vollmacht.mimes' => 'Bitte laden Sie die Vollmacht als PDF hoch.',
            'vollmacht.max' => 'Das Dokument ist zu groß.',
        ];
    }
}
