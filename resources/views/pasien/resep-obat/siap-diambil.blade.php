@extends('layouts.pasien')
@section('title', 'Resep Siap Diambil - Tel-Klinik')
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
    .ready-card {
        border-left: 5px solid #28a745;
        background: linear-gradient(135deg, #d4edda 0%, #f8f9fa 100%);
    }
    .action-btn {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold mb-1">
                <i class="fas fa-hand-holding-medical text-success me-2"></i>
                Resep Siap Diambil
            </h2>
            <p class="text-muted mb-0">Resep obat yang sudah siap untuk diambil</p>
        </div>
        <div>
            <a href="{{ route('pasien.resep-obat.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Resep Obat
            </a>
        </div>
    </div>

    <!-- Ready Prescriptions -->
    <div class="card card-custom">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-check-circle me-2"></i>
                Daftar Resep Siap Diambil ({{ $resepObat->total() }})
            </h5>
        </div>
        <div class="card-body">
            @if($resepObat->count() > 0)
                <div class="row">
                    @foreach($resepObat as $resep)
                        <div class="col-md-12 mb-4">
                            <div class="card ready-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-2">
                                                <h5 class="text-success fw-bold mb-0 me-3">{{ $resep->nomor_resep }}</h5>
                                                <span class="badge bg-success status-badge">
                                                    {{ $resep->status_label }}
                                                </span>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <small class="text-muted">Tanggal Resep:</small>
                                                    <div class="fw-bold">{{ $resep->tanggal_resep->format('d/m/Y') }}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <small class="text-muted">Dokter:</small>
                                                    <div class="fw-bold">{{ $resep->dokter->name }}</div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Diagnosa:</small>
                                                <div class="fw-bold">{{ $resep->diagnosa }}</div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Jumlah Obat:</small>
                                                <div class="fw-bold">{{ $resep->detailResep->count() }} jenis obat</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('pasien.resep-obat.show', $resep) }}" 
                                                   class="btn btn-primary action-btn">
                                                    <i class="fas fa-eye me-2"></i>
                                                    Lihat Detail
                                                </a>
                                                <a href="{{ route('pasien.resep-obat.download', $resep) }}" 
                                                   class="btn btn-success action-btn" target="_blank">
                                                    <i class="fas fa-download me-2"></i>
                                                    Download
                                                </a>
                                                <form action="{{ route('pasien.resep-obat.konfirmasi-ambil', $resep) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning action-btn w-100" 
                                                            onclick="return confirm('Konfirmasi bahwa Anda sudah mengambil resep ini?')">
                                                        <i class="fas fa-check me-2"></i>
                                                        Sudah Diambil
                                                    </button>
                                                </form>
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
                    {{ $resepObat->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-hand-holding-medical fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Resep Siap Diambil</h5>
                    <p class="text-muted mb-4">Saat ini tidak ada resep obat yang siap diambil.</p>
                    <a href="{{ route('pasien.resep-obat.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i>
                        Lihat Semua Resep
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Information Card -->
    <div class="card card-custom mt-4">
        <div class="card-body">
            <h6 class="text-primary mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Informasi Pengambilan Obat
            </h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-clock text-primary me-2"></i>
                            Jam operasional: 08:00 - 20:00 WIB
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-id-card text-primary me-2"></i>
                            Bawa kartu identitas dan nomor resep
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            Lokasi: Apotek Tel-Klinik
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            Hubungi: (021) 123-4567
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // Show loading state for forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse me-2"></i>Memproses...';
                submitBtn.disabled = true;
            }
        });
    });
</script>
@endsection