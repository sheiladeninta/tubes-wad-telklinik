<?php
// routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\Pasien\ReservasiController;
use App\Http\Controllers\Pasien\RekamMedisController;
use App\Http\Controllers\Pasien\ResepObatController;
use App\Http\Controllers\Pasien\RequestSuratKeteranganController;
use App\Http\Controllers\Pasien\ConsultationController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [DokterController::class, 'profile'])->name('profile');
    Route::put('/profile', [DokterController::class, 'updateProfile'])->name('profile.update');
});

// Pasien Routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');
    // Reservasi Routes
    Route::resource('reservasi', ReservasiController::class)->except(['edit', 'update', 'destroy']);
    Route::patch('/reservasi/{reservasi}/cancel', [ReservasiController::class, 'cancel'])->name('reservasi.cancel');
    Route::get('/reservasi-mendatang', [ReservasiController::class, 'upcoming'])->name('reservasi.upcoming');
    Route::post('/check-availability', [ReservasiController::class, 'checkAvailability'])->name('reservasi.check-availability');

    // Rekam Medis Routes
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/{rekamMedis}', [RekamMedisController::class, 'show'])->name('rekam-medis.show');
    
    // Resep Obat Routes
    Route::get('/resep-obat', [ResepObatController::class, 'index'])->name('resep-obat.index');
    Route::get('/resep-obat/siap-diambil', [ResepObatController::class, 'siapDiambil'])->name('resep-obat.siap-diambil');
    Route::get('/resep-obat/riwayat', [ResepObatController::class, 'riwayat'])->name('resep-obat.riwayat');
    Route::get('/resep-obat/{resepObat}', [ResepObatController::class, 'show'])->name('resep-obat.show');
    Route::get('/resep-obat/{resepObat}/print', [ResepObatController::class, 'print'])->name('resep-obat.print');

    // Surat Keterangan Routes
    Route::prefix('surat-keterangan')->name('surat-keterangan.')->group(function () {
        Route::get('/', [RequestSuratKeteranganController::class, 'index'])->name('index');
        Route::get('/create', [RequestSuratKeteranganController::class, 'create'])->name('create');
        Route::post('/', [RequestSuratKeteranganController::class, 'store'])->name('store');
        Route::get('/{suratKeterangan}', [RequestSuratKeteranganController::class, 'show'])->name('show');
        Route::get('/{suratKeterangan}/download', [RequestSuratKeteranganController::class, 'download'])->name('download');
        Route::delete('/{suratKeterangan}/cancel', [RequestSuratKeteranganController::class, 'cancel'])->name('cancel');
    });
    Route::get('/get-dokters', [RequestSuratKeteranganController::class, 'getDokters'])->name('get-dokters');

    // Konsultasi Online
    Route::prefix('consultation')->name('consultation.')->group(function () {
        Route::get('/', [ConsultationController::class, 'index'])->name('index');
        Route::get('/create', [ConsultationController::class, 'create'])->name('create');
        Route::post('/', [ConsultationController::class, 'store'])->name('store');
        Route::get('/{consultation}', [ConsultationController::class, 'show'])->name('show');
        Route::post('/{consultation}/send', [ConsultationController::class, 'sendMessage'])->name('sendMessage');
        Route::post('/{consultation}/end', [ConsultationController::class, 'endConsultation'])->name('end');
        Route::get('/{consultation}/messages', [ConsultationController::class, 'getMessages'])->name('getMessages');
        Route::post('/{consultation}/cancel', [ConsultationController::class, 'cancel'])->name('cancel');
    });
});