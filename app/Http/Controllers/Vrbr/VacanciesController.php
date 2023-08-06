<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vrbr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateVacancyRequest;
use App\Models\Vacancy;
use App\Models\Vrbr;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{

    use HandleFreeAndPaid;

    public function store(CreateVacancyRequest $request, Vrbr $vrbr): RedirectResponse
    {
        Vacancy::create([
            'start' => $request->get('period')[0],
            'end' => $request->get('period')[1],
            'vrbr_id' => $vrbr->id,
        ]);

        $vrbr->update(['vacancy_percentage' => null]);

        return self::handleRedirect($request, $vrbr, 'consumption');
    }

    public function destroy(Request $request, Vrbr $vrbr, Vacancy $vacancy): RedirectResponse
    {
        $vacancy->delete();

        return self::handleRedirect($request, $vrbr, 'consumption');
    }


}
