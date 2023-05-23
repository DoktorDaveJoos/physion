<?php

namespace App\Http\Middleware;

use App\Enums\Category;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EnsureCertificateIsAccessible
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        $order = $request->route('order');

        if (!($order instanceof Order)) {
            $order = Order::where('slug', $order)->firstOrFail();
        }

        $category = Category::fromModel($order->certificate_type);

        if (!in_array($order->status, $category->eligibleForUpdate())) {
            switch ($request->method()) {
                case 'GET':
                    return redirect()->route('order.show', $order->slug);
                case 'PUT':
                    abort(403);
                default:
                    abort(405);
            }
        }

        return $next($request);
    }
}
