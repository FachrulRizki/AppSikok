<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RefleksiController;
use App\Http\Controllers\AktivitasKeperawatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SpvKeperuController;
use App\Http\Controllers\SupervisiKepruController;
use App\Http\Controllers\UserController;
use App\Models\AktivitasKeperawatan;
use Illuminate\Auth\Events\Logout;

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

// Public route for login
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate')->name('authenticate');
    });

    Route::post('logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('refleksi-harian', RefleksiController::class)->names('refleksi');
    Route::put('refleksi-harian/{refleksi_harian}/approve', [RefleksiController::class, 'updateApprovement'])->name('refleksi.update_approvement');
    
    Route::resource('aktivitas-keperawatan', AktivitasKeperawatanController::class)->names('aktivitas_keperawatan');
    Route::put('aktivitas-keperawatan/{aktivitas_keperawatan}/nilai', [AktivitasKeperawatanController::class, 'updateNilai'])->name('aktivitas_keperawatan.update_nilai');

    Route::resource('spv_kepru', SupervisiKepruController::class)->names('spv_kepru');

    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('groups', GroupController::class)->names('groups');
    Route::resource('users', UserController::class)->names('users');
});