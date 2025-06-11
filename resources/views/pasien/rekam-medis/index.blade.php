@extends('layouts.pasien')

@section('title', 'Rekam Medis - Tel-Klinik')

@section('styles')
<style>
    .medical-record-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .medical-record-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .filter-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .stats-card {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        color: white;
        border-radius: 12px;
        border: none;
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        color: white;
    }
    
    .vital-signs {
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        border-radius: 8px;
        padding: 1rem;
        margin: 0.5rem 0;
    }
    
    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-file-medical text-danger me-2"></i>
                        Rekam Medis Saya
                    </h2>
                    <p class="text-muted mb-0">Riwayat pemeriksaan dan catatan kesehatan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-medical fa-2x mb-3"></i>
                    <h3 class="fw-bold">{{ $rekamMedis->total() }}</h3>
                    <p class="mb-0">Total Rekam Medis</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-month fa-2x mb-3"></i>
                    <h3 class="fw-bold">{{ $rekamMedis->where('tanggal_pemeriksaan', '>=', now()->startOfMonth())->count() }}</h3>
                    <p class="mb-0">Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-2x mb-3"></i>
                    <h3 class="fw-bold">{{ $dokters->count() }}</h3>
                    <p class="mb-0">Dokter Berbeda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pasien.rekam-medis.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label fw-semibold">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="dokter_id" class="form-label fw-semibold">Dokter</label>
                        <select class="form-select" id="dokter_id" name="dokter_id">
                            <option value="">Semua Dokter</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Medical Records List -->
    <div class="row">
        @forelse($rekamMedis as $rekam)
        <div class="col-12 mb-4">
            <div class="card medical-record-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">
                                        Pemeriksaan - {{ $rekam->tanggal_pemeriksaan->format('d M Y') }}
                                    </h5>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-user-md me-2"></i>
                                        Dr. {{ $rekam->dokter->name }}
                                    </p>
                                </div>
                                <span class="badge badge-status bg-success">
                                    {{ ucfirst($rekam->status) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-semibold text-dark mb-2">Keluhan:</h6>
                                <p class="text-muted">{{ Str::limit($rekam->keluhan, 150) }}</p>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-semibold text-dark mb-2">Diagnosa:</h6>
                                <p class="text-primary fw-medium">{{ Str::limit($rekam->diagnosa, 150) }}</p>
                            </div>

                            @if($rekam->tinggi_badan || $rekam->berat_badan || $rekam->tekanan_darah)
                            <div class="vital-signs">
                                <h6 class="fw-semibold text-dark mb-2">Tanda Vital:</h6>
                                <div class="row">
                                    @if($rekam->tinggi_badan && $rekam->berat_badan)
                                    <div class="col-md-3">
                                        <small class="text-muted">BMI</small>
                                        <div class="fw-semibold">{{ $rekam->bmi }} ({{ $rekam->kategori_bmi }})</div>
                                    </div>
                                    @endif
                                    @if($rekam->tekanan_darah)
                                    <div class="col-md-3">
                                        <small class="text-muted">Tekanan Darah</small>
                                        <div class="fw-semibold">{{ $rekam->tekanan_darah }} mmHg</div>
                                    </div>
                                    @endif
                                    @if($rekam->suhu_tubuh)
                                    <div class="col-md-3">
                                        <small class="text-muted">Suhu</small>
                                        <div class="fw-semibold">{{ $rekam->suhu_tubuh }}°C</div>
                                    </div>
                                    @endif
                                    @if($rekam->nadi)
                                    <div class="col-md-3">
                                        <small class="text-muted">Nadi</small>
                                        <div class="fw-semibold">{{ $rekam->nadi }} bpm</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4 text-end">
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('pasien.rekam-medis.show', $rekam) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                                <a href="{{ route('pasien.rekam-medis.download', $rekam) }}" 
                                   class="btn btn-outline-success">
                                    <i class="fas fa-download me-2"></i>Unduh PDF
                                </a>
                            </div>
                            
                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $rekam->tanggal_pemeriksaan->format('H:i') }} WIB
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-medical fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-2">Belum Ada Rekam Medis</h5>
                    <p class="text-muted">Anda belum memiliki catatan rekam medis. Rekam medis akan otomatis dibuat setelah pemeriksaan dengan dokter.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($rekamMedis->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $rekamMedis->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit form when date changes
    document.getElementById('start_date').addEventListener('change', function() {
        if (document.getElementById('end_date').value) {
            document.querySelector('form').submit();
        }
    });

    document.getElementById('end_date').addEventListener('change', function() {
        if (document.getElementById('start_date').value) {
            document.querySelector('form').submit();
        }
    });
</script>
@endsection