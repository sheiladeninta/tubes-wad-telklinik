@extends('layouts.pasien')
@section('title', 'Dashboard Pasien - Tel-Klinik')
@section('styles')
<style>
    :root {
        --primary-red: #dc3545;
        --primary-red-hover: #b02a37;
        --light-red: #f8d7da;
        --text-red: #721c24;
    }
    
    .btn-primary {
        background-color: var(--primary-red) !important;
        border-color: var(--primary-red) !important;
        color: white !important;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-red-hover) !important;
        border-color: var(--primary-red-hover) !important;
        color: white !important;
    }
    
    .btn-primary:focus, .btn-primary:active {
        background-color: var(--primary-red-hover) !important;
        border-color: var(--primary-red-hover) !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    .text-primary {
        color: var(--primary-red) !important;
    }
    
    .bg-primary {
        background-color: var(--primary-red) !important;
    }
    
    .border-primary {
        border-color: var(--primary-red) !important;
    }
    
    .stat-card .fa-2x {
        color: var(--primary-red) !important;
    }
    
    .timeline-marker.bg-primary {
        background-color: var(--primary-red) !important;
    }
    
    /* Perbaikan untuk button hover effects */
    .btn-hover-effect {
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }
    
    .btn-hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }
    
    .card-hover-effect {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    }
    
    .card-hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(33, 40, 50, 0.25);
    }
    
    .quick-action-btn {
        transition: all 0.3s ease;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    
    .timeline-line {
        content: '';
        position: absolute;
        left: 14px;
        top: 40px;
        width: 2px;
        height: calc(100% - 10px);
        background: #e9ecef;
    }
    
    .appointment-card {
        transition: all 0.3s ease;
    }
    
    .appointment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .btn-action {
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
</style>
@endsection

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h2 class="h3 mb-0">
                    <i class="fas fa-home me-2 text-danger"></i>
                    Selamat Datang, {{ $pasien->name }}!
                </h2>
                <p class="text-muted">Kelola kesehatan Anda dengan mudah melalui Tel-Klinik</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-danger btn-hover-effect">
                    <i class="fas fa-plus me-1"></i>
                    Buat Reservasi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-hover-effect h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--primary-red);">
                            Total Kunjungan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_kunjungan'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-calendar-check" style="color: var(--primary-red);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-hover-effect h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--primary-red);">
                            Reservasi Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['reservasi_aktif'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-clock" style="color: var(--primary-red);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-hover-effect h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--primary-red);">
                            Resep Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['resep_aktif'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-pills" style="color: var(--primary-red);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-hover-effect h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--primary-red);">
                            Status Kesehatan
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Baik
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-heartbeat" style="color: var(--primary-red);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-hover-effect">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-bolt me-2 text-danger"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('pasien.reservasi.create') }}" 
                           class="btn btn-outline-danger btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 quick-action-btn">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                            <span>Reservasi Baru</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('pasien.rekam-medis.index') }}" 
                           class="btn btn-outline-danger btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 quick-action-btn">
                            <i class="fas fa-file-medical fa-2x mb-2"></i>
                            <span>Lihat Rekam Medis</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" 
                           class="btn btn-outline-danger btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 quick-action-btn">
                            <i class="fas fa-download fa-2x mb-2"></i>
                            <span>Unduh Surat</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" 
                           class="btn btn-outline-danger btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 quick-action-btn">
                            <i class="fas fa-comments fa-2x mb-2"></i>
                            <span>Konsultasi Online</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities and Upcoming Appointments -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-6 mb-4">
        <div class="card card-hover-effect h-100">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-history me-2 text-danger"></i>
                    Aktivitas Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3" style="position: relative;">
                        <div class="d-flex">
                            <div class="timeline-marker bg-success me-3 mt-1" style="width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1" style="margin-top: 5px;">Reservasi Berhasil Dibuat</h6>
                                <p class="text-muted small mb-0">Reservasi untuk pemeriksaan umum pada 15 Jun 2024</p>
                                <span class="text-muted small">2 hari yang lalu</span>
                            </div>
                        </div>
                        <div class="timeline-line"></div>
                    </div>
                    
                    <div class="timeline-item mb-3" style="position: relative;">
                        <div class="d-flex">
                            <div class="timeline-marker bg-info me-3 mt-1" style="width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                <i class="fas fa-pills text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1" style="margin-top: 5px;">Resep Obat Diterbitkan</h6>
                                <p class="text-muted small mb-0">Dr. Ahmad memberikan resep untuk kondisi Anda</p>
                                <span class="text-muted small">1 minggu yang lalu</span>
                            </div>
                        </div>
                        <div class="timeline-line"></div>
                    </div>
                    
                    <div class="timeline-item mb-3" style="position: relative;">
                        <div class="d-flex">
                            <div class="timeline-marker bg-warning me-3 mt-1" style="width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                <i class="fas fa-file-medical text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1" style="margin-top: 5px;">Rekam Medis Diperbarui</h6>
                                <p class="text-muted small mb-0">Hasil pemeriksaan laboratorium telah tersedia</p>
                                <span class="text-muted small">2 minggu yang lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-sm btn-outline-danger btn-action">
                        Lihat Semua Aktivitas
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Appointments -->
    <div class="col-lg-6 mb-4">
        <div class="card card-hover-effect h-100">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-calendar-alt me-2 text-danger"></i>
                    Jadwal Mendatang
                </h5>
            </div>
            <div class="card-body">
                <div class="appointment-list">
                    <div class="alert alert-light border-start border-4 border-danger mb-3 appointment-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="alert-heading mb-1" style="margin-top: 5px;">Pemeriksaan Umum</h6>
                                <p class="mb-1">
                                    <i class="fas fa-user-md me-1"></i>
                                    Dr. Ahmad Susanto
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-calendar me-1"></i>
                                    Senin, 17 Juni 2024 - 09:00 WIB
                                </p>
                            </div>
                            <span class="badge bg-success">Terkonfirmasi</span>
                        </div>
                    </div>
                    
                    <div class="alert alert-light border-start border-4 border-warning mb-3 appointment-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="alert-heading mb-1" style="margin-top: 5px;">Konsultasi Gizi</h6>
                                <p class="mb-1">
                                    <i class="fas fa-user-md me-1"></i>
                                    Dr. Sari Nutritionist
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-calendar me-1"></i>
                                    Rabu, 19 Juni 2024 - 14:00 WIB
                                </p>
                            </div>
                            <span class="badge bg-warning">Menunggu</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-sm btn-outline-danger btn-action">
                        Lihat Semua Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Health Tips -->
