<?php

namespace App\Http\Requests\Find;

use Illuminate\Foundation\Http\FormRequest;

class FindRequest extends FormRequest
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
            'order' => 'nullable|exists:orders,slug',
            'email' => 'nullable|email|exists:customers,email',
            'zip' => 'nullable|numeric|digits:5',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'order_id.exists' => 'Diese Bestellnummer existiert nicht.',
            'email.exists' => 'Diese Email-Adresse ist bei uns nicht registriert.',
            'email.email' => 'Bitte gib eine gültige Email-Adresse ein.',
            'zip.digits' => 'Die Postleitzahl muss 5 Stellen lang sein.',
            'zip.numeric' => 'Die Postleitzahl darf nur aus Zahlen bestehen.',
        ];
    }
}
