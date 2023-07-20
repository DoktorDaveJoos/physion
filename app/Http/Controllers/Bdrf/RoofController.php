<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\UpdateRoofRequest;
use App\Models\Bdrf;
use App\Models\Dormer;
use App\Models\Insulation;
use App\Models\Order;
use App\Models\Roof;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoofController extends Controller
{

    public function __invoke(Bdrf $bdrf, UpdateRoofRequest $request): RedirectResponse
    {
        Roof::updateOrCreate(
            ['bdrf_id' => $bdrf->id],
            $request->validated()
        );

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature')
        ]);
    }

    public function insulation(Bdrf $bdrf, Request $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'type' => 'string|required',
            'thickness' => 'numeric|required'
        ], [
            'type.required' => 'Bitte wählen Sie eine Dämmung aus.',
            'type.string' => 'Bitte wählen Sie eine Dämmung aus.',
            'thickness.required' => 'Bitte geben Sie eine Stärke an.',
            'thickness.numeric' => 'Bitte geben Sie eine gültige Stärke an.'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $bdrf->roof->insulations()->create(
            $validator->validated()
        );

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature')
        ]);

    }

    public function deleteInsulation(Bdrf $bdrf, Insulation $insulation, Request $request): RedirectResponse
    {
        $insulation->delete();

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature')
        ]);
    }

    public function dormer(Bdrf $bdrf, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'count' => 'numeric|required',
            'form' => 'string|required',
            'height' => 'numeric|required|min:0|max:1000',
            'width' => 'numeric|required|min:0|max:1000',
        ], [
            'count.required' => 'Bitte geben Sie eine Anzahl an.',
            'count.numeric' => 'Bitte geben Sie eine gültige Anzahl an.',
            'form.required' => 'Bitte wählen Sie eine Bauweise aus.',
            'form.string' => 'Bitte wählen Sie eine gültige Bauweise aus.',
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

        $bdrf->roof->dormers()->create(
            $validator->validated()
        );

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature')
        ]);
    }

    public function deleteDormer(Bdrf $bdrf, Dormer $dormer, Request $request): RedirectResponse
    {
        $dormer->delete();

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature')
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function skylight(Bdrf $bdrf, Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'count' => 'numeric|required',
            'glazing' => 'string|required',
            'height' => 'numeric|required|min:0|max:500',
            'width' => 'numeric|required|min:0|max:500',
        ], [
            'count.required' => 'Bitte geben Sie eine Anzahl an.',
            'count.numeric' => 'Bitte geben Sie eine gültige Anzahl an.',
            'glazing.string' => 'Bitte wählen Sie eine Verglasung aus.',
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

        $bdrf->roof->windows()->create(
            $validator->validated()
            + ['type' => 'dachfenster']
        );

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
    }

    public function deleteSkylight(Bdrf $bdrf, Window $window, Request $request): RedirectResponse
    {
        ray($window);

        $window->delete();

        return Redirect::route('certificate.show', [
            'order' => $bdrf->order->slug,
            'page' => 'thermal',
            'signature' => $request->get('signature'),
        ]);
    }

}
