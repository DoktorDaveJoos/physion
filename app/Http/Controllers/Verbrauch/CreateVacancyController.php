<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateVacancyRequest;
use App\Models\Order;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class CreateVacancyController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  CreateVacancyRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(Order $order, CreateVacancyRequest $request): RedirectResponse
    {

        if ($order->product->sources->count() === 0) {
            return redirect()->route('verbrauch.consumption', $order->id)->withErrors(['vacancy.error' => 'Bitte legen Sie zuerst einen Energieträger inklusive der Abrechnungszeiträume an.']);
        }

        $mainSource = $order->product->sources->firstWhere('main', true);

        // accumulate all days of all periods from start to end
        $days = 0;
        foreach ($mainSource->periods as $period) {
            $days += $period->start->diffInDays($period->end);
        }

        $vacancyDays = 0;
        foreach ($order->product->vacancies as $vacancy) {
            ray($vacancy->start->diffInDays($vacancy->end));
            $vacancyDays += $vacancy->start->diffInDays($vacancy->end);
        }

        $vacancyDays += Carbon::parse($request->get('period')[0])->diffInDays(Carbon::parse($request->get('period')[1]));

        ray($days, $vacancyDays);

        // Check that vacancyDays is not more than 30% of days
        if ($vacancyDays > $days * 0.3) {
            return redirect()->route('verbrauch.consumption', $order->id)->withErrors(['vacancy.error' => 'Der Leerstand darf nicht mehr als 30% der erfassten Abrechnungszeiträume betragen.']);
        }

        Vacancy::create([
            'start' => $request->get('period')[0],
            'end' => $request->get('period')[1],
            'verbrauchsausweis_id' => $order->product_id,
        ]);

        $order->product->update(['vacancy_percentage' => null]);

        return redirect()->route('verbrauch.consumption', $order->id);
    }
}
