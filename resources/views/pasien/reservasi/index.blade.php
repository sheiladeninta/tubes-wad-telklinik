@extends('layouts.pasien')
@section('title', 'Riwayat Reservasi - Tel-Klinik')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">
                <i class="fas fa-calendar-check me-2" style="color: #dc3545;"></i>
                Riwayat Reservasi
            </h1>
            <p class="text-muted mb-0">Kelola dan pantau status reservasi Anda</p>
        </div>
        <div>
            <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-danger" style="background: linear-gradient(135deg, #dc3545, #b02a37); border: none; border-radius: 8px; padding: 12px 24px;">
                <i class="fas fa-plus me-2"></i>Buat Reservasi Baru
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 8px; border: none; background: #d1edff;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 8px; border: none;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ffeaa7, #fdcb6e);">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x mb-2" style="color: #e17055;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('status', 'pending')->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Menunggu Konfirmasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #a8e6cf, #74b9ff);">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #00b894;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('status', 'confirmed')->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Terkonfirmasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #fd79a8, #e84393);">
                <div class="card-body">
                    <i class="fas fa-times-circle fa-2x mb-2" style="color: #d63031;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('status', 'cancelled')->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Dibatalkan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #dda0dd, #b19cd9);">
                <div class="card-body">
                    <i class="fas fa-user-md fa-2x mb-2" style="color: #6c5ce7;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('status', 'completed')->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="card-body">
            <form method="GET" action="{{ route('pasien.reservasi.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" style="border-radius: 8px;">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select" style="border-radius: 8px;">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select" style="border-radius: 8px;">
                            <option value="">Semua Tahun</option>
                            @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2" style="border-radius: 8px;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('pasien.reservasi.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reservasi List -->
    <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 12px 12px 0 0;">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Daftar Reservasi
            </h5>
        </div>
        <div class="card-body p-0">
            @if($reservasis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="padding: 15px; border: none;">#</th>
                                <th style="padding: 15px; border: none;">Dokter</th>
                                <th style="padding: 15px; border: none;">Tanggal & Waktu</th>
                                <th style="padding: 15px; border: none;">Keluhan</th>
                                <th style="padding: 15px; border: none;">Status</th>
                                <th style="padding: 15px; border: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservasis as $index => $reservasi)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 20px; vertical-align: middle;">
                                        {{ ($reservasis->currentPage() - 1) * $reservasis->perPage() + $loop->iteration }}
                                    </td>
                                    <td style="padding: 20px; vertical-align: middle;">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user-md text-white"></i>
                                            </div>
                                            <div>
                                                <strong style="color: #2c3e50;">{{ $reservasi->dokter->name ?? 'Dokter tidak ditemukan' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $reservasi->dokter->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 20px; vertical-align: middle;">
                                        <div>
                                            <strong style="color: #2c3e50;">
                                                <i class="fas fa-calendar me-1" style="color: #dc3545;"></i>
                                                {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('d F Y') }}
                                            </strong>
                                            <br>
                                            <span class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi)->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </td>
                                    <td style="padding: 20px; vertical-align: middle;">
                                        <div style="max-width: 200px;">
                                            {{ Str::limit($reservasi->keluhan, 50) }}
                                            @if(strlen($reservasi->keluhan) > 50)
                                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#keluhanModal{{ $reservasi->id }}">
                                                    Selengkapnya...
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 20px; vertical-align: middle;">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu'],
                                                'confirmed' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Terkonfirmasi'],
                                                'completed' => ['class' => 'primary', 'icon' => 'user-md', 'text' => 'Selesai'],
                                                'cancelled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Dibatalkan'],
                                            ];
                                            $config = $statusConfig[$reservasi->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Unknown'];
                                        @endphp
                                        <span class="badge bg-{{ $config['class'] }}" style="padding: 8px 12px; border-radius: 20px; font-size: 12px;">
                                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td style="padding: 20px; vertical-align: middle; text-align: center;">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pasien.reservasi.show', $reservasi) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               style="border-radius: 6px;" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if(in_array($reservasi->status, ['pending', 'confirmed']))
                                                @php
                                                    // Perbaiki parsing datetime
                                                    $tanggalReservasi = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
                                                    $jamReservasi = \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi);
                                                    $reservasiDateTime = $tanggalReservasi->setTime($jamReservasi->hour, $jamReservasi->minute);
                                                    $canCancel = $reservasiDateTime->diffInHours(now()) >= 2;
                                                @endphp
                                                
                                                @if($canCancel)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger ms-1" 
                                                            style="border-radius: 6px;" 
                                                            title="Batalkan Reservasi"
                                                            onclick="confirmCancel({{ $reservasi->id }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @else
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-secondary ms-1" 
                                                            style="border-radius: 6px; opacity: 0.5;" 
                                                            title="Tidak dapat dibatalkan (< 2 jam)"
                                                            disabled>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Keluhan -->
                                @if(strlen($reservasi->keluhan) > 50)
                                    <div class="modal fade" id="keluhanModal{{ $reservasi->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 12px;">
                                                <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 12px 12px 0 0;">
                                                    <h5 class="modal-title">Detail Keluhan</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ $reservasi->keluhan }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3">
                    <div class="text-muted">
                        Menampilkan {{ $reservasis->firstItem() ?? 0 }} - {{ $reservasis->lastItem() ?? 0 }} 
                        dari {{ $reservasis->total() }} reservasi
                    </div>
                    <div>
                        {{ $reservasis->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Reservasi</h5>
                    <p class="text-muted">Anda belum memiliki riwayat reservasi. Buat reservasi pertama Anda sekarang!</p>
                    <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-danger" style="border-radius: 8px;">
                        <i class="fas fa-plus me-2"></i>Buat Reservasi Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545, #b02a37); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Pembatalan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan reservasi ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmCancel(reservasiId) {
    const form = document.getElementById('cancelForm');
    form.action = `/pasien/reservasi/${reservasiId}/cancel`;
    
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection