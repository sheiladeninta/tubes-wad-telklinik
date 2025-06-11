@extends('layouts.pasien')

@section('title', 'Detail Request Surat Keterangan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Detail Request Surat Keterangan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pasien.surat-keterangan.index') }}">Surat Keterangan</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('pasien.surat-keterangan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Card -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-medical me-2"></i>{{ $suratKeterangan->jenis_surat_label }}
                        </h5>
                        <span class="badge bg-{{ $suratKeterangan->status_badge_color }} fs-6">
                            {{ $suratKeterangan->status_label }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Umum -->
                        <div class="col-lg-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Umum
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%" class="fw-bold">Jenis Surat:</td>
                                        <td>{{ $suratKeterangan->jenis_surat_label }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Keperluan:</td>
                                        <td>{{ $suratKeterangan->keperluan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Tanggal Request:</td>
                                        <td>{{ $suratKeterangan->tanggal_request->format('d F Y, H:i') }} WIB</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Status:</td>
                                        <td>
                                            <span class="badge bg-{{ $suratKeterangan->status_badge_color }}">
                                                {{ $suratKeterangan->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($suratKeterangan->tanggal_diproses)
                                    <tr>
                                        <td class="fw-bold">Tanggal Diproses:</td>
                                        <td>{{ $suratKeterangan->tanggal_diproses->format('d F Y, H:i') }} WIB</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <!-- Informasi Dokter -->
                        <div class="col-lg-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user-md me-2"></i>Informasi Dokter
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%" class="fw-bold">Nama Dokter:</td>
                                        <td>{{ $suratKeterangan->dokter->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Spesialis:</td>
                                        <td>{{ $suratKeterangan->dokter->specialist ?? 'Umum' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Khusus Surat Sakit -->
                    @if($suratKeterangan->jenis_surat === 'sakit' && $suratKeterangan->tanggal_mulai_sakit)
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>Informasi Periode Sakit
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Tanggal Mulai Sakit</h6>
                                            <p class="card-text fw-bold">{{ $suratKeterangan->tanggal_mulai_sakit->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Tanggal Selesai Sakit</h6>
                                            <p class="card-text fw-bold">{{ $suratKeterangan->tanggal_selesai_sakit->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Durasi Sakit</h6>
                                            <p class="card-text fw-bold">{{ $suratKeterangan->durasi_sakit }} hari</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Keluhan -->
                    @if($suratKeterangan->keluhan)
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-notes-medical me-2"></i>Keluhan
                            </h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $suratKeterangan->keluhan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Keterangan Tambahan -->
                    @if($suratKeterangan->keterangan_tambahan)
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-comment-medical me-2"></i>Keterangan Tambahan
                            </h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $suratKeterangan->keterangan_tambahan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Alasan Ditolak -->
                    @if($suratKeterangan->status === 'ditolak' && $suratKeterangan->alasan_ditolak)
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-danger mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>Alasan Ditolak
                            </h6>
                            <div class="alert alert-danger">
                                <p class="mb-0">{{ $suratKeterangan->alasan_ditolak }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Card Footer dengan Action Buttons -->
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Dibuat pada {{ $suratKeterangan->created_at->format('d F Y, H:i') }} WIB
                            </small>
                        </div>
                        <div class="btn-group" role="group">
                            @if($suratKeterangan->status === 'pending')
                                <!-- Tombol Cancel untuk status pending -->
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                    <i class="fas fa-times me-2"></i>Batalkan Request
                                </button>
                            @endif

                            @if($suratKeterangan->status === 'selesai' && $suratKeterangan->file_surat)
                                <!-- Tombol Download untuk status selesai -->
                                <a href="{{ route('pasien.surat-keterangan.download', $suratKeterangan) }}" class="btn btn-success">
                                    <i class="fas fa-download me-2"></i>Download Surat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin membatalkan request surat keterangan ini?</p>
                <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('pasien.surat-keterangan.cancel', $suratKeterangan) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-borderless td {
        border: none !important;
        padding: 0.5rem 0.75rem;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .badge {
        font-size: 0.875em;
    }
    
    .alert {
        border: none;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush