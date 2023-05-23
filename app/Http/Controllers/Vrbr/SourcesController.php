<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vrbr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateOrUpdateSourceRequest;
use App\Models\EnergySource;
use App\Models\Vrbr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SourcesController extends Controller
{


    public function store(CreateOrUpdateSourceRequest $request, Vrbr $vrbr): RedirectResponse
    {

        $waterEnabled = $request->get('water') === 'Im Verbrauch enthalten - Genaue Werte bekannt'
            || $request->get('water') === 'Nicht im Verbrauch enthalten - Werte bekannt';

        $isMain = $vrbr->sources()->count() === 0;

        EnergySource::create([
            'source' => $request->get('source'),
            'water' => $request->get('water'),
            'water_enabled' => $waterEnabled,
            'vrbr_id' => $vrbr->id,
            'main' => $isMain,
        ]);

        return to_route('certificate.show', [
            'order' => $vrbr->order,
            'page' => 'consumption',
            'signature' => $request->get('signature')
        ]);

    }

    public function destroy(Request $request, Vrbr $vrbr, EnergySource $source): RedirectResponse
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        $source->delete();

        return to_route('certificate.show', [
            'order' => $vrbr->order,
            'page' => 'consumption',
            'signature' => $request->get('signature')
        ]);
    }


}
