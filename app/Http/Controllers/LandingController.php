<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class LandingController extends Controller
{

    public function __invoke(): Response
    {
        return Inertia::render('Landing', [
            'tiers' => ProductResource::collection(
                Product::where('active', true)
                    ->where('type', 'certificate')
                    ->get()
            ),
        ]);
    }

}
