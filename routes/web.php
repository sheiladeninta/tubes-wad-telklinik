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
use App\Http\Controllers\Admin\ObatController;
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

     // Obat Management Routes
    Route::resource('obat', ObatController::class);
    Route::post('/obat/{id}/update-stock', [ObatController::class, 'updateStock'])->name('obat.updateStock');
    Route::get('/api/obat/dashboard-data', [ObatController::class, 'getDashboardData'])->name('obat.dashboard-data');
});

// Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [DokterController::class, 'profile'])->name('profile');
    Route::put('/profile', [DokterController::class, 'updateProfile'])->name('profile.update');

    // Routes untuk manajemen reservasi dokter
    Route::prefix('reservasi')->name('reservasi.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\ReservasiController::class, 'index'])->name('index');
        Route::get('/today', [App\Http\Controllers\Dokter\ReservasiController::class, 'today'])->name('today');
        Route::get('/upcoming', [App\Http\Controllers\Dokter\ReservasiController::class, 'upcoming'])->name('upcoming');
        Route::get('/{reservasi}', [App\Http\Controllers\Dokter\ReservasiController::class, 'show'])->name('show');
        Route::patch('/{reservasi}/confirm', [App\Http\Controllers\Dokter\ReservasiController::class, 'confirm'])->name('confirm');
        Route::patch('/{reservasi}/complete', [App\Http\Controllers\Dokter\ReservasiController::class, 'complete'])->name('complete');
        Route::patch('/{reservasi}/cancel', [App\Http\Controllers\Dokter\ReservasiController::class, 'cancel'])->name('cancel');
    });

    // Routes untuk konsultasi online dokter
    Route::prefix('consultation')->name('consultation.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\ConsultationController::class, 'index'])->name('index');
        Route::get('/{consultation}', [App\Http\Controllers\Dokter\ConsultationController::class, 'show'])->name('show');
        Route::post('/{consultation}/message', [App\Http\Controllers\Dokter\ConsultationController::class, 'sendMessage'])->name('send-message');
        Route::post('/{consultation}/accept', [App\Http\Controllers\Dokter\ConsultationController::class, 'acceptConsultation'])->name('accept');
        Route::post('/{consultation}/complete', [App\Http\Controllers\Dokter\ConsultationController::class, 'completeConsultation'])->name('complete');
        Route::get('/{consultation}/messages', [App\Http\Controllers\Dokter\ConsultationController::class, 'getMessages'])->name('messages');
    });

    // Routes untuk manajemen rekam medis dokter
    Route::prefix('rekam-medis')->name('rekam-medis.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\RekamMedisController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Dokter\RekamMedisController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Dokter\RekamMedisController::class, 'store'])->name('store');
        Route::get('/{rekamMedis}', [App\Http\Controllers\Dokter\RekamMedisController::class, 'show'])->name('show');
        Route::get('/{rekamMedis}/edit', [App\Http\Controllers\Dokter\RekamMedisController::class, 'edit'])->name('edit');
        Route::put('/{rekamMedis}', [App\Http\Controllers\Dokter\RekamMedisController::class, 'update'])->name('update');
        Route::get('/statistics/data', [App\Http\Controllers\Dokter\RekamMedisController::class, 'getStatistics'])->name('statistics');
    });

    // Routes untuk manajemen resep obat oleh dokter
    Route::prefix('resep-obat')->name('resep-obat.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\ResepObatController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Dokter\ResepObatController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Dokter\ResepObatController::class, 'store'])->name('store');
        Route::get('/{resepObat}', [App\Http\Controllers\Dokter\ResepObatController::class, 'show'])->name('show');
        Route::get('/{resepObat}/edit', [App\Http\Controllers\Dokter\ResepObatController::class, 'edit'])->name('edit');
        Route::put('/{resepObat}', [App\Http\Controllers\Dokter\ResepObatController::class, 'update'])->name('update');
        Route::delete('/{resepObat}', [App\Http\Controllers\Dokter\ResepObatController::class, 'destroy'])->name('destroy');
    });
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