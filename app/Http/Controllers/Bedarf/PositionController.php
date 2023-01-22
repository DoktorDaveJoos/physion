<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\UpdateDetailsRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function setMaps(Order $order, Request $request): RedirectResponse
    {
        $bedarfsausweis = $order->product;

        $validated = $request->validate([
            'maps' => 'required|string',
        ]);

        $bedarfsausweis->maps = $validated['maps'];

        if ($validated['maps'] === true && $bedarfsausweis->orientation !== null) {
            $bedarfsausweis->orientation = null;
        }

        $bedarfsausweis->save();

        return redirect()->route('bedarf.position', $order);
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

        return redirect()->route('bedarf.wall', $order);
    }
}
