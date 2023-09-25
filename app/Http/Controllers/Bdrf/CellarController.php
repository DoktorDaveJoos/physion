<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Models\Bdrf;
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
    public function __invoke(Bdrf $bdrf, Request $request): RedirectResponse
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
            ['bdrf_id' => $bdrf->id],
            $validator->validated()
        );

        return self::handleRedirect($request, $bdrf, 'thermal');
    }

    /**
     * @throws ValidationException
     */
    public function insulation(Bdrf $bdrf, Request $request): RedirectResponse
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

        if (!$bdrf->cellar) {
            abort(400, 'Noch keinen Keller angelegt.');
        }

        $bdrf->cellar->insulations()->create($validator->validated());

        return self::handleRedirect($request, $bdrf, 'thermal');
    }

    public function deleteInsulation(Bdrf $bdrf, Insulation $insulation, Request $request): RedirectResponse
    {
        $insulation->delete();

        return self::handleRedirect($request, $bdrf, 'thermal');
    }

    /**
     * @throws ValidationException
     */
    public function window(Bdrf $bdrf, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'count' => 'numeric|required',
            'glazing' => 'string|required',
            'height' => 'numeric|required|min:0|max:500',
            'width' => 'numeric|required|min:0|max:500',
        ], [
            'count.required' => 'Bitte geben Sie eine Anzahl an.',
            'count.numeric' => 'Bitte geben Sie eine gültige Anzahl an.',
            'glazing.required' => 'Bitte wählen Sie eine Verglasung aus.',
            'height.required' => 'Bitte geben Sie eine Höhe an.',
            'height.numeric' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.min' => 'Bitte geben Sie eine gültige Höhe an.',
            'height.max' => 'Bitte geben Sie eine gültige Höhe an.',
            'width.required' => 'Bitte geben Sie eine Breite an.',
            'width.numeric' => 'Bitte geben Sie eine gültige Breite an.',
            'width.min' => 'Bitte geben Sie eine gültige Breite an.',
            'width.max' => 'Bitte geben Sie eine gültige Breite an.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if (!$bdrf->wall) {
            return Redirect::back()->withErrors([
                'wall' => 'Noch keine Außenwand angelegt.',
            ]);
        }

        $bdrf->wall->windows()->create(
            $validator->validated()
        );

        return self::handleRedirect($request, $bdrf, 'thermal');
    }

    public function deleteWindow(Bdrf $bdrf, Window $window, Request $request): RedirectResponse
    {
        $window->delete();

        return self::handleRedirect($request, $bdrf, 'thermal');
    }


}
