<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\UpdateDetailsRequest;
use App\Models\Bdrf;
use App\Models\Building;
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
     * @param  Building  $building
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function maps(Building $building, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'maps' => 'required|string',
        ]);

        $building->maps = $validated['maps'];

        if ($validated['maps'] === true && $building->orientation !== null) {
            $building->orientation = null;
        }

        $building->save();

        return to_route('hub.buildings.show.position', $building->id);
    }

//    public function update(Order $order, UpdateDetailsRequest $request): RedirectResponse
//    {
//
//        $bedarfsausweis = $order->product;
//
//        $bedarfsausweis->side_a = $request->validated('side_a');
//        $bedarfsausweis->side_b = $request->validated('side_b');
//
//        if ($request->validated('orientation') !== null) {
//            $bedarfsausweis->orientation = $request->validated('orientation');
//        }
//
//        if ($bedarfsausweis->maps === 'denied' && $request->validated('orientation') === null) {
//            $bedarfsausweis->orientation = 's';
//        }
//
//        $bedarfsausweis->save();
//
//        $order->update([
//            'meta' => [
//                'completed' => array_unique([...$order->meta['completed'], ...['position']]),
//            ],
//        ]);
//
//        return to_route('hub.buildings.show.position', $building->id);
//    }
}
