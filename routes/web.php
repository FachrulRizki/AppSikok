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
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RefleksiController;
use App\Http\Controllers\SentinelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CuciTanganController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SupervisiKepruController;
use App\Http\Controllers\KuisonerKepuasanController;
use App\Http\Controllers\AktivitasKeperawatanController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MaterialCommentController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Quiz\AttemptController;
use App\Http\Controllers\Quiz\QuestionController;
use App\Http\Controllers\Quiz\QuizController;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate')->name('authenticate');
    });

    Route::post('logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Refleksi Harian
    Route::get('refleksi-harian/export', [RefleksiController::class, 'export'])->name('refleksi.export');
    Route::resource('refleksi-harian', RefleksiController::class)->names('refleksi');
    Route::put('refleksi-harian/{refleksi_harian}/approve', [RefleksiController::class, 'updateApprovement'])->name('refleksi.update_approvement');
    
    // Aktivitas Keperawatan
    Route::get('aktivitas-keperawatan/export', [AktivitasKeperawatanController::class, 'export'])->name('aktivitas_keperawatan.export');
    Route::resource('aktivitas-keperawatan', AktivitasKeperawatanController::class)->names('aktivitas_keperawatan');
    Route::put('aktivitas-keperawatan/{aktivitas_keperawatan}/nilai', [AktivitasKeperawatanController::class, 'updateNilai'])->name('aktivitas_keperawatan.update_nilai');

    // Supervisi Kepru
    Route::get('spv-kepru/export', [SupervisiKepruController::class, 'export'])->name('spv_kepru.export');
    Route::resource('spv-kepru', SupervisiKepruController::class)->names('spv_kepru');

    // Pengguna
    Route::resource('permissions', PermissionController::class)->names('permissions')->except(['create', 'edit', 'show']);
    Route::resource('groups', GroupController::class)->names('groups')->except(['create', 'edit']);
    Route::resource('users', UserController::class)->names('users')->except(['show']);
    
    // Data Mutu
    Route::get('/mutuinsiden', InsidenController::class)->name('insiden');
    Route::prefix('insiden')->name('insiden.')->group(function () {
        Route::get('kpc/export', [KpcController::class, 'export'])->name('kpc.export');
        Route::resource('kpc', KpcController::class)->except(['edit', 'update']);
        
        Route::get('knc/export', [KncController::class, 'export'])->name('knc.export');
        Route::resource('knc', KncController::class)->except(['edit', 'update']);
        
        Route::get('ktc/export', [KtcController::class, 'export'])->name('ktc.export');
        Route::resource('ktc', KtcController::class)->except(['edit', 'update']);
        
        Route::get('ktd/export', [KtdController::class, 'export'])->name('ktd.export');
        Route::resource('ktd', KtdController::class)->except(['edit', 'update']);
        
        Route::get('sentinel/export', [SentinelController::class, 'export'])->name('sentinel.export');
        Route::resource('sentinel', SentinelController::class)->except(['edit', 'update']);
    });

    // Lima R
    Route::get('LimaR/export', [LimaRController::class, 'export'])->name('lima_r.export');
    Route::resource('LimaR', LimaRController::class)->names('lima_r')->except(['edit', 'update']);;

    // Kepuasan Pasien
    Route::get('kepuasan-pasien/export', [KuisonerKepuasanController::class, 'export'])->name('kuesioner.export');
    Route::resource('kepuasan-pasien', KuisonerKepuasanController::class)->names('kuesioner')->except(['edit', 'update']);;

    // Cuci Tangan
    Route::get('ppi/export', [CuciTanganController::class, 'export'])->name('cuci_tangan.export');
    Route::resource('ppi', CuciTanganController::class)->names('cuci_tangan');

    // Materi
    Route::get('materi/{materi}/komentar', [MaterialController::class, 'loadKomentar'])->name('materi.load_komentar');
    Route::resource('materi', MaterialController::class)->names('materi');
    Route::resource('comments', MaterialCommentController::class)->names('comments')->only('store');

    // Quiz
    Route::resource('quiz', QuizController::class)->names('quiz')->except(['create']);
    Route::resource('question', QuestionController::class)->names('question')->only('store', 'update', 'destroy');
    Route::get('attempt/export', [AttemptController::class, 'export'])->name('attempt.export');
    Route::resource('attempt', AttemptController::class)->names('attempt')->except(['edit', 'update']);

    //sertifikat
    Route::resource('unduh-sertifikat', SertifikatController::class)->names('sertifikat')->except(['show']);
    Route::get('/unduh-sertifikat/{sertifikat}/download', [SertifikatController::class, 'download'])->name('sertifikat.download');

    Route::get('leaderboard/export', [LeaderboardController::class, 'export'])->name('leaderboard.export');
    Route::resource('leaderboard', LeaderboardController::class)->names('leaderboard')->only('index');

    Route::resource('profile', ProfilController::class)->names('profile')->only('index', 'store');
    Route::post('profile/foto-profil', [ProfilController::class, 'fotoProfil'])->name('profile.foto_profil');

    Route::resource('logs', LogController::class)->names('logs')->only('index');
});
