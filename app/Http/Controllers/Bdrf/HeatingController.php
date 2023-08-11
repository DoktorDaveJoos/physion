<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Models\Bdrf;
use App\Models\Cellar;
use App\Models\HeatingSystem;
use App\Models\Insulation;
use App\Models\Window;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HeatingController extends Controller
{

    use HandleFreeAndPaid;

    // invokable method
    /**
     * @throws ValidationException
     */
    public function __invoke(Bdrf $bdrf, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'system' => 'required|string',
            'construction_year' => 'required|numeric',
            'water_included' => 'required|boolean',
            'is_main' => 'required|boolean',
            'comment' => 'nullable|string',
        ], [
            'type.required' => 'Bitte geben Sie den Typ der Heizung an.',
            'system.required' => 'Bitte geben Sie das System der Heizung an.',
            'construction_year.required' => 'Bitte geben Sie das Baujahr der Heizung an.',
            'water_included.required' => 'Bitte geben Sie an, ob die Warmwasserversorgung in der Heizung enthalten ist.',
            'is_main.required' => 'Bitte geben Sie an, ob die Heizung die Hauptheizung ist.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $bdrf->heatingSystems()->create($validator->validated());

        return self::handleRedirect($request, $bdrf, 'energy');
    }

    public function destroy(Bdrf $bdrf, HeatingSystem $heatingSystem, Request $request): RedirectResponse
    {
        $heatingSystem->delete();

        return self::handleRedirect($request, $bdrf, 'energy');
    }


}
