<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteVacancyController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param string $orderId
     * @param  Vacancy  $vacancy
     * @return RedirectResponse
     */
    public function __invoke(string $orderId, Vacancy $vacancy): RedirectResponse
    {
        $vacancy->delete();
        return redirect()->route('verbrauch.consumption', $orderId);
    }
}
