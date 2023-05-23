<?php

declare(strict_types=1);

namespace App\Http\Requests\Certificate\Shared;

use Illuminate\Foundation\Http\FormRequest;

class SummaryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order' => 'required|exists:orders,slug',
            'feedback' => 'nullable|string',
            'page' => 'required|string'
        ];
    }


}
