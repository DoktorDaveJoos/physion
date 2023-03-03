<?php

namespace App\Http\Controllers;

use App\Actions\CreateCertificate;
use App\Actions\CreateCustomer;
use App\Actions\CreateOrder;
use App\Actions\CreateOrderWithProduct;
use App\Enums\Category;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{

    public function show(Order $order): Response
    {
        return Inertia::render('Order/Index', [
            'order' => $order,
        ]);
    }

    public function create(Category $category): Response
    {
        return Inertia::render('Order/Create', [
            'category' => $category->value,
        ]);
    }

    public function store(Category $category, CreateOrderRequest $request): RedirectResponse
    {
        $order = CreateOrderWithProduct::run(
            $category,
            $request->validated()
        );

        return redirect()->route('certificate.show', [
            'order' => $order->slug,
        ]);
    }

}
