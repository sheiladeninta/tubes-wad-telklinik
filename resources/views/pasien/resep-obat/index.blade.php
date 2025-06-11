@extends('layouts.pasien')

@section('title', 'Resep Obat - Tel-Klinik')

@section('styles')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
        transition: transform 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
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
                <i class="fas fa-pills text-danger me-2"></i>
                Resep Obat
            </h2>
            <p class="text-muted mb-0">Kelola dan pantau resep obat Anda</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-prescription fa-2x mb-2"></i>
                    <h4 class="fw-bold">{{ $statistics['total'] }}</h4>
                    <small>Total Resep</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h4 class="fw-bold">{{ $statistics['pending'] }}</h4>
                    <small>Pending</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-2x mb-2"></i>
                    <h4 class="fw-bold">{{ $statistics['diproses'] }}</h4>
                    <small>Diproses</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4 class="fw-bold">{{ $statistics['siap'] }}</h4>
                    <small>Siap Diambil</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-center">
                    <i class="fas fa-hand-holding-medical fa-2x mb-2"></i>
                    <h4 class="fw-bold">{{ $statistics['diambil'] }}</h4>
                    <small>Sudah Diambil</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Aksi Cepat
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('pasien.resep-obat.siap-diambil') }}" class="btn btn-success w-100">
                                <i class="fas fa-hand-holding-medical me-2"></i>
                                Siap Diambil ({{ $statistics['siap'] }})
                            </a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('pasien.resep-obat.riwayat') }}" class="btn btn-info w-100">
                                <i class="fas fa-history me-2"></i>
                                Riwayat Resep
                            </a>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-calendar-plus me-2"></i>
                                Buat Reservasi Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pasien.resep-obat.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(\App\Models\ResepObat::getStatusOptions() as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_dari" class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('pasien.resep-obat.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Prescription List -->
    <div class="card card-custom">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Daftar Resep Obat
            </h5>
        </div>
        <div class="card-body">
            @if($resepObat->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Resep</th>
                                <th>Tanggal</th>
                                <th>Dokter</th>
                                <th>Diagnosa</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resepObat as $resep)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $resep->nomor_resep }}</strong>
                                    </td>
                                    <td>{{ $resep->tanggal_resep->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($resep->dokter->name) }}&background=dc3545&color=fff" 
                                                 class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                                            {{ $resep->dokter->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $resep->diagnosa }}">
                                            {{ $resep->diagnosa }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $resep->status_color }} status-badge">
                                            {{ $resep->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pasien.resep-obat.show', $resep) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pasien.resep-obat.download', $resep) }}" 
                                               class="btn btn-sm btn-outline-success" title="Download" target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $resepObat->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-prescription-bottle-alt fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Resep Obat</h5>
                    <p class="text-muted mb-4">Anda belum memiliki resep obat. Buat reservasi untuk konsultasi dengan dokter.</p>
                    <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Buat Reservasi
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit form when status changes
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });

    // Show loading state for buttons
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