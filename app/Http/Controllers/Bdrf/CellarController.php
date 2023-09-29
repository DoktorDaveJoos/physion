<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Models\Bdrf;
use App\Models\Building;
use App\Models\Cellar;
use App\Models\Insulation;
use App\Models\Wall;
use App\Models\Window;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CellarController extends Controller
{

    use HandleFreeAndPaid;

    // invokable method
    /**
     * @throws ValidationException
     */
    public function __invoke(Building $building, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'u_value' => 'numeric|nullable',
            'type' => 'string|required',
            'ceiling' => 'numeric|nullable',
            'height' => Rule::requiredIf(function () use ($request) {
                return $request->type !== 'Kein Keller';
            }),
        ], [
            'u_wert.numeric' => 'Bitte geben Sie einen gültigen U-Wert an.',
            'heated.required' => 'Bitte geben Sie an, ob der Keller beheizt ist.',
            'ceiling.numeric' => 'Bitte geben Sie eine gültige Deckenhöhe an.',
            'height.numeric' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.required' => 'Bitte geben Sie eine Geschosshöhe an.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        Cellar::updateOrCreate(
            ['building_id' => $building->id],
            $validator->validated()
        );

        return to_route('hub.buildings.thermal', $building);
    }

    /**
     * @throws ValidationException
     */
    public function insulation(Building $building, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'string|required',
            'thickness' => 'numeric|required',
        ], [
            'type.required' => 'Bitte wählen Sie eine Dämmung aus.',
            'type.string' => 'Bitte wählen Sie eine gültige Dämmung aus.',
            'thickness.required' => 'Bitte geben Sie eine Dicke an.',
            'thickness.numeric' => 'Bitte geben Sie eine gültige Dicke an.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if (!$building->cellarObject) {
            abort(400, 'Noch keinen Keller angelegt.');
        }

        $building->cellarObject->insulations()->create($validator->validated());

        return to_route('hub.buildings.thermal', $building);
    }

    public function deleteInsulation(Building $building, Insulation $insulation, Request $request): RedirectResponse
    {
        $insulation->delete();

        return to_route('hub.buildings.thermal', $building);
    }

    public function deleteWindow(Building $building, Window $window, Request $request): RedirectResponse
    {
        $window->delete();

        return to_route('hub.buildings.thermal', $building);
    }


}
