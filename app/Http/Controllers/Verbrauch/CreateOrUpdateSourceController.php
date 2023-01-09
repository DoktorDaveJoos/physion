<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verbrauch\CreateOrUpdateSourceRequest;
use App\Models\EnergySource;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateOrUpdateSourceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  CreateOrUpdateSourceRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(Order $order, CreateOrUpdateSourceRequest $request): RedirectResponse
    {
        $waterEnabled = $request->get('water') === 'Im Verbrauch enthalten - Genaue Werte bekannt'
            || $request->get('water') === 'Nicht im Verbrauch enthalten - Werte bekannt';

        $isMain = $order->product->sources()->count() === 0;

        EnergySource::create([
            'source' => $request->get('source'),
            'water' => $request->get('water'),
            'water_enabled' => $waterEnabled,
            'verbrauchsausweis_id' => $order->product->id,
            'main' => $isMain,
        ]);

        return redirect()->route('verbrauch.consumption', $order);
    }
}
