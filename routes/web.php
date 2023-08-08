<?php

use App\Http\Controllers\Bdrf\CellarController;
use App\Http\Controllers\Bdrf\HeatingController;
use App\Http\Controllers\Bdrf\PositionController;
use App\Http\Controllers\Bdrf\RenewableController;
use App\Http\Controllers\Bdrf\RoofController;
use App\Http\Controllers\Bdrf\WallController;
use App\Http\Controllers\Blog\SubscriptionController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Checkout\AddUpsellController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Checkout\DeleteUpsellController;
use App\Http\Controllers\Checkout\PayPal;
use App\Http\Controllers\Checkout\ShowController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Find\FindByController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Vrbr\PeriodsController;
use App\Http\Controllers\Vrbr\SourcesController;
use App\Http\Controllers\Vrbr\VacanciesController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Shorts:
 * bdr = bdrf = Bedarfsausweis
 * vrb = vbrc = Verbrauchsausweis
 * ifs = ifsp = ifSP
 * qng = qngx = QNG/BNK
 * rtg = rtgb = Ratgeber
 *
 * Creating an order that can contain multiple products
 *
 * Create an order with a product
 * GET      /orders/create/{short}
 * POST     /orders/create/{short}
 *
 * GET      /orders/{order}
 *
 * eg:      /orders/nX7umHQ
 *
 * Due to different kind of products, the link to show the product itself is
 * contained in the product itself
 *
 * GET      certificates/{category}/{certificate}
 * PUT      certificates/{category}/{certificate}
 * GET      certificates/{category}/{certificate}/{page}
 *
 * eg:      certificates/bdrf/41nX7umHQ/general
 * eg:      orders/1/certificate/general?signature=1823213v1231237v2131ff3sdf7sdf8s612
 *
 * Resources will be handled by a dedicated route
 *
 * POST     /<resources-name>
 * GET      /<resources-name>/<resource-id>
 *
 * eg:      /cnsm
 * eg:      /cnsm/246
 *
 * Resources that are morphed to different models will be handled by a dedicated
 * route per product/parent and resource. The long URL is needed to instantiate
 * the morphable model to the right parent model
 *
 * POST     /<model-slug>/<model-id>/<morphed-resource-name>
 *
 * eg:      /roof/265/windows
 *
 * Requesting a morphable model can be done easily as for every resource
 *
 * GET      /<morphed-resource-name>/<morphed-resource-id>
 *
 * eg:      /windows/102
 *
 **/

//Route::prefix('orders')->group(function() {
//
//    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
//
//    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
//    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
//
//    Route::post('/orders/{order}/products', [ProductController::class, 'store'])->name('orders.products.store');
//
//});
//
//Route::prefix('products')->group(function() {
//
//    Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');
//    Route::put('/{category}/{product}', [ProductController::class, 'update'])->name('products.update');
//    Route::delete('/{category}/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
//
//    Route::get('/{category}/{product}/{page}', [ProductController::class, 'showPage'])->name('products.show.page');
//
//});

Route::get('/impressum', function () {
    return Inertia::render('Imprint');
})->name('impressum');

Route::get('/datenschutz', function () {
    return Inertia::render('PrivacyPolicy');
})->name('datenschutz');

Route::prefix('orders')->group(function () {
    Route::get('/create/{category}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/create/{category}', [OrderController::class, 'store'])->name('order.store');

    Route::get('/{order:slug}', [OrderController::class, 'show'])->middleware(['signed'])->name('order.show');

    Route::prefix('{order:slug}/certificate')->middleware(['signed'])->group(
        function () {
            Route::get('/', [CertificateController::class, 'show'])->name('certificate.show');
            Route::put('/', [CertificateController::class, 'update'])->name('certificate.update');
        }
    );
});

Route::prefix('bdrf/{bdrf}')->group(function () {
    // roof
    Route::put('/roof', RoofController::class)->name('bdrf.roof');

    // roof insulation
    Route::put('/roof/insulation', [RoofController::class, 'insulation'])->name('bdrf.roof.insulation');
    Route::delete('/roof/insulation/{insulation}', [RoofController::class, 'deleteInsulation'])
        ->name('bdrf.roof.insulation.delete');
    // roof windows
    Route::put('/roof/skylight', [RoofController::class, 'skylight'])->name('bdrf.roof.skylight');
    Route::delete('/roof/skylight/{window}', [RoofController::class, 'deleteSkylight'])
        ->name('bdrf.roof.skylight.delete');
    // roof dormer
    Route::put('/roof/dormer', [RoofController::class, 'dormer'])->name('bdrf.roof.dormer');
    Route::delete('/dormer/{dormer}', [RoofController::class, 'deleteDormer'])->name('bdrf.roof.dormer.delete');

    // wall
    Route::put('/wall', WallController::class)->name('bdrf.wall');

    // wall insulation
    Route::put('/wall/insulation', [WallController::class, 'insulation'])->name('bdrf.wall.insulation');
    Route::delete('/wall/insulation/{insulation}', [WallController::class, 'deleteInsulation'])
        ->name('bdrf.wall.insulation.delete');
    // wall windows
    Route::put('/wall/window', [WallController::class, 'window'])->name('bdrf.wall.window');
    Route::delete('/wall/window/{window}', [WallController::class, 'deleteWindow'])
        ->name('bdrf.wall.window.delete');

    // cellar
    Route::put('/cellar', CellarController::class)->name('bdrf.cellar');

    // cellar insulation
    Route::put('/cellar/insulation', [CellarController::class, 'insulation'])->name('bdrf.cellar.insulation');
    Route::delete('/cellar/insulation/{insulation}', [CellarController::class, 'deleteInsulation'])
        ->name('bdrf.cellar.insulation.delete');

    // heating system
    Route::put('/heating', HeatingController::class)->name('bdrf.heating');
    Route::delete('/heating/{heatingSystem}', [HeatingController::class, 'destroy'])->name('bdrf.heating.delete');

    // renewable energy
    Route::put('/renewable', RenewableController::class)->name('bdrf.renewable');
    Route::delete('/renewable/{renewableEnergyInstallation}', [RenewableController::class, 'destroy'])->name('bdrf.renewable.delete');

    // position
    Route::put('/maps', [PositionController::class, 'maps'])->name('bdrf.maps');
    Route::put('/position', [PositionController::class, 'position'])->name('bdrf.position');
});

