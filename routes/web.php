<?php

use App\Http\Controllers\App\Contact;
use App\Http\Controllers\App\Continent;
use App\Http\Controllers\App\Country;
use App\Http\Controllers\App\Institute;
use App\Http\Controllers\App\InstituteType;
use App\Http\Controllers\App\InstituteUnit;
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

    // Partner routes
    Route::prefix('partner')->group(function () {
        Route::get('/', function () {
            return redirect('/app/dashboard');
        });

        // Institute routes
        Route::get('/institutions', [Institute::class, 'index'])->name('institutions');
        Route::prefix('institution')->group(function () {
            Route::get('/', function () {
                return redirect('/app/institutions');
            });
            Route::get('/data', [Institute::class, 'data'])->name('institution.data');
            Route::post('/store', [Institute::class, 'store'])->name('institution.store');
            Route::post('/update', [Institute::class, 'update'])->name('institution.update');
            Route::post('/delete', [Institute::class, 'delete'])->name('institution.delete');
        });

        // Unit routes
        Route::get('/units', [InstituteUnit::class, 'index'])->name('units');
        Route::prefix('unit')->group(function () {
            Route::get('/', function () {
                return redirect('/app/units');
            });
            Route::get('/data', [InstituteUnit::class, 'data'])->name('unit.data');
            Route::post('/store', [InstituteUnit::class, 'store'])->name('unit.store');
            Route::post('/update', [InstituteUnit::class, 'update'])->name('unit.update');
            Route::post('/delete', [InstituteUnit::class, 'delete'])->name('unit.delete');
        });
    });

    // Contact routes
    Route::get('/contacts', [Contact::class, 'index'])->name('contacts');
    Route::prefix('contact')->group(function () {
        Route::get('/', function () {
            return redirect('/app/contacts');
        });
        Route::get('/data', [Contact::class, 'data'])->name('contact.data');
        Route::post('/store', [Contact::class, 'store'])->name('contact.store');
        Route::post('/update', [Contact::class, 'update'])->name('contact.update');
        Route::post('/delete', [Contact::class, 'delete'])->name('contact.delete');
    });

    // Area routes
    Route::prefix('area')->group(function () {
        Route::get('/', function () {
            return redirect('/app/dashboard');
        });

        // continent routes
        Route::get('/continents', [Continent::class, 'index'])->name('continents');
        Route::prefix('continent')->group(function () {
            Route::get('/', function () {
                return redirect('/app/continents');
            });
            Route::get('/data', [Continent::class, 'data'])->name('continent.data');
            Route::post('/store', [Continent::class, 'store'])->name('continent.store');
            Route::post('/update', [Continent::class, 'update'])->name('continent.update');
            Route::post('/delete', [Continent::class, 'delete'])->name('continent.delete');
        });

        // country routes
        Route::get('/countries', [Country::class, 'index'])->name('countries');
        Route::prefix('country')->group(function () {
            Route::get('/', function () {
                return redirect('/app/countries');
            });
            Route::get('/data', [Country::class, 'data'])->name('country.data');
            Route::post('/store', [Country::class, 'store'])->name('country.store');
            Route::post('/update', [Country::class, 'update'])->name('country.update');
            Route::post('/delete', [Country::class, 'delete'])->name('country.delete');
        });
    });

    // Miscellaneous routes
    Route::prefix('miscellaneous')->group(function () {
        Route::get('/', function () {
            return redirect('/app/dashboard');
        });

        // instituteType routes
        Route::prefix('insitute')->group(function () {
            Route::get('/', function () {
                return redirect('/app/partner/institutions');
            });

            Route::get('/types', [InstituteType::class, 'index'])->name('instituteTypes');
            Route::prefix('type')->group(function () {
                Route::get('/', function () {
                    return redirect('/app/miscellaneous/insitute/types');
                });
                Route::get('/data', [InstituteType::class, 'data'])->name('instituteType.data');
                Route::post('/store', [InstituteType::class, 'store'])->name('instituteType.store');
                Route::post('/update', [InstituteType::class, 'update'])->name('instituteType.update');
                Route::post('/delete', [InstituteType::class, 'delete'])->name('instituteType.delete');
            });
        });
    });
});
