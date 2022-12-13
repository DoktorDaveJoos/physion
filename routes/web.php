<?php

use App\Http\Controllers\BedarfController;
use Illuminate\Foundation\Application;
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

Route::prefix('energieausweis')
    ->group(function () {

        Route::prefix('bedarf')->group(function() {

            Route::get('allgemein', [BedarfController::class, 'index'])->name('bedarf.index');
            Route::get('keller', [BedarfController::class, 'cellar'])->name('bedarf.cellar');
            Route::get('wand', [BedarfController::class, 'wall'])->name('bedarf.wall');
            Route::get('fenster', [BedarfController::class, 'window'])->name('bedarf.window');
            Route::get('dach', [BedarfController::class, 'roof'])->name('bedarf.roof');

        });

    });

Route::get('/', function () {
    return Inertia::render('Welcome', [
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
