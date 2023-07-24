<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Models\Bdrf;
use App\Models\Insulation;
use App\Models\Wall;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WallController extends Controller
{

    // invokable method
    /**
     * @throws ValidationException
     */
    public function __invoke(Bdrf $bdrf, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'u_value' => 'numeric|nullable',
            'construction' => 'string|required',
            'variant' => 'string|required',
            'thickness' => 'numeric|nullable',
        ], [
            'u_wert.numeric' => 'Bitte geben Sie einen gültigen U-Wert an.',
            'construction.required' => 'Bitte wählen Sie eine Konstruktion aus.',
            'variant.required' => 'Bitte wählen Sie eine Variante aus.',
            'thickness.numeric' => 'Bitte geben Sie eine gültige Stärke an.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        Wall::updateOrCreate(
            ['bdrf_id' => $bdrf->id],
            $validator->validated()
        );

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
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
            'thickness.numeric' => 'Bitte geben Sie eine gültige Dicke an.',
            'thickness.required' => 'Bitte geben Sie eine Dicke an.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if (!$bdrf->wall) {
            abort(400, 'Noch keine Außenwand angelegt.');
        }

        $bdrf->wall->insulations()->create($validator->validated());

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
    }

    public function deleteInsulation(Bdrf $bdrf, Insulation $insulation, Request $request): RedirectResponse
    {
        $insulation->delete();

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
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
            'glazing.string' => 'Bitte wählen Sie eine gültige Verglasung aus.',
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

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
    }

    public function deleteWindow(Bdrf $bdrf, Window $window, Request $request): RedirectResponse
    {
        $window->delete();

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
    }


}
