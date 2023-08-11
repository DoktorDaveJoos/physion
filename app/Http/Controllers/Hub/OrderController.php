<?php

namespace App\Http\Controllers\Hub;

use App\Actions\CreateOrderForPartner;
use App\Enums\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderHubResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{

    public function index(Request $request): Response|RedirectResponse
    {
        if (!$request->user()->currentTeam?->subscribed('default')) {
            return to_route('hub.dashboard');
        }

        $orderQuery = Order::where('team_id', $request->user()?->current_team_id);

        $orders = Order::where('team_id', $request->user()?->current_team_id)
            ->when($request->get('filter'), function ($query, $filter) {
                return $query->where('status', $filter);
            })
            ->when($request->get('query'), function ($query) use ($request) {
                $type = Category::fromValue($request->get('type'))->getModel();
                ray($type);

                return $query->where('certificate_id', $request->get('query'))
                    ->where('certificate_type', $type::class);
            })
            ->paginate(15);

        return Inertia::render('Hub/Certificates/Index', [
            'orders' => OrderHubResource::collection($orders),
        ]);
    }

    public function show(Order $order): Response
    {
        $order->load('attachments');
        return Inertia::render('Order/Index', [
            'order' => OrderResource::make($order),
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

    public function destroy(Order $order, Request $request): RedirectResponse
    {
        if ($request->user()->hasTeamPermission($order->team, 'order:delete') === false) {
            abort(403);
        }

        $order->products()->detach($order->products->pluck('id'));
        $order->delete();

        return redirect()->route('hub.certificates');
    }

}
