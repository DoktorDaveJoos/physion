<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vrbr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateOrUpdateSourceRequest;
use App\Models\EnergySource;
use App\Models\Vrbr;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SourcesController extends Controller
{

    use HandleFreeAndPaid;


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

        return self::handleRedirect($request, $vrbr, 'consumption');
    }

    public function destroy(Request $request, Vrbr $vrbr, EnergySource $source): RedirectResponse
    {
        $source->delete();

        return self::handleRedirect($request, $vrbr, 'consumption');
    }


}
