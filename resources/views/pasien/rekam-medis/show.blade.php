@extends('layouts.pasien')
@section('title', 'Detail Rekam Medis - Tel-Klinik')
@section('styles')
<style>
    .detail-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .header-card {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        color: white;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #dc3545;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .info-value {
        color: #2c3e50;
        font-weight: 500;
    }
    
    .vital-card {
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        border: 1px solid #e9ecef;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }
    
    .vital-card:hover {
        transform: translateY(-2px);
    }
    
    .btn-action {
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .prescription-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        border-left: 4px solid #dc3545;
    }

    .vital-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .vital-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .vital-unit {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .treatment-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .treatment-timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dc3545;
    }

    .treatment-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .treatment-item::before {
        content: '';
        position: absolute;
        left: -1.75rem;
        top: 0.5rem;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #dc3545;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #dc3545;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Back Navigation -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('pasien.rekam-medis.index') }}" class="btn btn-link text-decoration-none p-0">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Daftar Rekam Medis
            </a>
        </div>
    </div>

    <!-- Header Card -->
    <div class="card detail-card mb-4">
        <div class="card-header header-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-1 fw-bold">
                        <i class="fas fa-file-medical me-2"></i>
                        Detail Rekam Medis
                    </h3>
                    <p class="mb-0 opacity-75">
                        Pemeriksaan tanggal {{ $rekamMedis->tanggal_pemeriksaan->format('d F Y, H:i') }} WIB
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        ID: #{{ str_pad($rekamMedis->id, 6, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Information -->
        <div class="col-lg-8">
            <!-- Informasi Umum -->
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Informasi Umum</h5>
                    
                    <div class="info-item">
                        <div class="info-label">Tanggal & Waktu Pemeriksaan</div>
                        <div class="info-value">
                            {{ $rekamMedis->tanggal_pemeriksaan->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Dokter Pemeriksa</div>
                        <div class="info-value">
                            <i class="fas fa-user-md me-2 text-primary"></i>
                            Dr. {{ $rekamMedis->dokter->name }}
                        </div>
                    </div>
                    
                    @if($rekamMedis->reservasi)
                    <div class="info-item">
                        <div class="info-label">Nomor Reservasi</div>
                        <div class="info-value">
                            <span class="badge bg-info">#{{ $rekamMedis->reservasi->id }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="badge bg-success">{{ ucfirst($rekamMedis->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keluhan -->
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Keluhan Pasien</h5>
                    <div class="bg-light p-3 rounded">
                        {{ $rekamMedis->keluhan }}
                    </div>
                </div>
            </div>

            <!-- Diagnosa -->
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Diagnosa</h5>
                    <div class="bg-primary bg-opacity-10 p-3 rounded border-start border-primary border-4">
                        <strong>{{ $rekamMedis->diagnosa }}</strong>
                    </div>
                </div>
            </div>

            <!-- Pengobatan -->
            @if($rekamMedis->pengobatan)
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Pengobatan & Tindakan</h5>
                    <div class="treatment-timeline">
                        @foreach(explode("\n", $rekamMedis->pengobatan) as $treatment)
                            @if(trim($treatment))
                            <div class="treatment-item">
                                <div class="bg-light p-3 rounded">
                                    {{ trim($treatment) }}
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Resep Obat -->
            @if($rekamMedis->resep_obat)
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-pills me-2 text-success"></i>
                        Resep Obat
                    </h5>
                    @foreach(explode("\n", $rekamMedis->resep_obat) as $obat)
                        @if(trim($obat))
                        <div class="prescription-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-pill me-3 text-success"></i>
                                <div>
                                    <strong>{{ trim($obat) }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Catatan Tambahan -->
            @if($rekamMedis->catatan)
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Catatan Tambahan</h5>
                    <div class="bg-warning bg-opacity-10 p-3 rounded border-start border-warning border-4">
                        <i class="fas fa-sticky-note me-2 text-warning"></i>
                        {{ $rekamMedis->catatan }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Saran Dokter -->
            @if($rekamMedis->saran)
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Saran Dokter</h5>
                    <div class="bg-info bg-opacity-10 p-3 rounded border-start border-info border-4">
                        <i class="fas fa-lightbulb me-2 text-info"></i>
                        {{ $rekamMedis->saran }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Information -->
        <div class="col-lg-4">
            <!-- Tanda Vital -->
            <div class="card detail-card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Tanda Vital</h5>
                    
                    <!-- Tekanan Darah -->
                    @if($rekamMedis->tekanan_darah)
                    <div class="vital-card p-3 mb-3 text-center">
                        <div class="vital-icon bg-danger bg-opacity-10 text-danger mx-auto">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="vital-value">{{ $rekamMedis->tekanan_darah }}</div>
                        <div class="vital-unit">mmHg</div>
                        <small class="text-muted">Tekanan Darah</small>
                    </div>
                    @endif

                    <!-- Suhu Tubuh -->
                    @if($rekamMedis->suhu_tubuh)
                    <div class="vital-card p-3 mb-3 text-center">
                        <div class="vital-icon bg-warning bg-opacity-10 text-warning mx-auto">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <div class="vital-value">{{ $rekamMedis->suhu_tubuh }}</div>
                        <div class="vital-unit">°C</div>
                        <small class="text-muted">Suhu Tubuh</small>
                    </div>
                    @endif

                    <!-- Nadi -->
                    @if($rekamMedis->nadi)
                    <div class="vital-card p-3 mb-3 text-center">
                        <div class="vital-icon bg-success bg-opacity-10 text-success mx-auto">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="vital-value">{{ $rekamMedis->nadi }}</div>
                        <div class="vital-unit">bpm</div>
                        <small class="text-muted">Nadi</small>
                    </div>
                    @endif

                    <!-- Berat Badan -->
                    @if($rekamMedis->berat_badan)
                    <div class="vital-card p-3 mb-3 text-center">
                        <div class="vital-icon bg-primary bg-opacity-10 text-primary mx-auto">
                            <i class="fas fa-weight"></i>
                        </div>
                        <div class="vital-value">{{ $rekamMedis->berat_badan }}</div>
                        <div class="vital-unit">kg</div>
                        <small class="text-muted">Berat Badan</small>
                    </div>
                    @endif

                    <!-- Tinggi Badan -->
                    @if($rekamMedis->tinggi_badan)
                    <div class="vital-card p-3 mb-3 text-center">
                        <div class="vital-icon bg-info bg-opacity-10 text-info mx-auto">
                            <i class="fas fa-ruler-vertical"></i>
                        </div>
                        <div class="vital-value">{{ $rekamMedis->tinggi_badan }}</div>
                        <div class="vital-unit">cm</div>
                        <small class="text-muted">Tinggi Badan</small>
                    </div>
                    @endif

                    <!-- BMI -->
                    @if($rekamMedis->berat_badan && $rekamMedis->tinggi_badan)
                    @php
                        $tinggiMeter = $rekamMedis->tinggi_badan / 100;
                        $bmi = round($rekamMedis->berat_badan / ($tinggiMeter * $tinggiMeter), 1);
                        $bmiStatus = '';
                        $bmiColor = '';
                        
                        if ($bmi < 18.5) {
                            $bmiStatus = 'Kurus';
                            $bmiColor = 'text-warning';
                        } elseif ($bmi < 25) {
                            $bmiStatus = 'Normal';
                            $bmiColor = 'text-success';
                        } elseif ($bmi < 30) {
                            $bmiStatus = 'Gemuk';
                            $bmiColor = 'text-warning';
                        } else {
                            $bmiStatus = 'Obesitas';
                            $bmiColor = 'text-danger';
                        }
                    @endphp
                    <div class="vital-card p-3 mb-3 text-center border-2 border-secondary">
                        <div class="vital-icon bg-secondary bg-opacity-10 text-secondary mx-auto">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="vital-value">{{ $bmi }}</div>
                        <div class="vital-unit">BMI</div>
                        <small class="text-muted">Body Mass Index</small>
                        <div class="mt-2">
                            <span class="badge {{ $bmiColor == 'text-success' ? 'bg-success' : ($bmiColor == 'text-warning' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $bmiStatus }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Aksi -->
            <div class="card detail-card">
                <div class="card-body">
                    <h5 class="section-title">Aksi</h5>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('pasien.rekam-medis.download', $rekamMedis) }}" 
                           class="btn btn-primary btn-action">
                            <i class="fas fa-download me-2"></i>
                            Download PDF
                        </a>
                        
                        <button class="btn btn-outline-secondary btn-action" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>
                            Cetak Halaman
                        </button>
                        
                        <a href="{{ route('pasien.reservasi.create') }}" 
                           class="btn btn-outline-success btn-action">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Buat Reservasi Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontrol -->
            @if($rekamMedis->tanggal_kontrol)
            <div class="card detail-card mt-4">
                <div class="card-body">
                    <h5 class="section-title text-warning">
                        <i class="fas fa-calendar-check me-2"></i>
                        Jadwal Kontrol
                    </h5>
                    <div class="text-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                            <h6 class="fw-bold">{{ \Carbon\Carbon::parse($rekamMedis->tanggal_kontrol)->format('d F Y') }}</h6>
                            <small class="text-muted">Tanggal Kontrol Berikutnya</small>
                        </div>
                        
                        @php
                            $hariKontrol = \Carbon\Carbon::parse($rekamMedis->tanggal_kontrol)->diffInDays(now());
                        @endphp
                        
                        @if($hariKontrol <= 7)
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Reminder:</strong> Kontrol dalam {{ $hariKontrol }} hari lagi
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Print functionality enhancement
    window.addEventListener('beforeprint', function() {
        document.title = 'Rekam Medis - {{ $rekamMedis->dokter->name }} - {{ $rekamMedis->tanggal_pemeriksaan->format("d-m-Y") }}';
    });
</script>
@endsection