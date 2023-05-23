<?php

namespace App\Http\Controllers\Find;

use App\Actions\FindCertificate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Find\FindRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ShowController extends Controller
{

    /**
     * @param  FindRequest  $request
     * @return Response
     * @throws Throwable
     */
    public function index(FindRequest $request): Response
    {
        try {
            $validated = $request->validated();

            $orders = $request->has('order') ?
                FindCertificate::handle($validated['order']) :
                FindCertificate::handle($validated['email'], $validated['zip']);
        } catch (Throwable $e) {
            Log::debug($e->getMessage());

            $orders = [];
        }

        return Inertia::render('Find/Index', [
            'orders' => $orders,
        ]);
    }

}
