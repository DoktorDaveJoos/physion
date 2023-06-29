<?php

use App\Http\Controllers\Bdrf\PositionController;
use App\Http\Controllers\Bdrf\RoofController;
use App\Http\Controllers\Bdrf\WallController;
use App\Http\Controllers\Blog\SubscriptionsController;
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
use App\Mail\OrderInitialized;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\OrderCreated;
use Illuminate\Notifications\Messages\MailMessage;
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
    Route::put('/roof/insulation', [RoofController::class, 'insulation'])->name('bdrf.roof.insulation');
    Route::delete('/roof/insulation/{insulation}', [RoofController::class, 'deleteInsulation'])
        ->name('bdrf.roof.insulation.delete');
    Route::put('/roof/skylight', [RoofController::class, 'skylight'])->name('bdrf.roof.skylight');
    Route::delete('/roof/skylight/{skylight}', [RoofController::class, 'deleteSkylight'])
        ->name('bdrf.roof.skylight.delete');

    // dormer
    Route::put('/dormer', [PositionController::class, 'dormer'])->name('bdrf.roof.dormer');
    Route::delete('/dormer/{dormer}', [RoofController::class, 'deleteDormer'])->name('bdrf.roof.dormer.delete');


    Route::put('/dormer/insulation', [PositionController::class, 'dormerInsulation'])->name(
        'bdrf.roof.dormer.insulation'
    );
    Route::delete('/dormer/insulation/{insulation}', [PositionController::class, 'deleteDormerInsulation'])
        ->name('bdrf.roof.dormer.insulation.delete');
    Route::put('/dormer/window', [PositionController::class, 'dormerWindow'])->name('bdrf.roof.dormer.window');
    Route::delete('/dormer/window/{window}', [PositionController::class, 'deleteDormerWindow'])
        ->name('bdrf.roof.dormer.window.delete');


    // wall
    Route::put('/wall', WallController::class)->name('bdrf.wall');
    Route::put('/wall/insulation', [WallController::class, 'insulation'])->name('bdrf.wall.insulation');
    Route::delete('/wall/insulation/{insulation}', [WallController::class, 'deleteInsulation'])
        ->name('bdrf.wall.insulation.delete');
    Route::put('/wall/window', [WallController::class, 'window'])->name('bdrf.wall.window');
    Route::delete('/wall/window/{window}', [WallController::class, 'deleteWindow'])
        ->name('bdrf.wall.window.delete');

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
    Route::prefix('{order}')->group(function () {
        Route::get('/session', [CheckoutController::class, 'checkoutSession'])->name('session');

        Route::get('/', [ShowController::class, 'index'])->name('show');
        Route::post('upsell/{upsell}', AddUpsellController::class)->name('upsell.add');
        Route::delete('upsell/{upsell}', DeleteUpsellController::class)->name('upsell.delete');

        Route::post('paypal', PayPal\CaptureOrderController::class)->name('paypal.capture');

        Route::get('danke', [ShowController::class, 'thankyou'])->name('success');
    });
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('', [\App\Http\Controllers\Blog\ShowController::class, 'index'])->name('show');
    Route::get('{post}', [\App\Http\Controllers\Blog\ShowController::class, 'show'])->name('show.post');

    Route::post('subscribe', [SubscriptionsController::class, 'store'])->name('subscribe');
});

Route::get('/about', function () {
    return Inertia::render('About/About');
})->name('about');

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
        Route::get('/dashboard', function () {
            return Inertia::render('Hub/Dashboard');
        })->name('dashboard');

        Route::get('/admin', [\App\Http\Controllers\Hub\Admin\ShowController::class, 'index'])->name('admin');

        Route::get('/admin/blog', [\App\Http\Controllers\Hub\Admin\ShowController::class, 'blog'])->name('admin.blog');
    });
});
