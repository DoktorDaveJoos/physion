<?php

namespace App\Http\Requests\Bedarf;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'side_a' => 'required|numeric|min:0|max:200',
            'side_b' => 'required|numeric|min:0|max:200',
            'orientation' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'side_a.required' => 'Bitte geben Sie die Länge der Seite A an.',
            'side_a.numeric' => 'Bitte geben Sie eine Zahl für die Länge der Seite A an.',
            'side_a.min' => 'Die Länge der Seite A muss mindestens 0 sein.',
            'side_a.max' => 'Die Länge der Seite A darf maximal 200 sein.',
            'side_b.required' => 'Bitte geben Sie die Länge der Seite B an.',
            'side_b.numeric' => 'Bitte geben Sie eine Zahl für die Länge der Seite B an.',
            'side_b.min' => 'Die Länge der Seite B muss mindestens 0 sein.',
            'side_b.max' => 'Die Länge der Seite B darf maximal 200 sein.',
        ];
    }

}
