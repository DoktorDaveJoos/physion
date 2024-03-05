<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttachmentRequest extends FormRequest
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
            'type' => 'required|string',
            'document' => 'required|file|mimes:pdf|max:10000',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Bitte wählen Sie einen Dokumenttypen aus.',
            'type.string' => 'Bitte wählen Sie einen Dokumenttypen aus.',
            'document.required' => 'Bitte laden Sie ein Dokument hoch.',
            'document.file' => 'Bitte laden Sie ein Dokument hoch.',
            'document.mimes' => 'Bitte laden Sie ein Dokument hoch.',
            'document.max' => 'Dokument zu groß.',
        ];
    }
}
