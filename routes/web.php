<?php

use App\Http\Controllers\Bedarf;
use App\Http\Controllers\Checkout\AddUpsellController;
use App\Http\Controllers\Checkout\DeleteUpsellController;
use App\Http\Controllers\Checkout\ShowController;
use App\Http\Controllers\Verbrauch;
use App\Http\Controllers\Checkout\PayPal;
use App\Http\Controllers\BedarfController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

Route::prefix('verbrauchsausweis')
    ->name('verbrauch.')
    ->group(function () {
        Route::get('erstellen', [Verbrauch\ShowController::class, 'index'])->name('show.index');
        Route::post('erstellen', Verbrauch\CreateController::class)->name('create');

        Route::prefix('{order}')->group(function () {
            // General
            Route::get('allgemein', [Verbrauch\ShowController::class, 'general'])->name('general');
            Route::put('allgemein', Verbrauch\UpdateGeneralController::class)->name('general.update');

            // Details
            Route::get('details', [Verbrauch\ShowController::class, 'details'])->name('details');
            Route::put('details', Verbrauch\CreateOrUpdateDetailsController::class)->name('details.update');

            // Consumption
            Route::get('verbrauch', [Verbrauch\ShowController::class, 'consumption'])->name('consumption');
            Route::put('verbrauch', Verbrauch\MarkDoneConsumptionController::class)->name('consumption.done');

            // Energy source
            Route::put('source', Verbrauch\CreateOrUpdateSourceController::class)->name('consumption.source.update');
            Route::delete('source/{source}', Verbrauch\DeleteSourceController::class)->name(
                'consumption.source.delete'
            );

            // Consumption Periods
            Route::post('source/{source}/period', Verbrauch\CreateConsumptionPeriodController::class)->name(
                'consumption.period.create'
            );
            Route::delete('source/{source}/period/{period}', Verbrauch\DeletePeriodController::class)->name(
                'consumption.period.delete'
            );

            // Vacancies
            Route::post('vacancy', Verbrauch\CreateVacancyController::class)->name('consumption.vacancy.create');
            Route::delete('vacancy/{vacancy}', Verbrauch\DeleteVacancyController::class)->name(
                'consumption.vacancy.delete'
            );

            // Summary
            Route::get('zusammenfassung', [Verbrauch\ShowController::class, 'summary'])->name('summary');
        });
    });

Route::prefix('bedarfsausweis')
    ->name('bedarf.')
    ->group(function () {
        Route::get('erstellen', Bedarf\ShowIndexController::class)->name('show.index');
        Route::post('erstellen', Bedarf\CreateController::class)->name('create');

        Route::prefix('{order}')->group(function () {
            Route::get('allgemein', Bedarf\ShowController::class)->name('general');
            Route::get('keller', [BedarfController::class, 'cellar'])->name('cellar');
            Route::get('wand', [BedarfController::class, 'wall'])->name('wall');
            Route::get('fenster', [BedarfController::class, 'window'])->name('window');
            Route::get('dach', [BedarfController::class, 'roof'])->name('roof');
        });
    });

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
        Route::get('download', \App\Http\Controllers\Order\DownloadController::class)->name('download');
    });
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('', [\App\Http\Controllers\Blog\ShowController::class, 'index'])->name('show');
    Route::get('{post}', [\App\Http\Controllers\Blog\ShowController::class, 'show'])->name('show.post');

    Route::post('subscribe', [\App\Http\Controllers\Blog\SubscriptionsController::class, 'store'])->name('subscribe');
});

Route::get('/', function () {
    return Inertia::render('Landing', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('start');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
