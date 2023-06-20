<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\PenugasanKelasController;
use App\Http\Controllers\PenugasanMahasiswaController;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Ramsey\Uuid\v1;

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



Route::get("/unauthorized", function () {
    return view("pages.401");
})->name("unauthorized");

Route::middleware(['web:3,2,1',])->group(function () {
    Route::get('my-profile', function () {
        // if (auth()->check()) {
        return view('pages.my-profile');
        // }
        // return redirect('/login');
    });
});

Route::post("logout", [AuthController::class, "logoutWeb"])->name("logout")->middleware('web:1,2,3');


Route::get('/', [AuthController::class, "routeCheck"]);

Route::get('/login', [AuthController::class, "routeCheck"])->name('login');


Route::get('/register', function () {
    if (auth()->check()) {
        # code...1941720034@xyz.com
        return redirect()->back();
    }
    return view('auth.register');
});

Route::middleware('web:1,2')->group(function () {
    Route::prefix('dosen')->group(function () {
        # code...
        Route::get('/mahasiswa', function () {
            return view('pages.dosen.mahasiswa');
        });
    });
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('pages.dashboard');
        });
        Route::get('/dosen', function () {
            return view('pages.admin.dosen');
        });

        Route::get('/mahasiswa', function () {
            return view('pages.admin.mahasiswa');
        });

        Route::get('/mahasiswa/export', [MahasiswaController::class, 'exportMhs']);

        Route::get('/user', function () {
            return view('pages.admin.user');
        });

        Route::prefix('/penugasan')->group(function () {
            # code...
            Route::get('/', function () {
                return view('pages.admin.riwayat-penugasan');
            });

            Route::get('/{id}', [PenugasanController::class, 'show']);
            Route::get('/kelas/{id}', function () {
                return view('pages.admin.detail-penugasan-kelas');
            });
            Route::get('/mahasiswa/{id}', function () {
                return view('pages.admin.detail-penugasan-mahasiswa');
            });
        });

        Route::get('/kelas', function () {
            return view('pages.admin.kelas');
        });
    });
});

Route::middleware('web:2')->group(function () {
    Route::prefix('/dosen')->group(function () {
        Route::get('/kelas', function () {
            return view('pages.dosen.kelas');
        });
        # code...
    });
});


Route::middleware('web:3')->group(function () {
    Route::prefix('mahasiswa')->group(function () {

        Route::get('/', function () {
            return view('pages.mahasiswa.dashboard');
        });


        Route::prefix('penugasan')->group(function () {
            # code...
            Route::get('/', function () {
                return view('pages.mahasiswa.penugasan');
            });

            Route::get('/laporan', function () {
                return view('pages.mahasiswa.laporan-penugasan');
            });

            Route::get("/{id}", function () {
                return view('pages.mahasiswa.detail-penugasan');
            });
        });
    });
});
