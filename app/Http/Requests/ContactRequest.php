<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|min:1',
            'email' => 'required|email',
            'phone' => 'nullable|numeric',
            'message' => 'required|min:1',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Bitte gib deinen Namen ein.',
            'email.required' => 'Bitte gib deine Email-Adresse ein.',
            'email.email' => 'Bitte gib eine gültige Email-Adresse ein.',
            'message.required' => 'Bitte gib eine Nachricht ein.',
            'phone.numeric' => 'Bitte gib eine gültige Telefonnummer ein.',
        ];
    }
}
