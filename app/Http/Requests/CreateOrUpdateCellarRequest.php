<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateCellarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'u_value' => 'numeric|nullable',
            'type' => 'string|required',
            'ceiling' => 'numeric|nullable',
            'height' => \Illuminate\Validation\Rule::requiredIf(function () {
                return $this->type !== 'Kein Keller';
            }),
        ];
    }

    public function messages(): array
    {
        return [
            'u_wert.numeric' => 'Bitte geben Sie einen gültigen U-Wert an.',
            'heated.required' => 'Bitte geben Sie an, ob der Keller beheizt ist.',
            'ceiling.numeric' => 'Bitte geben Sie eine gültige Deckenhöhe an.',
            'height.numeric' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.required' => 'Bitte geben Sie eine Geschosshöhe an.',
        ];
    }
}
