<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Models\ConsumptionPeriod;
use App\Models\EnergySource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteSourceController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param string $orderId
     * @param EnergySource $source
     * @return RedirectResponse
     */
    public function __invoke(string $orderId, EnergySource $source): RedirectResponse
    {
        $source->delete();
        return redirect()->route('verbrauch.consumption', $orderId);
    }
}
