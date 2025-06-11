@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2" style="color: #2c3e50; font-weight: 700;">
                        <i class="fas fa-tachometer-alt me-2" style="color: #dc3545;"></i>
                        Dashboard Admin
                    </h1>
                    <p class="text-muted mb-0">Selamat datang di sistem manajemen Tel-Klinik</p>
                </div>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #b02a37); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                            <i class="fas fa-pills fa-2x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="h4 mb-1 font-weight-bold">1,234</div>
                        <div class="small opacity-75">Total Stok Obat</div>
                        <div class="small mt-1">
                            <i class="fas fa-arrow-up me-1"></i>12% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                            <i class="fas fa-user-md fa-2x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="h4 mb-1 font-weight-bold">24</div>
                        <div class="small opacity-75">Dokter Aktif</div>
                        <div class="small mt-1">
                            <i class="fas fa-check-circle me-1"></i>20 Online sekarang
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #a71e2a); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="h4 mb-1 font-weight-bold">5,678</div>
                        <div class="small opacity-75">Total Pasien</div>
                        <div class="small mt-1">
                            <i class="fas fa-user-plus me-1"></i>34 Pasien baru hari ini
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #bd2130); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="h4 mb-1 font-weight-bold">89</div>
                        <div class="small opacity-75">Reservasi Hari Ini</div>
                        <div class="small mt-1">
                            <i class="fas fa-clock me-1"></i>12 Menunggu konfirmasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="row">
        <!-- Recent Activities & Notifications -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-bell me-2" style="color: #dc3545;"></i>
                            Aktivitas Terbaru
                        </h5>
                        <a href="#" class="btn btn-sm" style="background-color: #dc3545; color: white; border: none;">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #f8d7da;">
                                        <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-semibold">Stok Obat Menipis</div>
                                    <div class="text-muted small">Paracetamol 500mg - Sisa 15 tablet</div>
                                    <div class="text-muted small">2 menit yang lalu</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #d1ecf1;">
                                        <i class="fas fa-user-plus" style="color: #0c5460;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-semibold">Pasien Baru Terdaftar</div>
                                    <div class="text-muted small">Andi Pratama - No. Rekam Medis: RM001234</div>
                                    <div class="text-muted small">15 menit yang lalu</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fff3cd;">
                                        <i class="fas fa-calendar-times" style="color: #856404;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-semibold">Jadwal Dokter Berubah</div>
                                    <div class="text-muted small">Dr. Sarah - Jadwal hari Kamis dibatalkan</div>
                                    <div class="text-muted small">1 jam yang lalu</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #d4edda;">
                                        <i class="fas fa-truck" style="color: #155724;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-semibold">Pemasukan Obat Baru</div>
                                    <div class="text-muted small">50 kotak Amoxicillin diterima dari PT. Kimia Farma</div>
                                    <div class="text-muted small">3 jam yang lalu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                        <i class="fas fa-bolt me-2" style="color: #dc3545;"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <button class="btn btn-outline-danger btn-lg text-start">
                            <i class="fas fa-plus me-3"></i>
                            <div class="d-flex flex-column">
                                <div class="fw-semibold">Tambah Obat Baru</div>
                                <small class="text-muted">Input stok obat ke inventaris</small>
                            </div>
                        </button>
                        
                        <button class="btn btn-outline-danger btn-lg text-start">
                            <i class="fas fa-user-md me-3"></i>
                            <div class="d-flex flex-column">
                                <div class="fw-semibold">Kelola Jadwal Dokter</div>
                                <small class="text-muted">Atur jadwal praktek dokter</small>
                            </div>
                        </button>
                        
                        <button class="btn btn-outline-danger btn-lg text-start">
                            <i class="fas fa-bell me-3"></i>
                            <div class="d-flex flex-column">
                                <div class="fw-semibold">Kirim Notifikasi</div>
                                <small class="text-muted">Broadcast ke semua user</small>
                            </div>
                        </button>
                        
                        <button class="btn btn-outline-danger btn-lg text-start">
                            <i class="fas fa-chart-bar me-3"></i>
                            <div class="d-flex flex-column">
                                <div class="fw-semibold">Lihat Laporan</div>
                                <small class="text-muted">Analisis data sistem</small>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Charts & Tables -->
    <div class="row">
        <!-- Monthly Statistics -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-chart-line me-2" style="color: #dc3545;"></i>
                            Statistik Bulanan
                        </h5>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="period" id="month" checked>
                            <label class="btn btn-outline-danger btn-sm" for="month">Bulan</label>
                            <input type="radio" class="btn-check" name="period" id="year">
                            <label class="btn btn-outline-danger btn-sm" for="year">Tahun</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px; display: flex; align-items: center; justify-content: center; background: linear-gradient(45deg, #f8f9fa, #ffffff);">
                        <div class="text-center">
                            <i class="fas fa-chart-area fa-4x mb-3" style="color: #dc3545; opacity: 0.3;"></i>
                            <h5 style="color: #6c757d;">Grafik Statistik</h5>
                            <p class="text-muted">Data visualisasi akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                        <i class="fas fa-server me-2" style="color: #dc3545;"></i>
                        Status Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Database</span>
                            <span class="badge bg-success">Online</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 98%"></div>
                        </div>
                        <small class="text-muted">98% Performance</small>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Server</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 95%"></div>
                        </div>
                        <small class="text-muted">95% Uptime</small>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Storage</span>
                            <span class="badge bg-warning">Moderate</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 75%"></div>
                        </div>
                        <small class="text-muted">75% Used</small>
                    </div>
                    
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Backup</span>
                            <span class="badge bg-success">Updated</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                        <small class="text-muted">Last backup: 2 hours ago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Patients & Doctors Table -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-users me-2" style="color: #dc3545;"></i>
                            Pasien Terbaru
                        </h5>
                        <a href="#" class="btn btn-sm" style="background-color: #dc3545; color: white; border: none;">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>No. RM</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=dc3545&color=fff" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Andi Pratama</div>
                                                <small class="text-muted">Laki-laki, 28 tahun</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>RM001234</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Sari+Dewi&background=dc3545&color=fff" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Sari Dewi</div>
                                                <small class="text-muted">Perempuan, 35 tahun</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>RM001235</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=dc3545&color=fff" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Budi Santoso</div>
                                                <small class="text-muted">Laki-laki, 42 tahun</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>RM001236</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-user-md me-2" style="color: #dc3545;"></i>
                            Dokter Online
                        </h5>
                        <a href="#" class="btn btn-sm" style="background-color: #dc3545; color: white; border: none;">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Dokter</th>
                                    <th>Spesialisasi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Dr+Sarah&background=dc3545&color=fff" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Dr. Sarah</div>
                                                <small class="text-muted">Dokter Umum</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Umum</td>
                                    <td>
                                        <span class="badge bg-success d-flex align-items-center" style="width: fit-content;">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i>Online
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Dr+Ahmad&background=dc3545&color=fff" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Dr. Ahmad</div>
                                                <small class="text-muted">Spesialis Dalam</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Penyakit Dalam</td>
                                    <td>
                                        <span class="badge bg-success d-flex align-items-center" style="width: fit-content;">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i>Online
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Dr+Maya&background=dc3545&color=fff" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Dr. Maya</div>
                                                <small class="text-muted">Spesialis Anak</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Anak</td>
                                    <td>
                                        <span class="badge bg-secondary d-flex align-items-center" style="width: fit-content;">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i>Offline
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-item {
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 19px;
    top: 60px;
    width: 2px;
    height: 20px;
    background-color: #e9ecef;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.progress-bar {
    transition: width 0.6s ease;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .timeline-item .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .timeline-item .flex-shrink-0 {
        margin-bottom: 0.5rem;
    }
    
    .timeline-item .flex-grow-1 {
        margin-left: 0 !important;
    }
}
</style>
@endsection