Route::prefix('vrbr/{vrbr}')->group(function () {
    Route::post('/sources', [SourcesController::class, 'store'])->name('vrbr.sources');
    Route::delete('/sources/{source}', [SourcesController::class, 'destroy'])->name('vrbr.sources.destroy');

    Route::post('/sources/{source}/periods', [PeriodsController::class, 'store'])->name('vrbr.periods');
    Route::delete('/periods/{period}', [PeriodsController::class, 'destroy'])->name('vrbr.periods.destroy');

    Route::post('/vacancies', [VacanciesController::class, 'store'])->name('vrbr.vacancies');
    Route::delete('/vacancies/{vacancy}', [VacanciesController::class, 'destroy'])->name('vrbr.vacancies.destroy');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::prefix('{order:slug}')->group(function () {

        Route::get('/', [ShowController::class, 'index'])->middleware('signed')->name('show');

        Route::get('/session', [CheckoutController::class, 'checkoutSession'])->name('session');

        Route::post('upsell/{upsell}', AddUpsellController::class)->name('upsell.add');
        Route::delete('upsell/{upsell}', DeleteUpsellController::class)->name('upsell.delete');

        Route::post('paypal', PayPal\CaptureOrderController::class)->name('paypal.capture');

        Route::get('danke', [ShowController::class, 'thankyou'])->name('success');
    });
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('', [\App\Http\Controllers\Blog\ShowController::class, 'index'])->name('show');
//    Route::get('{post}', [\App\Http\Controllers\Blog\ShowController::class, 'show'])->name('show.post');

    Route::post('subscribe', [SubscriptionController::class, 'store'])->name('subscribe');
});

Route::post('/newsletter', [SubscriptionController::class, 'store'])->name('newsletter.store');
Route::post('/business', [SubscriptionController::class, 'storeBusiness'])->name('business.store');

Route::get('/about', function () {
    return Inertia::render('About/About');
})->name('about');

Route::get('/energiehub', function () {
    return Inertia::render('Feature/EnergieHub');
})->name('energiehub');

Route::get('/business', function () {
    return Inertia::render('Feature/BusinessPartnerProgram');
})->name('business-partner');

Route::prefix('kontakt')->name('contact.')->group(function () {
    Route::get('', [ContactController::class, 'index'])->name('show');
    Route::post('', [ContactController::class, 'store'])->name('store');
});

Route::prefix('/find')->name('find.')->group(function () {
    Route::get('/', [FindByController::class, 'index'])->name('show');

    Route::get('/slug', [FindByController::class, 'bySlug'])->name('slug');
    Route::get('/email', [FindByController::class, 'byEmail'])->name('email');
});

Route::get('/', LandingController::class)->name('start');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('/hub')->name('hub.')->group(function () {
        Route::get('/dashboard', function (Request $request) {
            ray($request->user()->currentTeam?->subscription('default')?->upcomingInvoice());

            return Inertia::render('Hub/Dashboard', [
                'products' => Product::where('recurring', true)->where('type', 'certificate')->get(),
                'stats' => [
                    'orders' => [
                        'open' => Order::where('status', 'open')->where('team_id', $request->user()->current_team_id)->count(),
                        'all' => Order::where('team_id', $request->user()->current_team_id)->count(),
                    ],
                    'team' => [
                        'members' => $request->user()->currentTeam?->allUsers()?->count(),
                    ],
                    'subscription' => $request->user()->currentTeam?->subscribed('default'),
                ]
            ]);
        })->name('dashboard');

        Route::get('/billing', function (Request $request) {
            $team = $request->user()->currentTeam;
            $team->createOrGetStripeCustomer();

            return $team->redirectToBillingPortal(route('hub.dashboard'));
        })->name('billing');

        Route::get('/orders/create/{category}', [\App\Http\Controllers\Hub\OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/create/{category}', [\App\Http\Controllers\Hub\OrderController::class, 'store'])->name('orders.store');
        Route::delete('/orders/{order:slug}', [\App\Http\Controllers\Hub\OrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('/orders/{order:slug}/certificate', [\App\Http\Controllers\Hub\CertificateController::class, 'show'])->name('certificates.show');
        Route::put('/orders/{order:slug}/certificate', [\App\Http\Controllers\Hub\CertificateController::class, 'update'])->name('certificates.update');

        Route::get('/orders', [\App\Http\Controllers\Hub\OrderController::class, 'index'])->name('certificates');

        Route::get('/admin', [\App\Http\Controllers\Hub\Admin\ShowController::class, 'index'])->name('admin');

        Route::get('/admin/blog', [\App\Http\Controllers\Hub\Admin\ShowController::class, 'blog'])->name('admin.blog');
    });
});
