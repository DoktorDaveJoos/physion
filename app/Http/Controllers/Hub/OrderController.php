<?php

namespace App\Http\Controllers\Hub;

use App\Actions\CreateOrderForPartner;
use App\Enums\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{

    public function index(Request $request): Response
    {
        $filter = $request->get('filter');

        $orders = Order::where('team_id', $request->user()->currentTeam->id)
            ->when($filter, function ($query, $filter) {
                return $query->where('status', $filter);
            })
            ->with('certificate', 'owner')
            ->paginate(10);

        return Inertia::render('Hub/Certificates/Index', [
            'orders' => $orders,
            'filter' => $filter,
        ]);
    }

    public function show(Order $order): Response
    {
        return Inertia::render('Order/Index', [
            'order' => OrderResource::make($order),
            'attachments' => AttachmentResource::collection($order->attachments),
        ]);
    }

    public function create(Category $category): Response
    {
        return Inertia::render('Hub/Certificates/Order/Create', [
            'category' => $category->value,
        ]);
    }

    public function store(Category $category, CreateOrderRequest $request): RedirectResponse
    {
        $order = CreateOrderForPartner::run(
            $category,
            $request->validated()
        );

        return redirect()->to(
            route('hub.certificates.show', [
                'order' => $order->slug,
            ])
        );
    }

}
