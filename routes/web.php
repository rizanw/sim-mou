<?php

use App\Http\Controllers\App\Continent;
use App\Http\Controllers\App\Country;
use App\Http\Controllers\App\InstituteType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('app')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/app/dashboard');
    });
    Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // Area routes
    Route::prefix('area')->group(function () {
        Route::get('/', function () {
            return redirect('/app/dashboard');
        });

        Route::get('/continents', [Continent::class, 'index'])->name('continents');
        Route::prefix('continent')->group(function () {
            Route::get('/data', [Continent::class, 'data'])->name('continent.data');
            Route::post('/store', [Continent::class, 'store'])->name('continent.store');
            Route::post('/update', [Continent::class, 'update'])->name('continent.update');
            Route::post('/delete', [Continent::class, 'delete'])->name('continent.delete');
        });

        Route::get('/countries', [Country::class, 'index'])->name('countries');
        Route::prefix('country')->group(function () {
            Route::get('/data', [Country::class, 'data'])->name('country.data');
            Route::post('/store', [Country::class, 'store'])->name('country.store');
            Route::post('/update', [Country::class, 'update'])->name('country.update');
            Route::post('/delete', [Country::class, 'delete'])->name('country.delete');
        });
    });

    // Miscellaneous routes
    Route::prefix('miscellaneous')->group(function () {
        // instituteType routes
        Route::prefix('insitute')->group(function () {
            Route::get('/types', [InstituteType::class, 'index'])->name('instituteTypes');
            Route::prefix('type')->group(function () {
                Route::get('/data', [InstituteType::class, 'data'])->name('instituteType.data');
                Route::post('/store', [InstituteType::class, 'store'])->name('instituteType.store');
                Route::post('/update', [InstituteType::class, 'update'])->name('instituteType.update');
                Route::post('/delete', [InstituteType::class, 'delete'])->name('instituteType.delete');
            });
        });
    });
});