<div class="row">
    <div class="col-12">
        <div class="card card-hover-effect">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-lightbulb me-2 text-danger"></i>
                    Tips Kesehatan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-tint fa-2x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 style="margin-top: 5px;">Minum Air Putih</h6>
                                <p class="text-muted small mb-0">Konsumsi minimal 8 gelas air putih setiap hari untuk menjaga hidrasi tubuh.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-running fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 style="margin-top: 5px;">Olahraga Teratur</h6>
                                <p class="text-muted small mb-0">Lakukan aktivitas fisik minimal 30 menit setiap hari untuk kesehatan optimal.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-moon fa-2x" style="color: var(--primary-red);"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 style="margin-top: 5px;">Tidur Cukup</h6>
                                <p class="text-muted small mb-0">Pastikan tidur 7-8 jam setiap malam untuk pemulihan tubuh yang optimal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Perbaikan: Hapus preventDefault yang mengganggu klik link
        // Hanya tambahkan event listener untuk tracking tanpa menghalangi navigasi
        
        // Track button clicks untuk analytics (opsional)
        document.querySelectorAll('a[href*="reservasi"]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                console.log('Reservasi button clicked:', this.href);
                // Jangan gunakan e.preventDefault() di sini
            });
        });
        
        // Auto-refresh stats setiap 30 detik (opsional)
        setInterval(function() {
            console.log('Stats refresh interval');
        }, 30000);
        
        // Notifikasi untuk appointment yang akan datang
        const appointments = document.querySelectorAll('.appointment-list .alert');
        if (appointments.length > 0) {
            console.log('Found', appointments.length, 'upcoming appointments');
        }
        
        // Smooth scroll untuk internal links
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endsection