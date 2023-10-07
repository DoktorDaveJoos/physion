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
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Find\FindByController;
use App\Http\Controllers\Hub\BillingController;
use App\Http\Controllers\Hub\BuildingController;
use App\Http\Controllers\Hub\DashboardController;
use App\Http\Controllers\Hub\SearchController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Vrbr\PeriodsController;
use App\Http\Controllers\Vrbr\SourcesController;
use App\Http\Controllers\Vrbr\VacanciesController;
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

    Route::post('{order:slug}/certificate/picture', [CertificateController::class, 'picture'])->name('certificate.picture');
    Route::delete('{order:slug}/certificate/picture', [CertificateController::class, 'deletePicture'])->name('certificate.picture.delete');
});

Route::prefix('building/{building}')->name('building.')->group(function () {
    // roof
    Route::put('/roof', RoofController::class)->name('roof');

    // roof insulation
    Route::put('/roof/insulation', [RoofController::class, 'insulation'])->name('roof.insulation');
    Route::delete('/roof/insulation/{insulation}', [RoofController::class, 'deleteInsulation'])
        ->name('roof.insulation.delete');
    // roof windows
    Route::put('/roof/skylight', [RoofController::class, 'skylight'])->name('roof.skylight');
    Route::delete('/roof/skylight/{window}', [RoofController::class, 'deleteSkylight'])
        ->name('roof.skylight.delete');
    // roof dormer
    Route::put('/roof/dormer', [RoofController::class, 'dormer'])->name('roof.dormer');
    Route::delete('/dormer/{dormer}', [RoofController::class, 'deleteDormer'])->name('roof.dormer.delete');

    // wall
    Route::put('/wall', WallController::class)->name('wall');

    // wall insulation
    Route::put('/wall/insulation', [WallController::class, 'insulation'])->name('wall.insulation');
    Route::delete('/wall/insulation/{insulation}', [WallController::class, 'deleteInsulation'])
        ->name('wall.insulation.delete');
    // wall windows
    Route::put('/wall/window', [WallController::class, 'window'])->name('wall.window');
    Route::delete('/wall/window/{window}', [WallController::class, 'deleteWindow'])
        ->name('wall.window.delete');

    // cellar
    Route::put('/cellar', CellarController::class)->name('cellar');

    // cellar insulation
    Route::put('/cellar/insulation', [CellarController::class, 'insulation'])->name('cellar.insulation');
    Route::delete('/cellar/insulation/{insulation}', [CellarController::class, 'deleteInsulation'])
        ->name('cellar.insulation.delete');

    // heating system
    Route::put('/heating', HeatingController::class)->name('heating');
    Route::delete('/heating/{heatingSystem}', [HeatingController::class, 'destroy'])->name('heating.delete');

    // renewable energy
    Route::put('/renewable', RenewableController::class)->name('renewable');
    Route::delete('/renewable/{renewableEnergyInstallation}', [RenewableController::class, 'destroy'])->name(
        'renewable.delete'
    );

    // consumptions
    Route::put('/consumption', [ConsumptionController::class, 'store'])->name('consumption');
    Route::delete('/consumption/{consumption}', [ConsumptionController::class, 'destroy'])->name(
        'consumption.delete');

    // position
    Route::put('/maps', [PositionController::class, 'maps'])->name('maps');
    Route::put('/position', [PositionController::class, 'position'])->name('position');
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
        Route::get('search', SearchController::class)->name('search');

        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
        Route::post('/buildings/create', [BuildingController::class, 'store'])->name('buildings.store');

        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
        Route::get('/buildings/{building}', [BuildingController::class, 'show'])->name('buildings.show.index');

        Route::get('/buildings/{building}/general', [BuildingController::class, 'general'])->name('buildings.show.general');
        Route::put('/buildings/{building}/general', [BuildingController::class, 'update'])->name('buildings.general.update');
        Route::get('/buildings/{building}/position', [BuildingController::class, 'position'])->name('buildings.show.position');
        Route::put('/buildings/{building}/position', [BuildingController::class, 'updatePosition'])->name('buildings.position.update');
        Route::get('/buildings/{building}/thermal', [BuildingController::class, 'thermal'])->name('buildings.show.thermal');
        Route::get('/buildings/{building}/energy', [BuildingController::class, 'energy'])->name('buildings.show.energy');
        Route::get('/buildings/{building}/consumption', [BuildingController::class, 'consumption'])->name('buildings.show.consumption');

        Route::get('/buildings/{building}/docs', [BuildingController::class, 'showDocs'])->name('buildings.docs');

        Route::get('/buildings/{building}/energieausweis', [BuildingController::class, 'showEnergieausweis'])->name('buildings.energieausweis');

        Route::get('/buildings/{building}/isfp', [BuildingController::class, 'showIsfp'])->name('buildings.isfp');
        Route::post('/buildings/{building}/isfp', [BuildingController::class, 'storeIsfp'])->name('buildings.isfp.store');

        Route::get('/buildings/{building}/bza', [BuildingController::class, 'showBza'])->name('buildings.bza');
        Route::post('/buildings/{building}/bza', [BuildingController::class, 'storeBza'])->name('buildings.bza.store');

        Route::get('/buildings/{building}/calculator', [BuildingController::class, 'showCalculator'])->name('buildings.calculator');

        Route::post('buildings/{building}/documents', [BuildingController::class, 'storeDocument'])->name('buildings.documents.store');
        Route::delete('buildings/{building}/documents/{attachment}', [BuildingController::class, 'deleteDocument'])->name('buildings.documents.destroy');

        Route::post('buildings/{building}/images', [BuildingController::class, 'storeImages'])->name('buildings.images.store');

        Route::post('buildings/{building}/certificates', [App\Http\Controllers\Hub\CertificateController::class, 'store'])->name('certificates.store');
        Route::get('certificates/{certificate}/download', [App\Http\Controllers\Hub\CertificateController::class, 'download'])->name('certificates.download');

        Route::get('/billing', BillingController::class)->name('billing');

        Route::get('/orders/create/{category}', [\App\Http\Controllers\Hub\OrderController::class, 'create'])->name(
            'orders.create'
        );
        Route::post('/orders/create/{category}', [\App\Http\Controllers\Hub\OrderController::class, 'store'])->name(
            'orders.store'
        );
        Route::delete('/orders/{order:slug}', [\App\Http\Controllers\Hub\OrderController::class, 'destroy'])->name(
            'orders.destroy'
        );

        Route::get('/orders/{order:slug}/certificate', [\App\Http\Controllers\Hub\CertificateController::class, 'show']
        )->name('certificates.show');

        Route::put(
            '/orders/{order:slug}/certificate',
            [\App\Http\Controllers\Hub\CertificateController::class, 'update']
        )->name('certificates.update');

        Route::post(
            '/orders/{order:slug}/certificate/picture',
            [\App\Http\Controllers\Hub\CertificateController::class, 'picture']
        )->name('certificates.picture');
        Route::delete(
            '/orders/{order:slug}/certificate/picture',
            [\App\Http\Controllers\Hub\CertificateController::class, 'deletePicture']
        )->name('certificates.picture.delete');


        Route::post('/orders/{order:slug}/send', [\App\Http\Controllers\Hub\CertificateController::class, 'send']
        )->name('certificates.send');

        Route::get('/orders', [\App\Http\Controllers\Hub\OrderController::class, 'index'])->name('certificates');

        Route::get('/admin', [\App\Http\Controllers\Hub\Admin\ShowController::class, 'index'])->name('admin');

        Route::get('/admin/blog', [\App\Http\Controllers\Hub\Admin\ShowController::class, 'blog'])->name('admin.blog');
    });
});
