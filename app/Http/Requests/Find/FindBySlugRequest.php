<?php

namespace App\Http\Requests\Find;

use Illuminate\Foundation\Http\FormRequest;

class FindBySlugRequest extends FormRequest
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
            'slug' => 'required|exists:orders,slug',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'slug.required' => 'Bitte gib eine Bestellnummer ein.',
            'slug.exists' => 'Diese Bestellnummer existiert nicht.',
        ];
    }
}
