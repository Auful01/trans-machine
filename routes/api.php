<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\PenugasanKelasController;
use App\Http\Controllers\PenugasanMahasiswaController;
use App\Http\Controllers\PenugasanMahasiswaJawabanController;
use App\Http\Controllers\UserController;
use App\Models\Penugasan;
use App\Models\PenugasanKelas;
use App\Models\PenugasanMahasiswa;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get("profile", [AuthController::class, 'profile'])->middleware("jwt:1,2,3");


Route::prefix('dosen')->group(function () {
    Route::get('/', [DosenController::class, 'index']);
    Route::get('/{id}', [DosenController::class, 'show']);
    Route::post('/', [DosenController::class, 'store']);
    Route::put('/{id}', [DosenController::class, 'update']);
    Route::delete('/{id}', [DosenController::class, 'destroy']);
});

Route::middleware('jwt:3')->group(function () {
    Route::prefix('mahasiswa')->group(function () {
        Route::get("/dashboard", [MahasiswaController::class, 'DashboardMhs']);

        Route::prefix('penugasan')->group(function () {
            Route::post('/submit/{id}', [PenugasanMahasiswaJawabanController::class, 'submit']);
            Route::post('/submit-all', [PenugasanMahasiswaJawabanController::class, 'submitAll']);
            Route::get('/', [PenugasanMahasiswaController::class, 'myTugas']);
            Route::get('/laporan', [PenugasanMahasiswaController::class, 'getLaporan']);
            Route::get('/{id}', [PenugasanController::class, 'doNow']);
        });
    });
});

Route::middleware('jwt:1,2')->group(function () {
    Route::prefix('mahasiswa')->group(function () {
        Route::post('/import', [UserController::class, 'importUser']);
        Route::get('/', [MahasiswaController::class, 'index']);
        Route::get('/kelas/{id}', [MahasiswaController::class, 'getByKelas']);
        Route::get('/{id}', [MahasiswaController::class, 'show']);
        Route::post('/', [MahasiswaController::class, 'store']);
        Route::put('/{id}', [MahasiswaController::class, 'update']);
        Route::delete('/{id}', [MahasiswaController::class, 'destroy']);
    });
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'index']);
    Route::get('/my', [KelasController::class, 'myKelas']);
    Route::get('/{id}', [KelasController::class, 'show']);
    Route::post('/', [KelasController::class, 'store']);
    Route::post('/{id}', [KelasController::class, 'update']);
    Route::delete('/{id}', [KelasController::class, 'delete']);
});


Route::prefix('penugasan')->middleware('jwt:1,2,3')->group(function () {
    Route::post('/assign', [PenugasanMahasiswaController::class, 'store']);
    Route::get('/assign', [PenugasanMahasiswaController::class, 'index']);
    Route::get('/kelas', [PenugasanKelasController::class, 'index']);
    Route::post('/kelas', [PenugasanKelasController::class, 'store']);
    Route::post('/review', [PenugasanMahasiswaJawabanController::class, 'review']);
    Route::post('/review-all', [PenugasanMahasiswaJawabanController::class, 'reviewAll']);
    Route::get('/kelas/{id}', [PenugasanKelasController::class, 'show']);
    Route::get('/mahasiswa/detail/{id}', [PenugasanMahasiswaController::class, 'show']);
    Route::get('/', [PenugasanController::class, 'index']);
    Route::get('/detail/{id}', [PenugasanController::class, 'penugasanDetail']);
    Route::get('/{id}', [PenugasanController::class, 'show']);
    Route::post('/', [PenugasanController::class, 'store']);
    Route::post('/{id}', [PenugasanController::class, 'update']);
    Route::delete('/{id}', [PenugasanController::class, 'destroy']);
});
