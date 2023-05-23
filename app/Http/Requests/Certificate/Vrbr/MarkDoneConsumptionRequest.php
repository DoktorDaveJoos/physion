<?php

namespace App\Http\Requests\Certificate\Vrbr;

use Illuminate\Foundation\Http\FormRequest;

class MarkDoneConsumptionRequest extends FormRequest
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
            'vacancy_percentage' => 'nullable|numeric|min:0|max:30',
            'page' => 'required|string'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'percentage.min' => 'Der Wert muss zwischen 0 und max 30 liegen.',
            'percentage.max' => 'Der Wert muss zwischen 0 und max 30 liegen.',
        ];
    }
}
