<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\BackendController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\SiswaKelasController;

// Backend Controllers
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DashboardController;

// Guru Controllers
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\Guru\MapelController;
use App\Http\Controllers\Guru\KelasController;
use App\Http\Controllers\Guru\KelasMapelController;

// Siswa Controllers
use App\Http\Controllers\Siswa\TugasController as SiswaTugasController;
use App\Http\Controllers\Siswa\ProfileSiswaController;

// Join Kelas
use App\Http\Controllers\JoinKelasController;

// Auth
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;

// Middleware
use App\Http\Middleware\Admin;
use App\Http\Middleware\Guru;
use App\Http\Middleware\Siswa;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'index']);
Route::get('/join', fn() => view('join'))->name('join');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest'])
    ->name('login');

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'admin',
    'as' => 'backend.',
    'middleware' => ['auth', Admin::class]
], function () {
    Route::get('/', [BackendController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('dashboard', DashboardController::class);
});

/*
|--------------------------------------------------------------------------
| Guru Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'guru',
    'as' => 'guru.',
    'middleware' => ['auth', Guru::class]
], function () {

    Route::get('/', [GuruController::class, 'index'])->name('dashboard');

    Route::resource('mapel', MapelController::class);

    // ===== KELAS ROUTES =====
    Route::get('kelas', [KelasController::class, 'index'])
        ->name('kelas.index');

    Route::get('kelas/create', [KelasController::class, 'create'])
        ->name('kelas.create');

    Route::post('kelas', [KelasController::class, 'store'])
        ->name('kelas.store');

    Route::get('kelas/{kelas}/edit', [KelasController::class, 'edit'])
        ->name('kelas.edit');

    Route::put('kelas/{kelas}', [KelasController::class, 'update'])
        ->name('kelas.update');

    Route::delete('kelas/{kelas}', [KelasController::class, 'destroy'])
        ->name('kelas.destroy');

    Route::get('kelas/{kelas}/mapel/create', [KelasMapelController::class, 'create'])
    ->name('kelas.mapel.create');

    Route::post('kelas/{kelas}/mapel', [KelasMapelController::class, 'store'])
        ->name('kelas.mapel.store');


    // ===== TUGAS PER KELAS =====
    Route::get('kelas/{kelas}/tugas', [TugasController::class, 'index'])
        ->name('tugas.index');

    Route::get('kelas/{kelas}/tugas/create', [TugasController::class, 'create'])
        ->name('tugas.create');

    Route::post('kelas/{kelas}/tugas', [TugasController::class, 'store'])
        ->name('tugas.store');

    Route::get('tugas', [TugasController::class, 'pilihKelas'])
        ->name('tugas.pilihKelas');

    Route::get('tugas/{tugas}/edit', [TugasController::class, 'edit'])
        ->name('tugas.edit');

    Route::put('tugas/{tugas}', [TugasController::class, 'update'])
        ->name('tugas.update');

    Route::delete('tugas/{tugas}', [TugasController::class, 'destroy'])
        ->name('tugas.destroy');

    Route::get('tugas/{tugas}/pengumpulan', [TugasController::class,'lihatPengumpulan'])
        ->name('tugas.pengumpulan');

    Route::put('tugas/pengumpulan/{pengumpulan}/nilai', [TugasController::class,'beriNilai'])
        ->name('tugas.nilai');
});

/*
|--------------------------------------------------------------------------
| Siswa Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'siswa',
    'as' => 'siswa.',
    'middleware' => ['auth', Siswa::class]
], function () {
    // Dashboard
    Route::get('/', [SiswaKelasController::class, 'index'])->name('index');

    // Kelas Management
    Route::get('kelas/join', [SiswaKelasController::class, 'showFormJoin'])->name('kelas.join');
    Route::post('kelas/join', [SiswaKelasController::class, 'prosesJoin'])->name('kelas.join.proses');
    Route::get('kelas/{id}', [SiswaKelasController::class, 'show'])->name('kelas.show');
    Route::delete('kelas/{kelas}/keluar', [SiswaKelasController::class, 'keluar'])->name('kelas.keluar');

    // Tugas Management
    Route::get('tugas/{id}', [SiswaTugasController::class, 'show'])->name('tugas.show');
    Route::post('tugas/{id}/kumpulkan', [SiswaTugasController::class, 'kumpulkan'])->name('tugas.kumpulkan');
    Route::get('tugas/edit/{id}', [SiswaTugasController::class, 'editPengumpulan'])->name('tugas.edit');
    Route::post('tugas/update/{id}', [SiswaTugasController::class, 'updatePengumpulan'])->name('tugas.update');
    Route::delete('tugas/batalkan/{id}', [SiswaTugasController::class, 'destroyPengumpulan'])->name('tugas.batalkan');

    Route::get('profil', [ProfileSiswaController::class, 'show'])->name('profil.show');
    Route::get('profil/edit', [ProfileSiswaController::class, 'edit'])->name('profil.edit');
    Route::post('profil/update', [ProfileSiswaController::class, 'update'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| Join Kelas Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('kelas/join', [JoinKelasController::class, 'form'])->name('kelas.formJoin');
Route::post('kelas/join', [JoinKelasController::class, 'submit'])->name('kelas.submitJoin');

/*
|--------------------------------------------------------------------------
| Notifikasi Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('notifikasi/{id}/dibaca', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.dibaca');
    Route::post('notifikasi/dibaca-semua', [NotifikasiController::class, 'tandaiSemuaDibaca'])->name('notifikasi.dibacaSemua');
});
