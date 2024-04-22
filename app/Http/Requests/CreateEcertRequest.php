<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEcertRequest extends FormRequest
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
            'type' => 'required|string|in:vrbr,bdrf',
            'reason' => 'required|string',
            'suggestion_check' => 'required|array',
            'suggestion_check.*' => 'required|boolean',
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
            'type' => 'Bitte geben Sie an welcher Art der Energieausweis ist.',
            'type.required' => 'Bitte geben Sie an welcher Art der Energieausweis ist.',
            'reason' => 'Bitte geben Sie den Grund an.',
            'reason.required' => 'Bitte geben Sie den Grund an.',
            'suggestion_check' => 'Bitte geben Sie an ob die Vorschläge geprüft wurden.',
            'suggestion_check.required' => 'Bitte geben Sie an ob die Vorschläge geprüft wurden.',
            'suggestion_check.*' => 'Bitte geben Sie an ob die Vorschläge geprüft wurden.',
        ];
    }
}
