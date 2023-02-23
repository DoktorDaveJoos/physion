<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Http\Requests\Find\FindByEmailRequest;
use App\Http\Requests\Find\FindRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

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

    public function id(FindRequest $request): Response|RedirectResponse
    {
        $id = $request->input('order_id');

        $order = Order::find($id);

        if ($order) {
            return Inertia::render('Find/Index', [
                'orders' => [$order],
            ]);
        }

        return redirect()->route('find.show')->withErrors('error', 'No order found for this ID.');
    }

}
