@extends('layouts.dokter')

@section('title', 'Detail Request Surat Keterangan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">Detail Request Surat Keterangan</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dokter.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dokter.surat-keterangan.index') }}">Surat Keterangan</a>
                            </li>
                            <li class="breadcrumb-item active">Detail Request</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('dokter.surat-keterangan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Status Alert -->
            <div class="row mb-4">
                <div class="col-12">
                    @if($suratKeterangan->status === 'pending')
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Status:</strong> Menunggu persetujuan Anda
                        </div>
                    @elseif($suratKeterangan->status === 'diproses')
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-spinner me-2"></i>
                            <strong>Status:</strong> Sedang diproses
                        </div>
                    @elseif($suratKeterangan->status === 'selesai')
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Status:</strong> Surat keterangan sudah selesai dibuat
                        </div>
                    @elseif($suratKeterangan->status === 'ditolak')
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Status:</strong> Request ditolak
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Informasi Request -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-medical me-2"></i>
                                Informasi Request
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-semibold" width="140">ID Request:</td>
                                            <td>#{{ $suratKeterangan->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Jenis Surat:</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $suratKeterangan->jenis_surat_label }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal Request:</td>
                                            <td>{{ $suratKeterangan->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                        @if($suratKeterangan->tanggal_diproses)
                                        <tr>
                                            <td class="fw-semibold">Tanggal Diproses:</td>
                                            <td>{{ $suratKeterangan->tanggal_diproses->format('d M Y, H:i') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-semibold" width="140">Status:</td>
                                            <td>
                                                @if($suratKeterangan->status === 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($suratKeterangan->status === 'diproses')
                                                    <span class="badge bg-info">Diproses</span>
                                                @elseif($suratKeterangan->status === 'selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($suratKeterangan->status === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($suratKeterangan->keperluan)
                                        <tr>
                                            <td class="fw-semibold">Keperluan:</td>
                                            <td colspan="3">{{ $suratKeterangan->keperluan }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            @if($suratKeterangan->keluhan)
                            <div class="mt-3">
                                <h6 class="fw-semibold">Keluhan Pasien:</h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $suratKeterangan->keluhan }}
                                </div>
                            </div>
                            @endif

                            @if($suratKeterangan->status === 'selesai' && $suratKeterangan->diagnosa)
                            <div class="mt-3">
                                <h6 class="fw-semibold">Diagnosa:</h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $suratKeterangan->diagnosa }}
                                </div>
                            </div>
                            @endif

                            @if($suratKeterangan->status === 'selesai' && $suratKeterangan->keterangan_dokter)
                            <div class="mt-3">
                                <h6 class="fw-semibold">Keterangan Dokter:</h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $suratKeterangan->keterangan_dokter }}
                                </div>
                            </div>
                            @endif

                            @if($suratKeterangan->status === 'ditolak' && $suratKeterangan->alasan_ditolak)
                            <div class="mt-3">
                                <h6 class="fw-semibold text-danger">Alasan Penolakan:</h6>
                                <div class="bg-danger-subtle p-3 rounded border border-danger">
                                    {{ $suratKeterangan->alasan_ditolak }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informasi Pasien -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>
                                Informasi Pasien
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="fw-semibold" width="100">Nama:</td>
                                    <td>{{ $suratKeterangan->pasien->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Email:</td>
                                    <td>{{ $suratKeterangan->pasien->email }}</td>
                                </tr>
                                @if($suratKeterangan->pasien->phone)
                                <tr>
                                    <td class="fw-semibold">Telepon:</td>
                                    <td>{{ $suratKeterangan->pasien->phone }}</td>
                                </tr>
                                @endif
                                @if($suratKeterangan->pasien->date_of_birth)
                                <tr>
                                    <td class="fw-semibold">Tgl Lahir:</td>
                                    <td>{{ \Carbon\Carbon::parse($suratKeterangan->pasien->date_of_birth)->format('d M Y') }}</td>
                                </tr>
                                @endif
                                @if($suratKeterangan->pasien->address)
                                <tr>
                                    <td class="fw-semibold">Alamat:</td>
                                    <td>{{ $suratKeterangan->pasien->address }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($suratKeterangan->status === 'pending')
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tasks me-2"></i>
                                Tindakan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="fas fa-check me-1"></i> Setujui Request
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times me-1"></i> Tolak Request
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($suratKeterangan->status === 'selesai' && $suratKeterangan->file_surat)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-download me-2"></i>
                                Download Surat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid">
                                <a href="{{ route('dokter.surat-keterangan.download', $suratKeterangan) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
@if($suratKeterangan->status === 'pending')
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('dokter.surat-keterangan.approve', $suratKeterangan) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">
                        <i class="fas fa-check-circle me-2"></i>
                        Setujui Request Surat Keterangan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Silakan isi diagnosa dan keterangan dokter untuk melengkapi surat keterangan.
                    </div>
                    
                    <div class="mb-3">
                        <label for="diagnosa" class="form-label">
                            <strong>Diagnosa <span class="text-danger">*</span></strong>
                        </label>
                        <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                                  id="diagnosa" name="diagnosa" rows="4" 
                                  placeholder="Masukkan diagnosa pasien..." required>{{ old('diagnosa') }}</textarea>
                        @error('diagnosa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal 500 karakter</div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_dokter" class="form-label">
                            <strong>Keterangan Dokter</strong>
                        </label>
                        <textarea class="form-control @error('keterangan_dokter') is-invalid @enderror" 
                                  id="keterangan_dokter" name="keterangan_dokter" rows="3" 
                                  placeholder="Keterangan tambahan (opsional)...">{{ old('keterangan_dokter') }}</textarea>
                        @error('keterangan_dokter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal 1000 karakter (opsional)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Setujui & Buat Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dokter.surat-keterangan.reject', $suratKeterangan) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-times-circle me-2"></i>
                        Tolak Request Surat Keterangan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pastikan Anda memberikan alasan yang jelas untuk penolakan ini.
                    </div>
                    
                    <div class="mb-3">
                        <label for="alasan_ditolak" class="form-label">
                            <strong>Alasan Penolakan <span class="text-danger">*</span></strong>
                        </label>
                        <textarea class="form-control @error('alasan_ditolak') is-invalid @enderror" 
                                  id="alasan_ditolak" name="alasan_ditolak" rows="4" 
                                  placeholder="Jelaskan alasan penolakan..." required>{{ old('alasan_ditolak') }}</textarea>
                        @error('alasan_ditolak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal 500 karakter</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Tolak Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-open modal jika ada error validasi
    @if($errors->has('diagnosa') || $errors->has('keterangan_dokter'))
        $('#approveModal').modal('show');
    @endif
    
    @if($errors->has('alasan_ditolak'))
        $('#rejectModal').modal('show');
    @endif

    // Character counter untuk textarea
    function addCharacterCounter(selector, maxLength) {
        $(selector).on('input', function() {
            const currentLength = $(this).val().length;
            const remaining = maxLength - currentLength;
            const counterText = currentLength + '/' + maxLength + ' karakter';
            
            // Update atau create counter
            let counter = $(this).siblings('.char-counter');
            if (counter.length === 0) {
                counter = $('<div class="char-counter text-muted small mt-1"></div>');
                $(this).after(counter);
            }
            
            counter.text(counterText);
            
            // Change color if approaching limit
            if (remaining < 50) {
                counter.removeClass('text-muted').addClass('text-warning');
            } else if (remaining < 0) {
                counter.removeClass('text-warning').addClass('text-danger');
            } else {
                counter.removeClass('text-warning text-danger').addClass('text-muted');
            }
        });
    }

    // Add character counters
    addCharacterCounter('#diagnosa', 500);
    addCharacterCounter('#keterangan_dokter', 1000);
    addCharacterCounter('#alasan_ditolak', 500);
});
</script>
@endpush