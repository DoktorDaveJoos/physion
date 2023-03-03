<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\UpdateRoofRequest;
use App\Models\Dormer;
use App\Models\Insulation;
use App\Models\Order;
use App\Models\Roof;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RoofController extends Controller
{

    public function update(Order $order, UpdateRoofRequest $request)
    {

        $roof = Roof::updateOrCreate(
            ['bedarfsausweis_id' => $order->product_id],
            $request->validated()
        );

        return Redirect::route('bedarf.wall', $order->id);

    }

    public function addInsulation(Order $order, Request $request): RedirectResponse
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

        $order->product->roof->insulations()->create(
            $validator->validated()
        );

        return Redirect::route('bedarf.wall', $order->id);

    }

    public function deleteInsulation(Order $order, Insulation $insulation): RedirectResponse
    {
        $insulation->delete();

        return Redirect::route('bedarf.wall', $order->id);
    }

    public function addDormer(Order $order, Request $request): RedirectResponse
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

        $order->product->roof->dormers()->create(
            $validator->validated()
        );

        return Redirect::route('bedarf.wall', $order->id);
    }

    public function deleteDormer(Order $order, Dormer $dormer): RedirectResponse
    {
        $dormer->delete();

        return Redirect::route('bedarf.wall', $order->id);
    }

}
