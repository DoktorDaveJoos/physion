<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\UpdateDetailsRequest;
use App\Models\Bdrf;
use App\Models\Order;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    use HandleFreeAndPaid;

    /**
     * Handle the incoming request.
     *
     * @param  Bdrf  $bdrf
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function maps(Bdrf $bdrf, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'maps' => 'required|string',
        ]);

        $bdrf->maps = $validated['maps'];

        if ($validated['maps'] === true && $bdrf->orientation !== null) {
            $bdrf->orientation = null;
        }

        $bdrf->save();

        return self::handleRedirect($request, $bdrf, 'position');
    }

    public function update(Order $order, UpdateDetailsRequest $request): RedirectResponse
    {

        $bedarfsausweis = $order->product;

        $bedarfsausweis->side_a = $request->validated('side_a');
        $bedarfsausweis->side_b = $request->validated('side_b');

        if ($request->validated('orientation') !== null) {
            $bedarfsausweis->orientation = $request->validated('orientation');
        }

        if ($bedarfsausweis->maps === 'denied' && $request->validated('orientation') === null) {
            $bedarfsausweis->orientation = 's';
        }

        $bedarfsausweis->save();

        $order->update([
            'meta' => [
                'completed' => array_unique([...$order->meta['completed'], ...['position']]),
            ],
        ]);

        return self::handleRedirect($request, $order->certificate, 'position');
    }
}
