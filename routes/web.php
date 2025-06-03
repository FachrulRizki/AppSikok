<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RefleksiController;
use App\Http\Controllers\AktivitasKeperawatanController;
use App\Http\Controllers\SpvKeperuController;
use App\Http\Controllers\SupervisiKepruController;
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

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| API Routes for SIKOK-App
|--------------------------------------------------------------------------
*/

// Public route for login
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate')->name('authenticate');
    });

    Route::post('logout', 'logout')->name('logout');
});

Route::get('/aktivitas-refleksi', [RefleksiController::class, 'index'])->name('refleksi');
Route::resource('refleksi', RefleksiController::class);

Route::get('/aktivitas-keperawatan', [AktivitasKeperawatanController::class, 'index'])->name('aktivitas_keperawatan');
Route::resource('aktivitas_keperawatan', AktivitasKeperawatanController::class);

Route::get('/spvkepru', [SupervisiKepruController::class, 'index'])->name('spv_kepru');
Route::resource('spv_kepru', SupervisiKepruController::class);
