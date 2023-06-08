<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Http\Requests\Find\FindBySlugRequest;
use App\Http\Resources\FindOrderResource;
use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class FindByController extends Controller
{

    /**
     * @param  FindBySlugRequest  $request
     * @return Response
     * @throws Throwable
     */
    public function index(): Response
    {
        return Inertia::render('Find/Index');
    }

    public function byEmail(FindBySlugRequest $request): Response
    {
        return Inertia::render('Find/Result', [
            'orders' => [],
        ]);
    }

    public function bySlug(FindBySlugRequest $request): Response
    {
        return Inertia::render('Find/Result', [
            'result' => FindOrderResource::make(Order::where('slug', $request->get('slug'))->first()),
        ]);
    }

}
