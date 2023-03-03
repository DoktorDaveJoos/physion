<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\Bdrf;
use App\Models\Order;
use App\Models\Vrbr;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class CertificateController extends Controller
{
    public function show(Order $order): RedirectResponse
    {
        return redirect()->route('certificate.show.page', [
            'order' => $order->slug,
            'page' => 'general',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function showPage(Order $order, string $page): Response
    {
        $category = Category::fromModel($order->certificate_type);

        return Inertia::render($category->getVueComponent($page), [
            'certificate' => $order->certificate,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function updatePage(Order $order, string $page, Request $request): RedirectResponse
    {
        $category = Category::fromModel($order->certificate_type);

        // Validate the request using the FormRequest
        $validated = $request->validate(
            $category->getFormRequest($page)->rules(),
            $category->getFormRequest($page)->messages(),
        );

        // Run the action with the validated data
        $category->getAction($page)::run($order, $validated);

        // Check if there is a next page
        // If there is no next page, redirect to the checkout page
        if (!($nextPage = $category->getNextPageAfter($page))) {
            return redirect()->route('checkout.show', [
                'order' => $order->slug,
            ]);
        }

        // Redirect to the next page
        return redirect()->route('certificate.show.page', [
            'order' => $order->slug,
            'page' => $nextPage,
        ]);
    }
}
