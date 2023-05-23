<?php

namespace App\Http\Middleware;

use App\Enums\Category;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CategoryPageIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(Request): (Response)  $next
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

        if (($page = $request->route('page')) === null) {
            return $next($request);
        }

        if (!$category->pageExists($page)) {
            abort(404, 'Page not found');
        }

        return $next($request);
    }
}
