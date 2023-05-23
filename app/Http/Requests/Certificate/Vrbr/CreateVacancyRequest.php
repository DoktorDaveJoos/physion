<?php

namespace App\Http\Requests\Certificate\Vrbr;

use App\Models\Vrbr;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateVacancyRequest extends FormRequest
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
            'vrbr' => 'required|integer|exists:vrbrs,id',
            'period' => 'required|array|size:2',
            'period.0' => 'required|date',
            'period.1' => 'required|date',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $vrbr = Vrbr::find($this->get('vrbr'));

            $mainSource = $vrbr->sources()->firstWhere('main', true);

            if (!$mainSource) {
                $validator->errors()->add(
                    'vacancy.error',
                    'Es muss zuerst ein Energieträger angelegt werden.'
                );
                return;
            }

            // accumulate all days of all periods from start to end
            $days = 0;
            foreach ($mainSource->periods as $period) {
                $days += $period->start->diffInDays($period->end);
            }

            $vacancyDays = 0;
            foreach ($vrbr->vacancies as $vacancy) {
                $vacancyDays += $vacancy->start->diffInDays($vacancy->end);
            }

            $vacancyDays += Carbon::parse($this->input('period.0'))
                ->diffInDays(Carbon::parse($this->input('period.1')));

            // Check that vacancyDays is not more than 30% of days
            if ($vacancyDays > $days * 0.3) {
                $validator->errors()->add(
                    'vacancy.error',
                    'Der Leerstand darf nicht mehr als 30% der erfassten Abrechnungszeiträume betragen.'
                );
            }
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'period.required' => 'Bitte geben Sie einen Zeitraum an.',
        ];
    }
}
