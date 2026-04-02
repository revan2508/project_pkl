<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Guru\KelasController;
use App\Http\Controllers\Api\Guru\KelasMapelController;
use App\Http\Controllers\Api\Guru\MapelController;
use App\Http\Controllers\Api\Guru\TugasController;
use App\Http\Controllers\Api\Siswa\SiswaController;
use App\Http\Controllers\Api\Siswa\SiswaTugasController;
use App\Http\Controllers\Api\Siswa\SiswaProfilController;
use App\Http\Controllers\Api\Siswa\SiswaNotifikasiController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */
    Route::prefix('guru')->group(function () {

        // Kelas
        Route::get('/kelas', [KelasController::class, 'index']);
        Route::post('/kelas', [KelasController::class, 'store']);
        Route::get('/kelas/{id}', [KelasController::class, 'show']);
        Route::put('/kelas/{id}', [KelasController::class, 'update']);
        Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);

        // Mapel per kelas
        Route::get('/kelas/{id}/mapel', [KelasMapelController::class, 'index']);
        Route::post('/kelas/{id}/mapel', [KelasMapelController::class, 'store']);
        Route::put('/kelas/{id}/mapel', [KelasMapelController::class, 'update']);
        Route::delete('/kelas/{id}/mapel', [KelasMapelController::class, 'destroy']);

        // Mapel
        Route::get('/mapel', [MapelController::class, 'index']);
        Route::post('/mapel', [MapelController::class, 'store']);
        Route::get('/mapel/{id}', [MapelController::class, 'show']);
        Route::put('/mapel/{id}', [MapelController::class, 'update']);
        Route::delete('/mapel/{id}', [MapelController::class, 'destroy']);

        // Tugas
        Route::get('/kelas/{kelas}/tugas', [TugasController::class, 'index']);
        Route::post('/kelas/{kelas}/tugas', [TugasController::class, 'store']);
        Route::get('/tugas/{id}', [TugasController::class, 'show']);
        Route::put('/tugas/{id}', [TugasController::class, 'update']);
        Route::delete('/tugas/{id}', [TugasController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */
    Route::prefix('siswa')->group(function () {

        // Kelas
        Route::get('/kelas', [SiswaController::class, 'kelasSaya']);           // list kelas saya
        Route::get('/kelas/{id}', [SiswaController::class, 'detailKelas']);    // detail kelas + tugas
        Route::post('/join', [SiswaController::class, 'joinKelas']);            // join kelas
        Route::delete('/kelas/{id}/keluar', [SiswaController::class, 'keluarKelas']); // keluar kelas

        // Tugas
        Route::get('/kelas/{kelasId}/tugas', [SiswaTugasController::class, 'index']);         // tugas per kelas
        Route::get('/tugas-saya', [SiswaTugasController::class, 'tugasSaya']);                // semua tugas dari semua kelas
        Route::get('/tugas/{id}', [SiswaTugasController::class, 'show']);                     // detail 1 tugas
        Route::post('/tugas/{id}/submit', [SiswaTugasController::class, 'submit']);           // kumpulkan tugas
        Route::get('/tugas/{id}/submission', [SiswaTugasController::class, 'mySubmission']); // lihat submission saya

        // Profil
        Route::get('/profil', [SiswaProfilController::class, 'show']);
        Route::put('/profil', [SiswaProfilController::class, 'update']);

        // Notifikasi
        Route::get('/notifikasi', [SiswaNotifikasiController::class, 'index']);
        Route::put('/notifikasi/baca-semua', [SiswaNotifikasiController::class, 'tandaiSemuaDibaca']);
        Route::put('/notifikasi/{id}/baca', [SiswaNotifikasiController::class, 'tandaiDibaca']);
    });
});