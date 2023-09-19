<?php

namespace App\Http\Controllers\Hub;

use App\Enums\Category;
use App\Http\Controllers\Controller;
use App\Jobs\BroadcastMessageJob;
use App\Mail\SendCertificate;
use App\Models\Order;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
        $category = Category::fromModel($order->certificate_type);

        if ($category->value === 'bdrf' || $category->value === 'bdrf_partner') {
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

        if ($category->value === 'vrbr' || $category->value === 'vrbr_partner') {
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
            'picture' => $order->certificate->picture_path && $page === 'summary' ? Storage::disk(
                'digitalocean'
            )->url($order->certificate->picture_path) : null,
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
                'status' => 'open',
            ]);

            /** @var Team $team */
            $team = $request->user()->currentTeam;

            $stripeProductId = $order->products->first()->stripe_product_id;
            $stripePriceId = DB::query()->select('stripe_price')
                ->from('subscription_items')
                ->where('stripe_product', $stripeProductId)
                ->get();

            $team->subscription()->reportUsageFor($stripePriceId->first()->stripe_price);

            BroadcastMessageJob::dispatch(
                sprintf(
                    '🚀 Patte gemacht: %s€ bezahlt von %s %s für %s Produkte.',
                    $order->products->first()->price,
                    $order->owner->first_name,
                    $order->owner->last_name,
                    $order->products->count()
                )
            );

            return to_route('hub.certificates');
        }

        if ($request->user()) {
            return to_route('hub.certificates.show', [
                'order' => $order->slug,
                'page' => $nextPage,
            ]);
        }

        // Redirect to the next page
        return redirect()->route('certificate.show', [
            'order' => $order->slug,
            'page' => $nextPage,
        ]);
    }

    public function send(Order $order, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Bitte geben Sie eine E-Mail-Adresse ein.',
            'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
        ]);

        Mail::to($validated['email'])->send(
            new SendCertificate(
                $request->user()->currentTeam?->name,
                $order->attachments->where('type', 'certificate')->first()->path
            )
        );

        return to_route('hub.certificates');
    }


    /**
     * @throws Throwable
     */
    public function picture(Order $order, Request $request): RedirectResponse
    {
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
        ]);
    }
}
