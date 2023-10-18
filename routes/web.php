<?php

use App\Http\Controllers\Bdrf\CellarController;
use App\Http\Controllers\Bdrf\HeatingController;
use App\Http\Controllers\Bdrf\PositionController;
use App\Http\Controllers\Bdrf\RenewableController;
use App\Http\Controllers\Bdrf\RoofController;
use App\Http\Controllers\Bdrf\WallController;
use App\Http\Controllers\Blog\SubscriptionController;
use App\Http\Controllers\Building\AttachmentController;
use App\Http\Controllers\Building\CalculatorController;
use App\Http\Controllers\Building\ConsumptionController;
use App\Http\Controllers\Building\EnergyController;
use App\Http\Controllers\Building\GeneralController;
use App\Http\Controllers\Building\ProductController;
use App\Http\Controllers\Building\ThermalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Hub\BuildingController;
use App\Http\Controllers\Hub\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Product\AppraisalController;
use App\Http\Controllers\Product\BzaController;
use App\Http\Controllers\Product\EnergyCertificateController;
use App\Http\Controllers\Product\IsfpController;
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


Route::get('/impressum', function () {
    return Inertia::render('Imprint');
})->name('impressum');

Route::get('/datenschutz', function () {
    return Inertia::render('PrivacyPolicy');
})->name('datenschutz');


Route::post('/newsletter', [SubscriptionController::class, 'store'])
    ->name('newsletter.store');

Route::post('/business', [SubscriptionController::class, 'storeBusiness'])
    ->name('business.store');

Route::get('/about', function () {
    return Inertia::render('About/About');
})->name('about');

Route::get('/energie-hub', function () {
    return Inertia::render('Feature/EnergieHub');
})->name('energiehub');

Route::get('/business', function () {
    return Inertia::render('Feature/BusinessPartnerProgram');
})->name('business-partner');

Route::prefix('/contact')->name('contact.')->group(function () {
    Route::get('', [ContactController::class, 'index'])
        ->name('show');

    Route::post('', [ContactController::class, 'store'])
        ->name('store');
});

