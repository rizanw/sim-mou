<?php

use App\Http\Controllers\App\Contact;
use App\Http\Controllers\App\Continent;
use App\Http\Controllers\App\Country;
use App\Http\Controllers\App\Dashboard;
use App\Http\Controllers\App\Document;
use App\Http\Controllers\App\DocumentType;
use App\Http\Controllers\App\InstitutionType;
use App\Http\Controllers\App\Internal;
use App\Http\Controllers\App\InternalUnit;
use App\Http\Controllers\App\Partner;
use App\Http\Controllers\App\PartnerUnit;
use App\Http\Controllers\App\Program;
use App\Http\Controllers\Chart\DocumentChart;
use App\Http\Controllers\Chart\PartnerChart;
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
})->name('landingpage');

Auth::routes();

Route::get('/redirection', function () {
    if (Auth::check()) {
        return redirect()->route('app');
    }
    return redirect()->route('landingpage');
})->name('404.redirection');

// Chart data
Route::prefix('chart')->group(function () {
    // document chart data
    Route::prefix('document')->group(function () {
        Route::get('/continent', [DocumentChart::class, 'byContinent'])->name('chart.document.byContinent');
    });

    // partner chart data
    Route::prefix('partner')->group(function () {
        Route::get('/continent', [PartnerChart::class, 'byContinent'])->name('chart.partner.byContinent');
        Route::get('/country', [PartnerChart::class, 'byCountry'])->name('chart.partner.byCountry');
    });
});


Route::prefix('app')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/app/dashboard');
    })->name('app');

    // Dashboard routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

        // stats
        Route::get('/count-document-by-type/$id', [Dashboard::class, 'countDocumentByType'])->name('stats.countDocumentByType');
    });

    // Document routes
    Route::get('/documents', [Document::class, 'index'])->name('documents');
    Route::prefix('document')->group(function () {
        Route::get('/', function () {
            return redirect('/app/documents');
        });
        Route::get('/data', [Document::class, 'data'])->name('document.data');
        Route::post('/delete', [Document::class, 'delete'])->name('document.delete');

        Route::get('/create', [Document::class, 'createView'])->name('document.create');
        Route::post('/store', [Document::class, 'store'])->name('document.store');

        Route::get('/{id}/edit', [Document::class, 'editView'])->name('document.edit');
        Route::post('/update', [Document::class, 'update'])->name('document.update');

        Route::get('/{id}', [Document::class, 'detailView'])->name('document.detail');
        Route::get('/{id}/download', [Document::class, 'download'])->name('document.download');
        Route::get('/{id}/predecessors', [Document::class, 'predecessorData'])->name('document.predecessor.data');
    });

    // Partner routes
    Route::prefix('partner')->group(function () {
        Route::get('/', function () {
            return redirect('/app/partner/institutions');
        });

        // Institute routes
        Route::get('/institutions', [Partner::class, 'index'])->name('institutions');
        Route::prefix('institution')->group(function () {
            Route::get('/', function () {
                return redirect('/app/institutions');
            });
            Route::get('/data', [Partner::class, 'data'])->name('institution.data');
            Route::post('/store', [Partner::class, 'store'])->name('institution.store');
            Route::post('/update', [Partner::class, 'update'])->name('institution.update');
            Route::post('/delete', [Partner::class, 'delete'])->name('institution.delete');

            // Unit routes
            Route::get('/{id}/units', [PartnerUnit::class, 'index'])->name('units');
            Route::get('/{id}/unit/data', [PartnerUnit::class, 'data'])->name('unit.data');
            Route::prefix('unit')->group(function () {
                Route::get('/', function () {
                    return redirect('/app/partner/institutions');
                });
                Route::post('/store', [PartnerUnit::class, 'store'])->name('unit.store');
                Route::post('/update', [PartnerUnit::class, 'update'])->name('unit.update');
                Route::post('/delete', [PartnerUnit::class, 'delete'])->name('unit.delete');
            });
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

    // Program routes
    Route::get('/programs', [Program::class, 'index'])->name('programs');
    Route::prefix('program')->group(function () {
        Route::get('/', function () {
            return redirect('/app/programs');
        });
        Route::get('/data', [Program::class, 'data'])->name('program.data');
        Route::post('/store', [Program::class, 'store'])->name('program.store');
        Route::post('/update', [Program::class, 'update'])->name('program.update');
        Route::post('/delete', [Program::class, 'delete'])->name('program.delete');
    });

    // Internal Institution routes
    Route::prefix('internal')->group(function () {
        Route::get('/', function () {
            return redirect('/app/internal/institution');
        });
        Route::prefix('institution')->group(function () {
            Route::get('/', [Internal::class, 'index'])->name('internal.institution');
            Route::get('/edit', [Internal::class, 'editView'])->name('internal.institution.edit');
            Route::post('/update', [Internal::class, 'update'])->name('internal.institution.update');
        });

        // internal units routes
        Route::get('/units', [InternalUnit::class, 'index'])->name('internal.units');
        Route::prefix('unit')->group(function () {
            Route::get('/data', [InternalUnit::class, 'data'])->name('internal.unit.data');
            Route::post('/store', [InternalUnit::class, 'store'])->name('internal.unit.store');
            Route::post('/update', [InternalUnit::class, 'update'])->name('internal.unit.update');
            Route::post('/delete', [InternalUnit::class, 'delete'])->name('internal.unit.delete');
        });
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

        // institutionTypes routes
        Route::prefix('institution')->group(function () {
            Route::get('/', function () {
                return redirect('/app/partner/institutions');
            });

            Route::get('/types', [InstitutionType::class, 'index'])->name('institutionTypes');
            Route::prefix('type')->group(function () {
                Route::get('/', function () {
                    return redirect('/app/miscellaneous/institution/types');
                });
                Route::get('/data', [InstitutionType::class, 'data'])->name('institutionType.data');
                Route::post('/store', [InstitutionType::class, 'store'])->name('institutionType.store');
                Route::post('/update', [InstitutionType::class, 'update'])->name('institutionType.update');
                Route::post('/delete', [InstitutionType::class, 'delete'])->name('institutionType.delete');
            });
        });

        // DocumentType routes
        Route::prefix('document')->group(function () {
            Route::get('/', function () {
                return redirect('/app/documents');
            });

            Route::get('/types', [DocumentType::class, 'index'])->name('documentTypes');
            Route::prefix('type')->group(function () {
                Route::get('/', function () {
                    return redirect('/app/miscellaneous/document/types');
                });
                Route::get('/data', [DocumentType::class, 'data'])->name('documentType.data');
                Route::post('/store', [DocumentType::class, 'store'])->name('documentType.store');
                Route::post('/update', [DocumentType::class, 'update'])->name('documentType.update');
                Route::post('/delete', [DocumentType::class, 'delete'])->name('documentType.delete');
            });
        });
    });
});
