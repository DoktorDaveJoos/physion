<?php

use App\Http\Controllers\Blog\SubscriptionsController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Checkout\AddUpsellController;
use App\Http\Controllers\Checkout\DeleteUpsellController;
use App\Http\Controllers\Checkout\PayPal;
use App\Http\Controllers\Checkout\ShowController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Find\SearchController;
use App\Http\Controllers\Order\DownloadController;
use App\Http\Controllers\OrderController;
use App\Models\BlogEntry;
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
 * GET      certificate/{category}/{certificate}
 * PUT      certificate/{category}/{certificate}
 * GET      certificate/{category}/{certificate}/{page}
 *
 * eg:      certificate/bdrf/41nX7umHQ/general
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


Route::prefix('orders')->group(function () {
    Route::get('/{order}', [OrderController::class, 'show'])->name('order.show');

    Route::get('/create/{category}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/create/{category}', [OrderController::class, 'store'])->name('order.store');
});


Route::prefix('certificate')->group(function () {
    Route::get('/{category}/{id}', [CertificateController::class, 'show'])->name('certificate.show');
});

//
//Route::prefix('verbrauchsausweis')
//    ->name('verbrauch.')
//    ->group(function () {
//        Route::get('erstellen', [Verbrauch\ShowController::class, 'index'])->name('show.index');
//        Route::post('erstellen', Verbrauch\CreateController::class)->name('create');
//
//        Route::prefix('{order}')->group(function () {
//            // General
//            Route::get('allgemein', [Verbrauch\ShowController::class, 'general'])->name('general');
//            Route::put('allgemein', Verbrauch\UpdateGeneralController::class)->name('general.update');
//
//            // Details
//            Route::get('details', [Verbrauch\ShowController::class, 'details'])->name('details');
//            Route::put('details', Verbrauch\CreateOrUpdateDetailsController::class)->name('details.update');
//
//            // Consumption
//            Route::get('verbrauch', [Verbrauch\ShowController::class, 'consumption'])->name('consumption');
//            Route::put('verbrauch', Verbrauch\MarkDoneConsumptionController::class)->name('consumption.done');
//
//            // Energy source
//            Route::put('source', Verbrauch\CreateOrUpdateSourceController::class)->name('consumption.source.update');
//            Route::delete('source/{source}', Verbrauch\DeleteSourceController::class)->name(
//                'consumption.source.delete'
//            );
//
//            // Consumption Periods
//            Route::post('source/{source}/period', Verbrauch\CreateConsumptionPeriodController::class)->name(
//                'consumption.period.create'
//            );
//            Route::delete('source/{source}/period/{period}', Verbrauch\DeletePeriodController::class)->name(
//                'consumption.period.delete'
//            );
//
//            // Vacancies
//            Route::post('vacancy', Verbrauch\CreateVacancyController::class)->name('consumption.vacancy.create');
//            Route::delete('vacancy/{vacancy}', Verbrauch\DeleteVacancyController::class)->name(
//                'consumption.vacancy.delete'
//            );
//
//            // Summary
//            Route::get('zusammenfassung', [Verbrauch\ShowController::class, 'summary'])->name('summary');
//        });
//    });
//
//Route::prefix('bedarfsausweis')
//    ->name('bedarf.')
//    ->group(function () {
//        Route::get('erstellen', Bedarf\ShowIndexController::class)->name('show.index');
//        Route::post('erstellen', Bedarf\CreateController::class)->name('create');
//
//        Route::prefix('{order}')->group(function () {
//            Route::get('allgemein', [Bedarf\ShowController::class, 'index'])->name('general');
//            Route::put('allgemein', Bedarf\GeneralController::class)->name('general.update');
//
//            // Details
//            Route::get('details', [Bedarf\ShowController::class, 'details'])->name('details');
//            Route::put('details', Bedarf\DetailsController::class)->name('details.update');
//
//            // Position
//            Route::get('position', [Bedarf\ShowController::class, 'position'])->name('position');
//            Route::put('position', [Bedarf\PositionController::class, 'update'])->name('position.update');
//            Route::put('position/maps', [Bedarf\PositionController::class, 'setMaps'])->name('position.maps.update');
//
//            // Insulation
//            Route::put('insulation', [Bedarf\RoofController::class, 'addInsulation'])->name('insulation.update');
//            Route::delete('insulation/{insulation}', [Bedarf\RoofController::class, 'deleteInsulation'])->name(
//                'insulation.delete'
//            );
//
////            Route::get('keller', [BedarfController::class, 'cellar'])->name('cellar');
//            Route::get('therm', [Bedarf\ShowController::class, 'wall'])->name('wall');
//
//            Route::put('wand', Bedarf\WallController::class)->name('wall.update');
////            Route::get('fenster', [BedarfController::class, 'window'])->name('window');
//            Route::put('dach', [Bedarf\RoofController::class, 'update'])->name('roof.update');
//
//            // Handle roof related requests
//            Route::put('fenster', [Bedarf\WindowController::class, 'store'])->name('skylight.update');
//            Route::delete('dachfenster/{skylight}', [Bedarf\RoofController::class, 'deleteSkylight'])->name(
//                'skylight.delete'
//            );
//            Route::put('gaube', [Bedarf\RoofController::class, 'addDormer'])->name('dormer.update');
//            Route::delete('dormer/{dormer}', [Bedarf\RoofController::class, 'deleteDormer'])->name('dormer.delete');
//        });
//    });


//Route::post('roof/{roof}/windows', [Roof\Controller::class, 'windows'])->name('roof.window.store');
//Route::post('roof/{roof}/dormers', [Roof\Controller::class, 'dormer'])->name('roof.dormer.store');
//Route::post('roof/{roof}/insulations', [Roof\Controller::class, 'addInsulation'])->name('roof.insulation.store');
//
//Route::post('wall/{wall}/windows', [Bedarf\WindowController::class, 'store'])->name('wall.window.store');


Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::prefix('{order}')->group(function () {
        Route::get('/', [ShowController::class, 'index'])->name('show');
        Route::post('upsell/{upsell}', AddUpsellController::class)->name('upsell.add');
        Route::delete('upsell/{upsell}', DeleteUpsellController::class)->name('upsell.delete');

        Route::post('paypal', PayPal\CaptureOrderController::class)->name('paypal.capture');

        Route::get('danke', [ShowController::class, 'thankyou'])->name('thankyou');
    });
});

Route::prefix('order')->name('order.')->group(function () {
    Route::prefix('{order}')->group(function () {
        Route::get('', [\App\Http\Controllers\Order\ShowController::class, 'index'])->name('show');
        Route::get('download', DownloadController::class)->name('download');
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
    Route::get('/', [\App\Http\Controllers\Find\ShowController::class, 'index'])->name('show');

    Route::post('/email', [SearchController::class, 'email'])->name('email');
});

Route::get('/', function () {
    return Inertia::render('Landing', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'posts' => BlogEntry::latest()->take(3)->get(),
    ]);
})->name('start');

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
