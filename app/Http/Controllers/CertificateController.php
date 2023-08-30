<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;
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
            'picture' => $order->certificate->picture_path ? Storage::disk('digitalocean')->url($order->certificate->picture_path) : null,
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

    public function picture(Order $order, Request $request): RedirectResponse {
        $request->validate([
            'picture' => 'image|mimes:jpeg,png,jpg|max:10000',
        ], [
            'picture.image' => 'Bitte laden Sie ein Bild hoch.',
            'picture.mimes' => 'Bitte laden Sie ein Bild im Format jpg oder png hoch.',
            'picture.max' => 'Bitte laden Sie ein Bild hoch, das kleiner als 10 MB ist.',
        ]);

        $path = config('app.env').'/'.$order->slug.'/pictures';

        $success = $request->file('picture')->store($path, 'digitalocean');

        throw_if(!$success, new RuntimeException('Could not store file'));

        $order->certificate->update([
            'picture_path' => $success,
        ]);

        if ($request->user()) {
            return to_route('hub.certificates.show', [
                'order' => $order->slug,
                'page' => $request->get('page'),
            ]);
        }

        return redirect()->route('certificate.show', [
            'order' => $order->slug,
            'page' => $request->get('page'),
            'signature' => $request->get('signature'),
        ]);
    }

    public function deletePicture(Order $order, Request $request): RedirectResponse
    {

        Storage::disk('digitalocean')->delete($order->certificate->picture_path);

        $order->certificate->update([
            'picture_path' => null,
        ]);

        if ($request->user()) {
            return to_route('hub.certificates.show', [
                'order' => $order->slug,
                'page' => $request->get('page'),
            ]);
        }

        return redirect()->route('certificate.show', [
            'order' => $order->slug,
            'page' => $request->get('page'),
            'signature' => $request->get('signature'),
        ]);
    }
}
