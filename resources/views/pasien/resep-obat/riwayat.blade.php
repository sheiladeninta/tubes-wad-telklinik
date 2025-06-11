@extends('layouts.pasien')
@section('title', 'Riwayat Resep Obat - Tel-Klinik')
@section('styles')
<style>
    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .card-custom:hover {
        transform: translateY(-2px);
    }
    .status-badge {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
    .history-card {
        border-left: 5px solid #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }
    .timeline-item {
        position: relative;
        padding-left: 30px;
        border-left: 2px solid #dee2e6;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -6px;
        top: 10px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #28a745;
    }
    .timeline-item:last-child {
        border-left: none;
    }
    .filter-card {
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold mb-1">
                <i class="fas fa-history text-info me-2"></i>
                Riwayat Resep Obat
            </h2>
            <p class="text-muted mb-0">Riwayat resep obat yang sudah diambil</p>
        </div>
        <div>
            <a href="{{ route('pasien.resep-obat.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Resep Obat
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pasien.resep-obat.riwayat') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="tanggal_dari" class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-4">
                    <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('pasien.resep-obat.riwayat') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- History List -->
    <div class="card card-custom">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-clipboard-list me-2"></i>
                Riwayat Resep ({{ $resepObat->total() }})
            </h5>
        </div>
        <div class="card-body">
            @if($resepObat->count() > 0)
                <div class="row">
                    @foreach($resepObat as $resep)
                        <div class="col-md-12 mb-4">
                            <div class="card history-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-3">
                                                <h5 class="text-primary fw-bold mb-0 me-3">{{ $resep->nomor_resep }}</h5>
                                                <span class="badge bg-secondary status-badge">
                                                    {{ $resep->status_label }}
                                                </span>
                                            </div>
                                            
                                            <div class="timeline-item mb-3">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <small class="text-muted">Tanggal Resep:</small>
                                                        <div class="fw-bold">{{ $resep->tanggal_resep->format('d/m/Y H:i') }}</div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <small class="text-muted">Tanggal Diambil:</small>
                                                        <div class="fw-bold text-success">{{ $resep->tanggal_ambil ? $resep->tanggal_ambil->format('d/m/Y H:i') : '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-item mb-3">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <small class="text-muted">Dokter:</small>
                                                        <div class="fw-bold">{{ $resep->dokter->name }}</div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <small class="text-muted">Jumlah Obat:</small>
                                                        <div class="fw-bold">{{ $resep->detailResep->count() }} jenis obat</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <small class="text-muted">Diagnosa:</small>
                                                <div class="fw-bold">{{ $resep->diagnosa }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('pasien.resep-obat.show', $resep) }}" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-eye me-2"></i>
                                                    Lihat Detail
                                                </a>
                                                <a href="{{ route('pasien.resep-obat.download', $resep) }}" 
                                                   class="btn btn-outline-success" target="_blank">
                                                    <i class="fas fa-download me-2"></i>
                                                    Download
                                                </a>
                                                @if($resep->tanggal_ambil)
                                                    <small class="text-muted mt-2">
                                                        <i class="fas fa-calendar-check me-1"></i>
                                                        Diambil: {{ $resep->tanggal_ambil->diffForHumans() }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $resepObat->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Riwayat</h5>
                    <p class="text-muted mb-4">Anda belum memiliki riwayat resep obat yang sudah diambil.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('pasien.resep-obat.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>
                            Lihat Semua Resep
                        </a>
                        <a href="{{ route('pasien.resep-obat.siap-diambil') }}" class="btn btn-success">
                            <i class="fas fa-hand-holding-medical me-2"></i>
                            Resep Siap Diambil
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Card -->
    @if($resepObat->count() > 0)
        <div class="card card-custom mt-4">
            <div class="card-body">
                <h6 class="text-info mb-3">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Riwayat
                </h6>
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-primary fw-bold">{{ $resepObat->total() }}</h4>
                            <small class="text-muted">Total Resep Diambil</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-success fw-bold">{{ $resepObat->where('tanggal_ambil', '>=', now()->startOfMonth())->count() }}</h4>
                            <small class="text-muted">Bulan Ini</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-info fw-bold">{{ $resepObat->where('tanggal_ambil', '>=', now()->startOfYear())->count() }}</h4>
                            <small class="text-muted">Tahun Ini</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning fw-bold">{{ $resepObat->first()?->tanggal_ambil?->diffInDays($resepObat->last()?->tanggal_ambil) ?? 0 }}</h4>
                        <small class="text-muted">Rentang Hari</small>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
@section('scripts')
<script>
    // Show loading state for forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse me-1"></i>Loading...';
                submitBtn.disabled = true;
            }
        });
    });
</script>
@endsection