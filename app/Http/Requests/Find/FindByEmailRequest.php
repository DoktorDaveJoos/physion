<?php

namespace App\Http\Requests\Find;

use Illuminate\Foundation\Http\FormRequest;

class FindByEmailRequest extends FormRequest
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
            'email' => 'required|email|exists:customers,email',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'email.exists' => 'Diese Email-Adresse ist bei uns nicht registriert.',
            'email.email' => 'Bitte gib eine gültige Email-Adresse ein.',
        ];
    }
}
