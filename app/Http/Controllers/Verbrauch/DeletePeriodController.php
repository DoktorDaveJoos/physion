<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Models\ConsumptionPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeletePeriodController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param string $orderId
     * @param string $sourceId
     * @param ConsumptionPeriod $period
     * @return RedirectResponse
     */
    public function __invoke(string $orderId, string $sourceId, ConsumptionPeriod $period): RedirectResponse
    {
        $period->delete();
        return redirect()->route('verbrauch.consumption', $orderId);
    }

}
