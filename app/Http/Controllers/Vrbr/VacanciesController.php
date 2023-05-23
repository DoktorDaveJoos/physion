<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vrbr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateOrUpdateSourceRequest;
use App\Http\Requests\Certificate\Vrbr\CreateVacancyRequest;
use App\Models\EnergySource;
use App\Models\Vacancy;
use App\Models\Vrbr;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{


    public function store(CreateVacancyRequest $request, Vrbr $vrbr): RedirectResponse
    {
        Vacancy::create([
            'start' => $request->get('period')[0],
            'end' => $request->get('period')[1],
            'vrbr_id' => $vrbr->id,
        ]);

        $vrbr->update(['vacancy_percentage' => null]);

        return to_route('certificate.show', [
            'order' => $vrbr->order,
            'page' => 'consumption',
            'signature' => $request->get('signature')
        ]);

    }

    public function destroy(Request $request, Vrbr $vrbr, Vacancy $vacancy): RedirectResponse
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        $vacancy->delete();

        return to_route('certificate.show', [
            'order' => $vrbr->order,
            'page' => 'consumption',
            'signature' => $request->get('signature')
        ]);
    }


}
