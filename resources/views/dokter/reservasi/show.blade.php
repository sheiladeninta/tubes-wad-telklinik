@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

@extends('layouts.dokter')

@section('title', 'Detail Reservasi - ' . $reservasi->user->name)

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
                <p class="text-muted mb-0">Informasi lengkap reservasi pasien</p>
            </div>
            <div>
                <a href="{{ route('dokter.reservasi.index') }}" class="btn btn-outline-secondary">
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
            <!-- Patient Information Card -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title mb-0" style="color: #2c3e50; font-weight: 600;">
                            <i class="fas fa-user-injured me-2" style="color: #dc3545;"></i>
                            Informasi Pasien
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reservasi->user->name) }}&background=dc3545&color=fff&size=120" 
                                 class="rounded-circle mb-3" width="120" height="120" alt="Avatar Pasien">
                            <h4 class="mb-1 fw-bold">{{ $reservasi->user->name }}</h4>
                            <p class="text-muted mb-0">{{ $reservasi->user->email }}</p>
                        </div>

                        <div class="border-top pt-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-muted me-3" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block">Nomor Telepon</small>
                                            <span>{{ $reservasi->user->phone ?? 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar text-muted me-3" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block">Umur</small>
                                            <span>{{ $reservasi->user->birth_date ? Carbon::parse($reservasi->user->birth_date)->age . ' tahun' : 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-venus-mars text-muted me-3" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block">Jenis Kelamin</small>
                                            <span>{{ $reservasi->user->gender ?? 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-muted me-3" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block">Alamat</small>
                                            <span>{{ $reservasi->user->address ?? 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <span class="badge bg-{{ $reservasi->status_badge_class }} px-3 py-2
                                @if($reservasi->status_badge_class == 'warning') text-dark @endif">
                                {{ $reservasi->status_label }}
                            </span>
                        </div>

                        <!-- Reservation Info -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-day text-primary me-2"></i>
                                        <strong>Tanggal Reservasi</strong>
                                    </div>
                                    <h5 class="mb-0 text-primary">{{ $reservasi->tanggal_reservasi->format('d F Y') }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock text-info me-2"></i>
                                        <strong>Jam Reservasi</strong>
                                    </div>
                                    <h5 class="mb-0 text-info">{{ Carbon::parse($reservasi->jam_reservasi)->format('H:i') }} WIB</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-notes-medical text-warning me-2"></i>
                                        <strong>Keluhan Pasien</strong>
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
                                    <p class="mb-0">{{ $reservasi->created_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-edit text-secondary me-2"></i>
                                        <strong>Terakhir Update</strong>
                                    </div>
                                    <p class="mb-0">{{ $reservasi->updated_at->format('d F Y, H:i') }} WIB</p>
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
                        <div class="border-top pt-4 mt-4">
                            <div class="row g-2">
                                @if($reservasi->status == App\Models\Reservasi::STATUS_PENDING)
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('dokter.reservasi.confirm', $reservasi) }}" class="d-inline w-100">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success w-100" 
                                                    onclick="return confirm('Konfirmasi reservasi ini?')">
                                                <i class="fas fa-check me-2"></i>Konfirmasi Reservasi
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger w-100" 
                                                data-bs-toggle="modal" data-bs-target="#cancelModal">
                                            <i class="fas fa-times me-2"></i>Batalkan Reservasi
                                        </button>
                                    </div>
                                @elseif($reservasi->status == App\Models\Reservasi::STATUS_CONFIRMED)
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-info w-100" 
                                                data-bs-toggle="modal" data-bs-target="#completeModal">
                                            <i class="fas fa-check-double me-2"></i>Selesaikan Reservasi
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger w-100" 
                                                data-bs-toggle="modal" data-bs-target="#cancelModal">
                                            <i class="fas fa-times me-2"></i>Batalkan Reservasi
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Complete Modal -->
@if($reservasi->status == App\Models\Reservasi::STATUS_CONFIRMED)
    <div class="modal fade" id="completeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-check-double text-info me-2"></i>
                        Selesaikan Reservasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('dokter.reservasi.complete', $reservasi) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Apakah Anda yakin ingin menyelesaikan reservasi dengan <strong>{{ $reservasi->user->name }}</strong>?
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-notes-medical me-1"></i>
                                Catatan Dokter (Opsional)
                            </label>
                            <textarea class="form-control" name="catatan_dokter" rows="4" 
                                      placeholder="Tambahkan catatan hasil konsultasi, diagnosis, atau rekomendasi pengobatan..."></textarea>
                            <div class="form-text">Catatan ini akan tersimpan dalam riwayat reservasi pasien.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-check-double me-1"></i>Selesaikan Reservasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Cancel Modal -->
@if(in_array($reservasi->status, [App\Models\Reservasi::STATUS_PENDING, App\Models\Reservasi::STATUS_CONFIRMED]))
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-times text-danger me-2"></i>
                        Batalkan Reservasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('dokter.reservasi.cancel', $reservasi) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Apakah Anda yakin ingin membatalkan reservasi dengan <strong>{{ $reservasi->user->name }}</strong>?
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-comment-alt me-1"></i>
                                Alasan Pembatalan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="catatan_dokter" rows="4" 
                                      placeholder="Jelaskan alasan pembatalan reservasi ini..." required></textarea>
                            <div class="form-text">Alasan pembatalan akan dikirimkan kepada pasien.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i>Batalkan Reservasi
                        </button>
                    </div>
                </form>
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

    // Form validation
    $('form').on('submit', function(e) {
        const form = this;
        const requiredFields = $(form).find('[required]');
        let isValid = true;

        requiredFields.each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });

    // Remove validation class on input
    $('input, textarea, select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endsection