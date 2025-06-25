@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp
@extends('layouts.pasien')
@section('title', 'Detail Reservasi - Tel-Klinik')
@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1" style="color: #2c3e50; font-weight: 600;">
                    <i class="fas fa-file-medical me-2" style="color: #dc3545;"></i>
                    Detail Reservasi
                </h2>
                <p class="text-muted mb-0">Informasi lengkap reservasi Anda</p>
            </div>
            <div>
                <a href="{{ route('pasien.reservasi.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
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

        <div class="row">
            <!-- Doctor Information Card -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-user-md me-2" style="color: #dc3545;"></i>
                            Informasi Dokter
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reservasi->dokter->name ?? 'Dokter') }}&background=dc3545&color=fff&size=120" 
                                 class="rounded-circle mb-3" width="120" height="120" alt="Avatar Dokter">
                            <h4 class="mb-1 fw-bold">{{ $reservasi->dokter->name ?? 'Dokter tidak ditemukan' }}</h4>
                            <p class="text-muted mb-0">{{ $reservasi->dokter->email ?? '' }}</p>
                        </div>
                        @if($reservasi->dokter && $reservasi->dokter->profile)
                            <div class="border-top pt-3">
                                <div class="row g-3">
                                    @if($reservasi->dokter->profile->specialization)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-graduation-cap text-muted me-3" style="width: 20px;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Spesialisasi</small>
                                                    <span>{{ $reservasi->dokter->profile->specialization }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($reservasi->dokter->profile->phone)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-phone text-muted me-3" style="width: 20px;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Nomor Telepon</small>
                                                    <span>{{ $reservasi->dokter->profile->phone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($reservasi->dokter->profile->experience_years)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-award text-muted me-3" style="width: 20px;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Pengalaman</small>
                                                    <span>{{ $reservasi->dokter->profile->experience_years }} tahun</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Reservation Details -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-calendar-check me-2" style="color: #dc3545;"></i>
                            Detail Reservasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Status Badge -->
                        <div class="mb-4 text-center">
                            @php
                                $statusConfig = [
                                    'pending' => ['class' => 'warning', 'text' => 'Menunggu Konfirmasi'],
                                    'confirmed' => ['class' => 'success', 'text' => 'Terkonfirmasi'],
                                    'completed' => ['class' => 'primary', 'text' => 'Selesai'],
                                    'cancelled' => ['class' => 'danger', 'text' => 'Dibatalkan'],
                                ];
                                $config = $statusConfig[$reservasi->status] ?? ['class' => 'secondary', 'text' => 'Unknown'];
                            @endphp
                            <span class="badge bg-{{ $config['class'] }} px-3 py-2 @if($config['class'] == 'warning') text-dark @endif">
                                {{ $config['text'] }}
                            </span>
                        </div>

                        <!-- Status Description -->
                        <div class="mb-4">
                            <div class="alert alert-info">
                                @if($reservasi->status == 'pending')
                                    <i class="fas fa-clock me-2"></i>
                                    Reservasi Anda sedang menunggu konfirmasi dari dokter. Harap bersabar.
                                @elseif($reservasi->status == 'confirmed')
                                    <i class="fas fa-check me-2"></i>
                                    Reservasi telah dikonfirmasi. Harap datang tepat waktu.
                                @elseif($reservasi->status == 'completed')
                                    <i class="fas fa-thumbs-up me-2"></i>
                                    Konsultasi telah selesai dilaksanakan.
                                @elseif($reservasi->status == 'cancelled')
                                    <i class="fas fa-ban me-2"></i>
                                    Reservasi telah dibatalkan.
                                @endif
                            </div>
                        </div>

                        <!-- Reservation Info -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-day text-primary me-2"></i>
                                        <strong>Tanggal Reservasi</strong>
                                    </div>
                                    <h5 class="mb-0 text-primary">{{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('d F Y') }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock text-info me-2"></i>
                                        <strong>Jam Reservasi</strong>
                                    </div>
                                    <h5 class="mb-0 text-info">{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi)->format('H:i') }} WIB</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-notes-medical text-warning me-2"></i>
                                        <strong>Keluhan</strong>
                                    </div>
                                    <p class="mb-0">{{ $reservasi->keluhan }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-plus-circle text-success me-2"></i>
                                        <strong>Dibuat Pada</strong>
                                    </div>
                                    <p class="mb-0">{{ $reservasi->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-edit text-secondary me-2"></i>
                                        <strong>Terakhir Update</strong>
                                    </div>
                                    <p class="mb-0">{{ $reservasi->updated_at->translatedFormat('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-hashtag text-muted me-2"></i>
                                        <strong>ID Reservasi</strong>
                                    </div>
                                    <p class="mb-0" style="font-family: monospace; font-weight: 600;">#{{ str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            @if($reservasi->catatan_dokter)
                                <div class="col-12">
                                    <div class="bg-light rounded p-3 border-start border-4 border-primary">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user-md text-primary me-2"></i>
                                            <strong>Catatan Dokter</strong>
                                        </div>
                                        <p class="mb-0">{{ $reservasi->catatan_dokter }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        @if(in_array($reservasi->status, ['pending', 'confirmed']))
                            <div class="border-top pt-4 mt-4">
                                <div class="row g-2">
                                    <div class="col-12">
                                        @php
                                            // Perbaiki parsing datetime
                                            $tanggalReservasi = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
                                            $jamReservasi = \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi);
                                            $reservasiDateTime = $tanggalReservasi->setTime($jamReservasi->hour, $jamReservasi->minute);
                                            $canCancel = $reservasiDateTime->diffInHours(now()) >= 2;
                                        @endphp
                                        @if($canCancel)
                                            <button type="button" 
                                                    class="btn btn-danger w-100" 
                                                    data-bs-toggle="modal" data-bs-target="#cancelModal">
                                                <i class="fas fa-times me-2"></i>Batalkan Reservasi
                                            </button>
                                            <small class="text-muted d-block mt-2 text-center">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Reservasi dapat dibatalkan hingga 2 jam sebelum jadwal
                                            </small>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-secondary w-100" 
                                                    disabled>
                                                <i class="fas fa-times me-2"></i>Tidak Dapat Dibatalkan
                                            </button>
                                            <small class="text-muted d-block mt-2 text-center">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Tidak dapat dibatalkan (kurang dari 2 jam)
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
@if(in_array($reservasi->status, ['pending', 'confirmed']))
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-times text-danger me-2"></i>
                        Konfirmasi Pembatalan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Apakah Anda yakin ingin membatalkan reservasi ini?
                    </div>
                    <div class="bg-light rounded p-3 mb-3">
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
                    <form method="POST" action="{{ route('pasien.reservasi.cancel', $reservasi->id) }}" style="display: inline;">
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
@endif
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endsection