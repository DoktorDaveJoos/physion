<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Models\Bdrf;
use App\Models\Building;
use App\Models\HeatingSystem;
use App\Models\RenewableEnergyInstallation;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RenewableController extends Controller
{

    use HandleFreeAndPaid;

    // invokable method
    /**
     * @throws ValidationException
     */
    public function __invoke(Building $building, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'area' => 'required|numeric',
            'construction_year' => 'required|numeric',
            'electricity' => 'required|boolean',
            'heating' => 'required|boolean',
            'water' => 'required|boolean',
            'comment' => 'nullable|string',
        ], [
            'type.required' => 'Bitte geben Sie den Typ der Anlage an.',
            'area.required' => 'Bitte geben Sie die Fläche der Anlage an.',
            'construction_year.required' => 'Bitte geben Sie das Baujahr der Anlage an.',
            'electricity.required' => 'Bitte geben Sie an, ob die Anlage Strom erzeugt.',
            'heating.required' => 'Bitte geben Sie an, ob die Anlage Wärme erzeugt.',
            'water.required' => 'Bitte geben Sie an, ob die Anlage Warmwasser erzeugt.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $building->renewableEnergyInstallations()->create($validator->validated());

        return to_route('hub.buildings.show.energy', $building);
    }

    public function destroy(Building $building, RenewableEnergyInstallation $renewableEnergyInstallation, Request $request): RedirectResponse
    {
        $renewableEnergyInstallation->delete();

        return to_route('hub.buildings.show.energy', $building);
    }


}
