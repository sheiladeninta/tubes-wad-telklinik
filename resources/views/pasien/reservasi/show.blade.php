@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.pasien')

@section('title', 'Detail Reservasi - Tel-Klinik')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">
                <i class="fas fa-eye me-2" style="color: #dc3545;"></i>
                Detail Reservasi
            </h1>
            <p class="text-muted mb-0">Informasi lengkap reservasi Anda</p>
        </div>
        <div>
            <a href="{{ route('pasien.reservasi.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; padding: 12px 24px;">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
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

    <div class="row">
        <!-- Main Info Card -->
        <div class="col-lg-8">
            <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Reservasi
                    </h5>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <!-- Status Badge -->
                    <div class="mb-4">
                        @php
                            $statusConfig = [
                                'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu Konfirmasi', 'bg' => '#fff3cd'],
                                'confirmed' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Terkonfirmasi', 'bg' => '#d1edff'],
                                'completed' => ['class' => 'primary', 'icon' => 'user-md', 'text' => 'Selesai', 'bg' => '#e7f3ff'],
                                'cancelled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Dibatalkan', 'bg' => '#f8d7da'],
                            ];
                            $config = $statusConfig[$reservasi->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Unknown', 'bg' => '#f8f9fa'];
                        @endphp
                        <div class="alert" style="background: {{ $config['bg'] }}; border: none; border-radius: 8px; padding: 15px;">
                            <span class="badge bg-{{ $config['class'] }}" style="padding: 10px 15px; border-radius: 20px; font-size: 14px;">
                                <i class="fas fa-{{ $config['icon'] }} me-2"></i>{{ $config['text'] }}
                            </span>
                            @if($reservasi->status == 'pending')
                                <p class="mb-0 mt-2 text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Reservasi Anda sedang menunggu konfirmasi dari dokter. Harap bersabar.
                                </p>
                            @elseif($reservasi->status == 'confirmed')
                                <p class="mb-0 mt-2 text-muted">
                                    <i class="fas fa-check me-1"></i>
                                    Reservasi telah dikonfirmasi. Harap datang tepat waktu.
                                </p>
                            @elseif($reservasi->status == 'completed')
                                <p class="mb-0 mt-2 text-muted">
                                    <i class="fas fa-thumbs-up me-1"></i>
                                    Konsultasi telah selesai dilaksanakan.
                                </p>
                            @elseif($reservasi->status == 'cancelled')
                                <p class="mb-0 mt-2 text-muted">
                                    <i class="fas fa-ban me-1"></i>
                                    Reservasi telah dibatalkan.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Reservasi Details -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item" style="padding: 20px; background: linear-gradient(135deg, #ffeaa7, #fdcb6e); border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-3" style="width: 50px; height: 50px; background: rgba(225, 112, 85, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-calendar-alt fa-lg" style="color: #e17055;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1" style="color: #2d3436; font-weight: 600;">Tanggal Reservasi</h6>
                                        <p class="mb-0" style="color: #636e72; font-size: 16px; font-weight: 500;">
                                            {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item" style="padding: 20px; background: linear-gradient(135deg, #a8e6cf, #74b9ff); border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon me-3" style="width: 50px; height: 50px; background: rgba(0, 184, 148, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-clock fa-lg" style="color: #00b894;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1" style="color: #2d3436; font-weight: 600;">Waktu</h6>
                                        <p class="mb-0" style="color: #636e72; font-size: 16px; font-weight: 500;">
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi)->format('H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-item" style="padding: 20px; background: linear-gradient(135deg, #fd79a8, #e84393); border-radius: 10px;">
                                <div class="d-flex align-items-start">
                                    <div class="info-icon me-3" style="width: 50px; height: 50px; background: rgba(214, 48, 49, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fas fa-stethoscope fa-lg" style="color: #d63031;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-2" style="color: #2d3436; font-weight: 600;">Keluhan</h6>
                                        <div style="background: rgba(255,255,255,0.3); padding: 15px; border-radius: 8px;">
                                            <p class="mb-0" style="color: #2d3436; line-height: 1.6;">
                                                {{ $reservasi->keluhan }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Doctor Info Card -->
            <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="card-header" style="background: linear-gradient(135deg, #dda0dd, #b19cd9); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md me-2"></i>Informasi Dokter
                    </h5>
                </div>
                <div class="card-body text-center" style="padding: 30px;">
                    <div class="doctor-avatar mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user-md fa-2x text-white"></i>
                    </div>
                    <h5 style="color: #2c3e50; font-weight: 600;">{{ $reservasi->dokter->name ?? 'Dokter tidak ditemukan' }}</h5>
                    <p class="text-muted mb-3">{{ $reservasi->dokter->email ?? '' }}</p>
                    
                    @if($reservasi->dokter && $reservasi->dokter->profile)
                        <div class="doctor-details text-start">
                            @if($reservasi->dokter->profile->specialization)
                                <div class="mb-2">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                                    <small>{{ $reservasi->dokter->profile->specialization }}</small>
                                </div>
                            @endif
                            @if($reservasi->dokter->profile->phone)
                                <div class="mb-2">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <small>{{ $reservasi->dokter->profile->phone }}</small>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Card -->
            @if(in_array($reservasi->status, ['pending', 'confirmed']))
                <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div class="card-header" style="background: linear-gradient(135deg, #dc3545, #b02a37); color: white; border-radius: 12px 12px 0 0;">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs me-2"></i>Aksi
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        @php
                            // Perbaiki parsing datetime
                            $tanggalReservasi = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
                            $jamReservasi = \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi);
                            $reservasiDateTime = $tanggalReservasi->setTime($jamReservasi->hour, $jamReservasi->minute);
                            $canCancel = $reservasiDateTime->diffInHours(now()) >= 2;
                            $timeUntilAppointment = $reservasiDateTime->diffInHours(now());
                        @endphp

                        @if($canCancel)
                            <button type="button" 
                                    class="btn btn-danger w-100" 
                                    style="border-radius: 8px; padding: 12px;"
                                    onclick="confirmCancel({{ $reservasi->id }})">
                                <i class="fas fa-times me-2"></i>Batalkan Reservasi
                            </button>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Reservasi dapat dibatalkan hingga 2 jam sebelum jadwal
                            </small>
                        @else
                            <button type="button" 
                                    class="btn btn-secondary w-100" 
                                    style="border-radius: 8px; padding: 12px; opacity: 0.6;"
                                    disabled>
                                <i class="fas fa-times me-2"></i>Tidak Dapat Dibatalkan
                            </button>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Tidak dapat dibatalkan (kurang dari 2 jam)
                            </small>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Additional Info Card -->
            <div class="card mt-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="card-header" style="background: linear-gradient(135deg, #74b9ff, #0984e3); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-info me-2"></i>Informasi Tambahan
                    </h5>
                </div>
                <div class="card-body" style="padding: 20px;">
                    <div class="info-row mb-3">
                        <small class="text-muted">ID Reservasi:</small>
                        <div style="font-family: monospace; font-weight: 600; color: #2c3e50;">
                            #{{ str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                    
                    <div class="info-row mb-3">
                        <small class="text-muted">Dibuat pada:</small>
                        <div style="color: #2c3e50;">
                            {{ $reservasi->created_at->translatedFormat('d F Y, H:i') }} WIB
                        </div>
                    </div>

                    @if($reservasi->updated_at != $reservasi->created_at)
                        <div class="info-row">
                            <small class="text-muted">Terakhir diupdate:</small>
                            <div style="color: #2c3e50;">
                                {{ $reservasi->updated_at->translatedFormat('d F Y, H:i') }} WIB
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <h6 class="text-center mb-3">Apakah Anda yakin ingin membatalkan reservasi ini?</h6>
                <div class="alert alert-warning" style="border: none; border-radius: 8px;">
                    <strong>Detail Reservasi:</strong><br>
                    <i class="fas fa-user-md me-1"></i> {{ $reservasi->dokter->name ?? 'Dokter tidak ditemukan' }}<br>
                    <i class="fas fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('d F Y') }}<br>
                    <i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi)->format('H:i') }} WIB
                </div>
                <p class="text-muted text-center">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-1"></i>Batal
                </button>
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Ya, Batalkan Reservasi
                    </button>
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

<style>
.info-item {
    transition: transform 0.2s ease;
}

.info-item:hover {
    transform: translateY(-2px);
}

.doctor-avatar {
    transition: transform 0.3s ease;
}

.doctor-avatar:hover {
    transform: scale(1.05);
}

.info-row {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 15px;
    }
    
    .card-body {
        padding: 20px !important;
    }
}
</style>
@endsection