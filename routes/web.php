<?php

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KncController;
use App\Http\Controllers\KpcController;
use App\Http\Controllers\KtcController;
use App\Http\Controllers\KtdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InsidenController;
use App\Http\Controllers\RefleksiController;
use App\Http\Controllers\SentinelController;
use App\Http\Controllers\SpvKeperuController;
use App\Http\Controllers\SupervisiKepruController;
use App\Http\Controllers\KuisonerKepuasanController;
use App\Http\Controllers\AktivitasKeperawatanController;

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
})->middleware('auth')->name('dashboard');

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

Route::get('/kepuasan_pasien', [KuisonerKepuasanController::class, 'create'])->name('kuisoner');
Route::resource('kuisoner', KuisonerKepuasanController::class);


//Data Mutu
Route::get('/mutuinsiden', InsidenController::class)->name('insiden');
// Route::resource('insiden', InsidenController::class);

Route::prefix('insiden')->name('insiden.')->group(function () {
    Route::resource('kpc', KpcController::class)->except(['insiden.kpc.show']);
    Route::resource('knc', KncController::class)->except(['insiden.knc.show']);
    Route::resource('ktc', KtcController::class)->except(['insiden.ktc.show']);
    Route::resource('ktd', KtdController::class)->except(['insiden.ktd.show']);
    Route::resource('sentinel', SentinelController::class)->except(['insiden.sentinel.show']);
});
