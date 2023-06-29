<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Http\Requests\Find\FindByEmailRequest;
use App\Http\Requests\Find\FindBySlugRequest;
use App\Http\Resources\FindOrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\FindOrderNotification;
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

    public function byEmail(FindByEmailRequest $request): Response
    {
        $customer = Customer::where('email', $request->get('email'))->first();

        $customer?->notify(new FindOrderNotification($customer));

        return Inertia::render('Find/EmailResult');
    }

    public function bySlug(FindBySlugRequest $request): Response
    {
        return Inertia::render('Find/SlugResult', [
            'result' => FindOrderResource::make(Order::where('slug', $request->get('slug'))->first()),
        ]);
    }

}