Route::get('/', LandingController::class)->name('start');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('/hub')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Buildings
    Route::get('/buildings/create', [BuildingController::class, 'create'])
        ->name('buildings.create');

    Route::get('/buildings', [BuildingController::class, 'index'])
        ->name('buildings.index');

    Route::post('/buildings', [BuildingController::class, 'store'])
        ->name('buildings.store');

    Route::get('/buildings/{building}', [BuildingController::class, 'show'])
        ->name('buildings.show');

    Route::put('/buildings/{building}', [BuildingController::class, 'update'])
        ->name('buildings.update');

    Route::delete('/buildings/{building}', [BuildingController::class, 'destroy'])
        ->name('buildings.destroy');

    // Subpages
    Route::get('/buildings/{building}/general', [GeneralController::class, 'show'])
        ->name('buildings.general.show');

    Route::get('/buildings/{building}/thermal', [ThermalController::class, 'show'])
        ->name('buildings.thermal.show');

    Route::get('/buildings/{building}/position', [PositionController::class, 'show'])
        ->name('buildings.position.show');

    Route::get('/buildings/{building}/energy', [EnergyController::class, 'show'])
        ->name('buildings.energy.show');

    Route::get('/buildings/{building}/consumption', [ConsumptionController::class, 'show'])
        ->name('buildings.consumption.show');

    Route::get('/buildings/{building}/attachments', [AttachmentController::class, 'show'])
        ->name('buildings.attachments.show');

    Route::post('/buildings/{building}/attachments', [AttachmentController::class, 'store'])
        ->name('buildings.attachments.store');

    Route::delete('/buildings/{building}/documents/{attachment}', [AttachmentController::class, 'destroy'])
        ->name('buildings.attachments.destroy');

    Route::put('/buildings/{building}/roofs', RoofController::class)
        ->name('buildings.roofs.update');

    Route::post('/buildings/{building}/roofs/{roof}/insulations', [RoofController::class, 'storeInsulation'])
        ->name('buildings.roofs.insulations.store');

    Route::delete(
        '/buildings/{building}/roofs/{roof}/insulations/{insulation}',
        [RoofController::class, 'destroyInsulation']
    )
        ->name('buildings.roofs.insulations.destroy');

    Route::post('/buildings/{building}/roofs/{roof}/windows', [RoofController::class, 'storeWindow'])
        ->name('buildings.roofs.windows.store');

    Route::delete('/buildings/{building}/roofs/{roof}/windows/{window}', [RoofController::class, 'destroyWindow'])
        ->name('buildings.roofs.windows.destroy');

    Route::post('/buildings/{building}/roofs/{roof}/dormers', [RoofController::class, 'storeDormer'])
        ->name('buildings.roofs.dormers.store');

    Route::delete('/buildings/{building}/roofs/{roof}/dormers/{dormer}', [RoofController::class, 'destroyDormer'])
        ->name('buildings.roofs.dormers.destroy');

    Route::post('/buildings/{building}/walls', WallController::class)
        ->name('buildings.walls.store');

    Route::post('/buildings/{building}/walls/{wall}/insulations', [WallController::class, 'storeInsulation'])
        ->name('buildings.walls.insulations.store');

    Route::delete(
        '/buildings/{building}/walls/{wall}/insulations/{insulation}',
        [WallController::class, 'destroyInsulation']
    )
        ->name('buildings.walls.insulations.destroy');

    Route::post('/buildings/{building}/walls/{wall}/windows', [WallController::class, 'storeWindow'])
        ->name('buildings.walls.windows.store');

    Route::delete('/buildings/{building}/walls/{wall}/windows/{window}', [WallController::class, 'destroyWindow'])
        ->name('buildings.walls.windows.destroy');

    Route::put('/buildings/{building}/cellars', CellarController::class)
        ->name('buildings.cellars.update');

    Route::post('/buildings/{building}/cellars/{cellar}/insulations', [CellarController::class, 'storeInsulation'])
        ->name('buildings.cellars.insulations.store');

    Route::delete(
        '/buildings/{building}/cellars/{cellar}/insulations/{insulation}',
        [CellarController::class, 'destroyInsulation']
    )
        ->name('buildings.cellars.insulations.destroy');

    // heating system
    Route::post('/buildings/{building}/heating-systems', HeatingController::class)
        ->name('buildings.heating-systems.store');

    Route::delete('/buildings/{building}/heating-systems/{heatingSystem}', [HeatingController::class, 'destroy'])
        ->name('buildings.heating-systems.destroy');

    // renewable energy
    Route::post('/buildings/{building}/renewables', RenewableController::class)
        ->name('buildings.renewables.store');

    Route::delete('/buildings/{building}/renewables/{renewable}', [RenewableController::class, 'destroy'])
        ->name('buildings.renewables.destroy');

    // consumptions
    Route::post('/buildings/{building}/consumptions', [ConsumptionController::class, 'store'])
        ->name('buildings.consumptions.store');

    Route::delete('/buildings/{building}/consumptions/{consumption}', [ConsumptionController::class, 'destroy'])
        ->name('buildings.consumptions.destroy');

    // position
    Route::put('/buildings/{building}/maps', [PositionController::class, 'updateMaps'])
        ->name('buildings.maps.update');

    Route::put('/buildings/{building}/position', [PositionController::class, 'updatePosition'])
        ->name('buildings.position.update');

    // Building features
    Route::get('/buildings/{building}/calculator', [CalculatorController::class, 'show'])
        ->name('buildings.calculator.show');

    // Products
    Route::get('/buildings/{building}/products', [ProductController::class, 'index'])
        ->name('buildings.products.index');

    Route::get('/buildings/{building}/products/ecert', [EnergyCertificateController::class, 'show'])
        ->name('buildings.products.ecert.show');

    Route::post('/buildings/{building}/products/ecert', [EnergyCertificateController::class, 'store'])
        ->name('buildings.products.ecert.store');

    Route::get('/buildings/{building}/products/isfp', [IsfpController::class, 'show'])
        ->name('buildings.products.isfp.show');

    Route::post('/buildings/{building}/products/isfp', [IsfpController::class, 'store'])
        ->name('buildings.products.isfp.store');

    Route::get('/buildings/{building}/products/bza', [BzaController::class, 'show'])
        ->name('buildings.products.bza.show');

    Route::post('/buildings/{building}/products/bza', [BzaController::class, 'store'])
        ->name('buildings.products.bza.store');

    Route::get('/buildings/{building}/appraisal', [AppraisalController::class, 'show'])
        ->name('buildings.appraisal.show');
});
