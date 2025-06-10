@extends('layouts.dokter')
@section('title', 'Dashboard Dokter - Tel-Klinik')
@section('styles')
<style>
    :root {
        --primary-blue: #0d6efd;
        --primary-blue-hover: #0b5ed7;
        --light-blue: #cfe2ff;
        --text-blue: #084298;
        --success-green: #198754;
        --warning-yellow: #ffc107;
        --danger-red: #dc3545;
    }
    
    .btn-primary {
        background-color: var(--primary-blue) !important;
        border-color: var(--primary-blue) !important;
        color: white !important;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-blue-hover) !important;
        border-color: var(--primary-blue-hover) !important;
        color: white !important;
    }
    
    .btn-primary:focus, .btn-primary:active {
        background-color: var(--primary-blue-hover) !important;
        border-color: var(--primary-blue-hover) !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
    }
    
    .text-primary {
        color: var(--primary-blue) !important;
    }
    
    .bg-primary {
        background-color: var(--primary-blue) !important;
    }
    
    .border-primary {
        border-color: var(--primary-blue) !important;
    }
    
    .stat-card .fa-2x {
        color: var(--primary-blue) !important;
    }
    
    .timeline-marker.bg-primary {
        background-color: var(--primary-blue) !important;
    }
    
    .doctor-status {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 50rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .doctor-status.active {
        background-color: rgba(25, 135, 84, 0.1);
        color: var(--success-green);
        border: 1px solid rgba(25, 135, 84, 0.3);
    }
    
    .doctor-status.inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.3);
    }
    
    .patient-card {
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-blue);
    }
    
    .patient-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .chart-container {
        position: relative;
        height: 300px;
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
                    <i class="fas fa-stethoscope me-2 text-primary"></i>
                    Selamat Datang, Dr. {{ $dokterInfo['name'] }}!
                </h2>
                <p class="text-muted">
                    {{ $dokterInfo['specialist'] }} | 
                    <span class="doctor-status {{ $dokterInfo['is_active'] ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                        {{ $dokterInfo['is_active'] ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-primary" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(13, 110, 253, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-file-medical me-1"></i>
                        Buat Rekam Medis
                    </button>
                    <button type="button" class="btn btn-outline-primary" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(13, 110, 253, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-prescription me-1"></i>
                        Buat Resep
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="transition: all 0.3s ease; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0.5rem 2rem 0 rgba(33, 40, 50, 0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15)'">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--primary-blue);">
                            Jadwal Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['jadwal_hari_ini'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-calendar-day" style="color: var(--primary-blue);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="transition: all 0.3s ease; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0.5rem 2rem 0 rgba(33, 40, 50, 0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15)'">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--success-green);">
                            Total Pasien
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_pasien'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-users" style="color: var(--success-green);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="transition: all 0.3s ease; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0.5rem 2rem 0 rgba(33, 40, 50, 0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15)'">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--warning-yellow);">
                            Konsultasi Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['konsultasi_pending'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-clock" style="color: var(--warning-yellow);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="transition: all 0.3s ease; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0.5rem 2rem 0 rgba(33, 40, 50, 0.25)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15)'">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-2" style="color: var(--danger-red);">
                            Total Dokter Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_dokter'] }}
                        </div>
                    </div>
                    <div class="fa-2x">
                        <i class="fas fa-user-md" style="color: var(--danger-red);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-bolt me-2 text-primary"></i>
                    Aksi Cepat Dokter
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-primary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(13, 110, 253, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-file-medical fa-2x mb-2"></i>
                            <span class="small">Rekam Medis</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-success btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(25, 135, 84, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-prescription fa-2x mb-2"></i>
                            <span class="small">Buat Resep</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-info btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(13, 202, 240, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                            <span class="small">Jadwal Praktek</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-warning btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(255, 193, 7, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-file-signature fa-2x mb-2"></i>
                            <span class="small">Surat Keterangan</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-secondary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(108, 117, 125, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-pills fa-2x mb-2"></i>
                            <span class="small">Stok Obat</span>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <a href="#" class="btn btn-outline-danger btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(220, 53, 69, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <span class="small">Statistik</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Schedule and Recent Patients -->
<div class="row mb-4">
    <!-- Today's Schedule -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-calendar-check me-2 text-primary"></i>
                    Jadwal Hari Ini
                </h5>
                <span class="badge bg-primary">{{ date('d M Y') }}</span>
            </div>
            <div class="card-body">
                <div class="schedule-list">
                    <div class="alert alert-light border-start border-4 border-primary mb-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="alert-heading mb-1" style="margin-top: 5px;">Ahmad Susanto</h6>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    09:00 - 09:30 WIB
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-stethoscope me-1"></i>
                                    Pemeriksaan Umum
                                </p>
                            </div>
                            <span class="badge bg-success">Selesai</span>
                        </div>
                    </div>
                    
                    <div class="alert alert-light border-start border-4 border-warning mb-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="alert-heading mb-1" style="margin-top: 5px;">Sari Dewi</h6>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    10:00 - 10:30 WIB
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-heartbeat me-1"></i>
                                    Kontrol Hipertensi
                                </p>
                            </div>
                            <span class="badge bg-warning">Berlangsung</span>
                        </div>
                    </div>
                    
                    <div class="alert alert-light border-start border-4 border-secondary mb-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="alert-heading mb-1" style="margin-top: 5px;">Budi Hartono</h6>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    11:00 - 11:30 WIB
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-eye me-1"></i>
                                    Konsultasi Mata
                                </p>
                            </div>
                            <span class="badge bg-secondary">Menunggu</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-sm btn-outline-primary" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(13, 110, 253, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Lihat Semua Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Patients -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-users me-2 text-success"></i>
                    Pasien Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="patient-list">
                    <div class="patient-card card mb-3 border-0" style="background-color: #f8f9fa;">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary text-white me-3" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        M
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Maya Sari</h6>
                                        <small class="text-muted">Perempuan, 28 tahun</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-info">Baru</span>
                                    <br>
                                    <small class="text-muted">2 jam lalu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="patient-card card mb-3 border-0" style="background-color: #f8f9fa;">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-success text-white me-3" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        R
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Rahmat Hidayat</h6>
                                        <small class="text-muted">Laki-laki, 45 tahun</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-warning">Follow-up</span>
                                    <br>
                                    <small class="text-muted">1 hari lalu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="patient-card card mb-3 border-0" style="background-color: #f8f9fa;">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-danger text-white me-3" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        L
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Linda Pratiwi</h6>
                                        <small class="text-muted">Perempuan, 35 tahun</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-secondary">Kontrol</span>
                                    <br>
                                    <small class="text-muted">3 hari lalu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-sm btn-outline-success" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(25, 135, 84, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Lihat Semua Pasien
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Doctor Profile and Medical Tips -->
<div class="row">
    <!-- Doctor Profile Summary -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-user-md me-2"></i>
                    Profil Dokter
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-circle bg-primary text-white mx-auto mb-2" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold;">
                        {{ substr($dokterInfo['name'], 0, 1) }}
                    </div>
                    <h5 class="mb-1">Dr. {{ $dokterInfo['name'] }}</h5>
                    <p class="text-muted mb-0">{{ $dokterInfo['specialist'] }}</p>
                    <small class="text-muted">STR: {{ $dokterInfo['license_number'] }}</small>
                </div>
                
                <hr>
                
                <div class="profile-info">
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">Email:</div>
                        <div class="col-8 small">{{ $dokterInfo['email'] }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">Telepon:</div>
                        <div class="col-8 small">{{ $dokterInfo['phone'] ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">Jenis Kelamin:</div>
                        <div class="col-8 small">{{ $dokterInfo['gender'] }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted small">Golongan Darah:</div>
                        <div class="col-8 small">{{ $dokterInfo['blood_type'] ?? '-' }}</div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('dokter.profile') }}" class="btn btn-sm btn-outline-primary" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(13, 110, 253, 0.3)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                                                Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Medical Tips -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-lightbulb me-2 text-warning"></i>
                    Tips Medis Hari Ini
                </h5>
            </div>
            <div class="card-body">
                <div class="tips-container">
                    <div class="alert alert-info border-start border-4 border-info mb-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-heartbeat fa-2x text-info"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Pentingnya Pemeriksaan Tekanan Darah Rutin</h6>
                                <p class="mb-0">Hipertensi sering disebut "silent killer" karena tidak menunjukkan gejala yang jelas. Anjurkan pasien untuk melakukan pemeriksaan tekanan darah secara rutin, minimal sebulan sekali untuk mencegah komplikasi yang lebih serius.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-success border-start border-4 border-success mb-3" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-shield-alt fa-2x text-success"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Protokol Pencegahan Infeksi</h6>
                                <p class="mb-0">Selalu ingatkan pasien tentang pentingnya mencuci tangan dengan sabun selama 20 detik dan menggunakan hand sanitizer. Praktik sederhana ini dapat mencegah penyebaran berbagai penyakit infeksi.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning border-start border-4 border-warning mb-0" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-pills fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Edukasi Penggunaan Obat</h6>
                                <p class="mb-0">Pastikan pasien memahami cara penggunaan obat yang benar, termasuk dosis, waktu minum, dan efek samping yang mungkin terjadi. Konsistensi dalam mengonsumsi obat sangat penting untuk efektivitas pengobatan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Statistics Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0" style="margin-top: 8px;">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Statistik Konsultasi Bulanan
                    </h5>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary active">7 Hari</button>
                        <button type="button" class="btn btn-outline-primary">30 Hari</button>
                        <button type="button" class="btn btn-outline-primary">6 Bulan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="consultationChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0" style="margin-top: 8px;">
                    <i class="fas fa-history me-2 text-secondary"></i>
                    Aktivitas Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3" style="position: relative; padding-left: 40px;">
                        <div class="timeline-marker bg-primary" style="position: absolute; left: 0; top: 8px; width: 12px; height: 12px; border-radius: 50%;"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Konsultasi dengan Ahmad Susanto selesai</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        2 jam yang lalu
                                    </p>
                                </div>
                                <span class="badge bg-success">Selesai</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-3" style="position: relative; padding-left: 40px;">
                        <div class="timeline-marker bg-info" style="position: absolute; left: 0; top: 8px; width: 12px; height: 12px; border-radius: 50%;"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Resep untuk Sari Dewi telah dibuat</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        3 jam yang lalu
                                    </p>
                                </div>
                                <span class="badge bg-info">Resep</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-3" style="position: relative; padding-left: 40px;">
                        <div class="timeline-marker bg-warning" style="position: absolute; left: 0; top: 8px; width: 12px; height: 12px; border-radius: 50%;"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Rekam medis Maya Sari telah diperbarui</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        5 jam yang lalu
                                    </p>
                                </div>
                                <span class="badge bg-warning">Update</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item" style="position: relative; padding-left: 40px;">
                        <div class="timeline-marker bg-secondary" style="position: absolute; left: 0; top: 8px; width: 12px; height: 12px; border-radius: 50%;"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Jadwal praktek minggu depan telah disinkronkan</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        1 hari yang lalu
                                    </p>
                                </div>
                                <span class="badge bg-secondary">Sistem</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-sm btn-outline-secondary" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(108, 117, 125, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Lihat Semua Aktivitas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart for consultation statistics
    const ctx = document.getElementById('consultationChart').getContext('2d');
    const consultationChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Konsultasi',
                data: [12, 19, 8, 15, 22, 8, 5],
                borderColor: 'rgb(13, 110, 253)',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }, {
                label: 'Pasien Baru',
                data: [3, 5, 2, 4, 6, 2, 1],
                borderColor: 'rgb(25, 135, 84)',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
    
    // Auto-refresh every 5 minutes
    setInterval(function() {
        // You can add AJAX call here to refresh data
        console.log('Auto-refreshing dashboard data...');
    }, 300000); // 5 minutes
    
    // Add click handlers for quick actions
    document.querySelectorAll('.btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning, .btn-outline-secondary, .btn-outline-danger').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
                // Add your navigation logic here
                console.log('Navigating to:', this.querySelector('span').textContent);
            }
        });
    });
});
</script>
@endsection