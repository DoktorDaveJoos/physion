<?php

namespace App\Http\Controllers\Hub;

use App\Enums\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\BdrfSearchResource;
use App\Http\Resources\VrbrSearchResource;
use App\Models\Bdrf;
use App\Models\Vrbr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __invoke(Request $request)
    {

        if (!$request->user()->current_team_id) {
            return [
                'bdrfs' => [],
                'vrbrs' => [],
            ];
        }

        $bdrfs = Bdrf::search($request->input('query'))->query(
            fn(Builder $query) => $query->whereRelation('order', 'team_id', '=', $request->user()->current_team_id)
        )->get();

        $vrbrs = Vrbr::search($request->input('query'))->query(
            fn(Builder $query) => $query->whereRelation('order', 'team_id', '=', $request->user()->current_team_id)
        )->get();

        return [
            'bdrfs' => BdrfSearchResource::collection($bdrfs),
            'vrbrs' => VrbrSearchResource::collection($vrbrs),
        ];
    }

}
