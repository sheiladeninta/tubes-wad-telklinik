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
use App\Http\Controllers\Admin\DoctorController;
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
    // Reservasi Management Routes
    Route::get('/reservasi', [App\Http\Controllers\Admin\ReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('/reservasi/{reservasi}', [App\Http\Controllers\Admin\ReservasiController::class, 'show'])->name('reservasi.show');
    // Resep Obat Management Routes
    Route::get('/resep-obat', [App\Http\Controllers\Admin\ReservasiController::class, 'resepObat'])->name('resep-obat.index');
    Route::patch('/resep-obat/{resepObat}/status', [App\Http\Controllers\Admin\ReservasiController::class, 'updateResepStatus'])->name('resep-obat.updateStatus');
    // Doctor Management Routes
    Route::resource('doctors', DoctorController::class);
    Route::patch('/doctors/{doctor}/toggle-status', [DoctorController::class, 'toggleStatus'])->name('doctors.toggle-status');
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
        Route::delete('/{rekamMedis}', [App\Http\Controllers\Dokter\RekamMedisController::class, 'destroy'])->name('destroy');
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
        Route::get('/ajax/pasien', [App\Http\Controllers\Dokter\ResepObatController::class, 'getPasien'])->name('ajax.pasien');
        Route::get('/ajax/reservasi-by-pasien', [App\Http\Controllers\Dokter\ResepObatController::class, 'getReservasiByPasien'])->name('ajax.reservasi-by-pasien');
        Route::get('/ajax/reservasi-detail', [App\Http\Controllers\Dokter\ResepObatController::class, 'getReservasiDetail'])->name('ajax.reservasi-detail');
    });

    // Routes untuk manajemen obat oleh dokter (READ ONLY)
    Route::prefix('obat')->name('obat.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\ObatController::class, 'index'])->name('index');
        Route::get('/{obat}', [App\Http\Controllers\Dokter\ObatController::class, 'show'])->name('show');
        Route::get('/{obat}/info', [App\Http\Controllers\Dokter\ObatController::class, 'getInfo'])->name('info');
    });

    // Routes untuk manajemen surat keterangan oleh dokter
    Route::prefix('surat-keterangan')->name('surat-keterangan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\SuratKeteranganController::class, 'index'])->name('index');
        Route::get('/{suratKeterangan}', [App\Http\Controllers\Dokter\SuratKeteranganController::class, 'show'])->name('show');
        Route::post('/{suratKeterangan}/approve', [App\Http\Controllers\Dokter\SuratKeteranganController::class, 'approve'])->name('approve');
        Route::post('/{suratKeterangan}/reject', [App\Http\Controllers\Dokter\SuratKeteranganController::class, 'reject'])->name('reject');
        Route::get('/{suratKeterangan}/download', [App\Http\Controllers\Dokter\SuratKeteranganController::class, 'download'])->name('download');
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
    Route::get('/rekam-medis/{rekamMedis}/download', [RekamMedisController::class, 'download'])->name('rekam-medis.download');
    Route::get('/rekam-medis/statistics/data', [RekamMedisController::class, 'getStatistics'])->name('rekam-medis.statistics');
    
    // Resep Obat Routes
    Route::get('/resep-obat', [ResepObatController::class, 'index'])->name('resep-obat.index');
    Route::get('/resep-obat/siap-diambil', [ResepObatController::class, 'siapDiambil'])->name('resep-obat.siap-diambil');
    Route::get('/resep-obat/riwayat', [ResepObatController::class, 'riwayat'])->name('resep-obat.riwayat');
    Route::get('/resep-obat/{resepObat}', [ResepObatController::class, 'show'])->name('resep-obat.show');
    Route::get('/resep-obat/{resepObat}/preview', [ResepObatController::class, 'preview'])->name('resep-obat.preview');
    Route::get('/resep-obat/{resepObat}/download', [ResepObatController::class, 'download'])->name('resep-obat.download');
    Route::post('/resep-obat/{resepObat}/konfirmasi-ambil', [ResepObatController::class, 'konfirmasiAmbil'])->name('resep-obat.konfirmasi-ambil');

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