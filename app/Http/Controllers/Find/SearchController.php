<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Http\Requests\Find\FindByEmailRequest;
use App\Http\Requests\Find\FindByIdRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function email(FindByEmailRequest $request)
    {
        $email = $request->input('email');

        $order = Order::where('email', $email)->first();

        if ($order) {
            return redirect()->route('find.show', ['order' => $order]);
        }

        return redirect()->route('find.show')->with('error', 'No order found for this email address.');
    }

    public function id(FindByIdRequest $request)
    {


        return Order::all();

//        $id = $request->input('id');
//
//        $order = Order::find($request->safe()->id);
//
//        if ($order) {
//            return redirect()->route('find.show', ['order' => $order]);
//        }
//
//        return redirect()->route('find.show')->with('error', 'No order found for this ID.');
    }

}
