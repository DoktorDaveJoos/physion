<?php

namespace App\Http\Controllers\Hub;

use App\Actions\CreateOrderForPartner;
use App\Enums\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderHubResource;
use App\Http\Resources\OrderResource;
use App\Models\Bdrf;
use App\Models\Order;
use App\Models\Vrbr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{

    public function __invoke(Request $request)
    {
        $bdrfs = Bdrf::search($request->input('query'))->get()->pluck('id');
        $vrbrs = Vrbr::search($request->input('query'))->get()->pluck('id');
        $orders = Order::search($request->input('query'))->get()->pluck('id');

        $results = collect();
        $bdrfs->each(function ($item, $key) use ($results) {
            $results->push([
                'type' => 'bdrfs',
                'data' => Bdrf::find($item),
            ]);
        });

        $vrbrs->each(function ($item, $key) use ($results) {
            $results->push([
                'type' => 'vrbrs',
                'data' => Vrbr::find($item),
            ]);
        });

        $orders->each(function ($item, $key) use ($results) {
            $results->push([
                'type' => 'orders',
                'data' => Order::find($item),
            ]);
        });

        return $results->toArray();
    }

}
