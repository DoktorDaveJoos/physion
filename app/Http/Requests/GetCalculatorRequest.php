<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetCalculatorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'strategy' => 'nullable|string',
            'customer_has_building' => 'nullable|boolean',
            'customer_salary' => 'nullable|numeric',
            'customer_kids' => 'nullable|numeric',
            'building_has_qng' => 'nullable|boolean',
            'building_has_lifecycle' => 'nullable|boolean',
            'building_effizienzhaus_level' => 'nullable|string',
            'building_target' => 'nullable|string',
            'building_ecert_rating' => 'nullable|string',
        ];
    }
}
