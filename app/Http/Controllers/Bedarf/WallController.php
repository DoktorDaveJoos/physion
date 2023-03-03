<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wall;
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
    public function __invoke(Order $order, Request $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'u_wert' => 'numeric|nullable',
            'construction' => 'string|required',
            'variant' => 'string|required',
            'thickness' => 'numeric|nullable'
        ], [
            'u_wert.numeric' => 'Bitte geben Sie einen gültigen U-Wert an.',
            'construction.required' => 'Bitte wählen Sie eine Konstruktion aus.',
            'variant.required' => 'Bitte wählen Sie eine Variante aus.',
            'thickness.numeric' => 'Bitte geben Sie eine gültige Stärke an.'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        Wall::updateOrCreate(
            ['bedarfsausweis_id' => $order->product_id],
            $validator->validated()
        );

        return Redirect::route('bedarf.wall', $order->id);
    }


}
