<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class CertificateController extends Controller
{
    /**
     * @throws Throwable
     */
    public function show(Order $order, Request $request): Response
    {
        ray($request->get('signature'));
        $category = Category::fromModel($order->certificate_type);

        if ($category->value === 'bdrf') {
            $order->load(
                'owner',
                'certificate',
                'certificate.wall',
                'certificate.wall.insulations',
                'certificate.wall.windows',
                'certificate.roof',
                'certificate.roof.insulations',
                'certificate.roof.windows',
                'certificate.roof.dormers',
                'certificate.cellar',
                'certificate.cellar.insulations',
                'certificate.heatingSystems',
                'certificate.renewableEnergyInstallations',
            );
        }

        if ($category->value === 'vrbr') {
            $order->load(
                'owner',
                'certificate',
                'certificate.sources',
                'certificate.sources.periods',
                'certificate.vacancies'
            );
        }

        $page = $request->get('page', 'details');

        // @todo replace by resource
        return Inertia::render($category->getVueComponent($page), [
            'order' => $order,
            'category' => $category->value,
            'page' => $page,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(Order $order, Request $request): RedirectResponse
    {
        $category = Category::fromModel($order->certificate_type);
        $page = $request->get('page');

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
            $order->update([
                'status' => 'finalized',
            ]);

            $checkout = URL::signedRoute('checkout.show', [
                'order' => $order->slug,
            ]);

            return redirect()->to($checkout);
        }

        // Redirect to the next page
        return to_route('certificate.show', [
            'order' => $order->slug,
            'page' => $nextPage,
            'signature' => $request->get('signature'),
        ]);
    }
}
