<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KncController;
use App\Http\Controllers\KpcController;
use App\Http\Controllers\KtcController;
use App\Http\Controllers\KtdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LimaRController;
use App\Http\Controllers\InsidenController;
use App\Http\Controllers\RefleksiController;
use App\Http\Controllers\SentinelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CuciTanganController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SupervisiKepruController;
use App\Http\Controllers\KuisonerKepuasanController;
use App\Http\Controllers\AktivitasKeperawatanController;
use App\Http\Controllers\MaterialCommentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Quiz\AttemptController;
use App\Http\Controllers\Quiz\QuestionController;
use App\Http\Controllers\Quiz\QuizController;

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

    Route::resource('spv-kepru', SupervisiKepruController::class)->names('spv_kepru');

    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('groups', GroupController::class)->names('groups');
    Route::resource('users', UserController::class)->names('users');
    
    Route::get('/mutuinsiden', InsidenController::class)->name('insiden');
    Route::prefix('insiden')->name('insiden.')->group(function () {
        Route::resource('kpc', KpcController::class)->except(['insiden.kpc.show']);
        Route::resource('knc', KncController::class)->except(['insiden.knc.show']);
        Route::resource('ktc', KtcController::class)->except(['insiden.ktc.show']);
        Route::resource('ktd', KtdController::class)->except(['insiden.ktd.show']);
        Route::resource('sentinel', SentinelController::class)->except(['insiden.sentinel.show']);
    });

    Route::resource('LimaR', LimaRController::class)->names('lima_r');

    Route::get('kepuasan-pasien/print', [KuisonerKepuasanController::class, 'printPDF'])->name('kuesioner.print');
    Route::resource('kepuasan-pasien', KuisonerKepuasanController::class)->names('kuesioner');

    Route::resource('cuci-tangan', CuciTanganController::class)->names('cuci_tangan');

    // Materi
    Route::get('materi/{materi}/komentar', [MaterialController::class, 'loadKomentar'])->name('materi.load_komentar');
    Route::resource('materi', MaterialController::class)->names('materi');
    Route::resource('comments', MaterialCommentController::class)->names('comments');

    // Quiz
    Route::resource('quiz', QuizController::class)->names('quiz');
    Route::resource('question', QuestionController::class)->names('question');
    Route::resource('attempt', AttemptController::class)->names('attempt');
});
