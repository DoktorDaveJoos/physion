<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\UpdateDetailsRequest;
use App\Models\Bdrf;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Bdrf  $bdrf
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function maps(Bdrf $bdrf, Request $request): RedirectResponse
    {
        if (!$request->has('signature')) {
            abort(401);
        }

        $validated = $request->validate([
            'maps' => 'required|string',
        ]);

        $bdrf->maps = $validated['maps'];

        if ($validated['maps'] === true && $bdrf->orientation !== null) {
            $bdrf->orientation = null;
        }

        $bdrf->save();

        return redirect()->route('certificate.show', [
            'order' => $bdrf->order->slug,
            'signature' => $request->get('signature'),
            'page' => $request->get('page')
        ]);
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
