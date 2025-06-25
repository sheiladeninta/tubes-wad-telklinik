@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.dokter')

@section('title', 'Daftar Reservasi Pasien')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1" style="color: #2c3e50; font-weight: 600;">
                    <i class="fas fa-calendar-alt me-2" style="color: #dc3545;"></i>
                    Daftar Reservasi Pasien
                </h2>
                <p class="text-muted mb-0">Kelola reservasi dan janji temu dengan pasien</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #b02a37);">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                                <p class="mb-0 opacity-75">Total Reservasi</p>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffc107, #ffb300);">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0 fw-bold">{{ $stats['pending'] }}</h3>
                                <p class="mb-0 opacity-75">Menunggu Konfirmasi</p>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0 fw-bold">{{ $stats['confirmed'] }}</h3>
                                <p class="mb-0 opacity-75">Dikonfirmasi</p>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0 fw-bold">{{ $stats['completed'] }}</h3>
                                <p class="mb-0 opacity-75">Selesai</p>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-check-double fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dokter.reservasi.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Cari Pasien</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Nama atau email pasien...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                @foreach(App\Models\Reservasi::getStatusOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('dokter.reservasi.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Reservasi Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($reservasis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3">Pasien</th>
                                    <th class="border-0 px-4 py-3">Tanggal & Jam</th>
                                    <th class="border-0 px-4 py-3">Keluhan</th>
                                    <th class="border-0 px-4 py-3">Status</th>
                                    <th class="border-0 px-4 py-3">Dibuat</th>
                                    <th class="border-0 px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservasis as $reservasi)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($reservasi->user->name) }}&background=dc3545&color=fff" 
                                                     class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $reservasi->user->name }}</h6>
                                                    <small class="text-muted">{{ $reservasi->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="fw-semibold">{{ $reservasi->tanggal_reservasi->format('d M Y') }}</div>
                                                <small class="text-muted">{{ Carbon\Carbon::parse($reservasi->jam_reservasi)->format('H:i') }} WIB</small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div style="max-width: 200px;">
                                                <p class="mb-0 text-truncate" title="{{ $reservasi->keluhan }}">
                                                    {{ Str::limit($reservasi->keluhan, 50) }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $reservasi->status_badge_class }} px-3 py-2
                                                @if($reservasi->status_badge_class == 'warning') text-dark @endif">
                                                {{ $reservasi->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ $reservasi->created_at->format('d M Y H:i') }}</small>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('dokter.reservasi.show', $reservasi) }}">
                                                            <i class="fas fa-eye me-2"></i>Detail
                                                        </a>
                                                    </li>
                                                    @if($reservasi->status == App\Models\Reservasi::STATUS_PENDING)
                                                        <li>
                                                            <form method="POST" action="{{ route('dokter.reservasi.confirm', $reservasi) }}" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item text-success" 
                                                                        onclick="return confirm('Konfirmasi reservasi ini?')">
                                                                    <i class="fas fa-check me-2"></i>Konfirmasi
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    @if($reservasi->status == App\Models\Reservasi::STATUS_CONFIRMED)
                                                        <li>
                                                            <button type="button" class="dropdown-item text-info" 
                                                                    data-bs-toggle="modal" data-bs-target="#completeModal{{ $reservasi->id }}">
                                                                <i class="fas fa-check-double me-2"></i>Selesaikan
                                                            </button>
                                                        </li>
                                                    @endif
                                                    @if(in_array($reservasi->status, [App\Models\Reservasi::STATUS_PENDING, App\Models\Reservasi::STATUS_CONFIRMED]))
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button type="button" class="dropdown-item text-danger" 
                                                                    data-bs-toggle="modal" data-bs-target="#cancelModal{{ $reservasi->id }}">
                                                                <i class="fas fa-times me-2"></i>Batalkan
                                                            </button>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Complete Modal -->
                                    @if($reservasi->status == App\Models\Reservasi::STATUS_CONFIRMED)
                                        <div class="modal fade" id="completeModal{{ $reservasi->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Selesaikan Reservasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('dokter.reservasi.complete', $reservasi) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menyelesaikan reservasi dengan <strong>{{ $reservasi->user->name }}</strong>?</p>
                                                            <div class="mb-3">
                                                                <label class="form-label">Catatan Dokter (Opsional)</label>
                                                                <textarea class="form-control" name="catatan_dokter" rows="3" 
                                                                          placeholder="Tambahkan catatan atau hasil konsultasi..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Selesaikan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Cancel Modal -->
                                    @if(in_array($reservasi->status, [App\Models\Reservasi::STATUS_PENDING, App\Models\Reservasi::STATUS_CONFIRMED]))
                                        <div class="modal fade" id="cancelModal{{ $reservasi->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Batalkan Reservasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('dokter.reservasi.cancel', $reservasi) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin membatalkan reservasi dengan <strong>{{ $reservasi->user->name }}</strong>?</p>
                                                            <div class="mb-3">
                                                                <label class="form-label">Alasan Pembatalan</label>
                                                                <textarea class="form-control" name="catatan_dokter" rows="3" 
                                                                          placeholder="Jelaskan alasan pembatalan..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Batalkan Reservasi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada reservasi</h5>
                        <p class="text-muted">Reservasi dari pasien akan tampil di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if($reservasis->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $reservasis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto refresh every 30 seconds
    setInterval(function() {
        location.reload();
    }, 30000);
    
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection