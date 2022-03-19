<?php

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

        Route::get('/continents', [\App\Http\Controllers\App\Continent::class, 'index'])->name('continents');
        Route::prefix('continent')->group(function () {
            Route::get('/data', [\App\Http\Controllers\App\Continent::class, 'data'])->name('continent.data');
            Route::post('/store', [\App\Http\Controllers\App\Continent::class, 'store'])->name('continent.store');
            Route::post('/update', [\App\Http\Controllers\App\Continent::class, 'update'])->name('continent.update');
            Route::post('/delete', [\App\Http\Controllers\App\Continent::class, 'delete'])->name('continent.delete');
        });

        Route::get('/countries', [\App\Http\Controllers\App\Country::class, 'index'])->name('countries');
        Route::prefix('country')->group(function () {
            Route::get('/data', [\App\Http\Controllers\App\Country::class, 'data'])->name('country.data');
            Route::post('/store', [\App\Http\Controllers\App\Country::class, 'store'])->name('country.store');
            Route::post('/update', [\App\Http\Controllers\App\Country::class, 'update'])->name('country.update');
            Route::post('/delete', [\App\Http\Controllers\App\Country::class, 'delete'])->name('country.delete');
        });
    });
});
