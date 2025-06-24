@extends('layouts.dokter')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Rekam Medis</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekam-medis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('dokter.rekam-medis.edit', $rekamMedis) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Info Pasien -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Informasi Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{ $rekamMedis->pasien->avatar ?? asset('img/undraw_profile.svg') }}" 
                             class="img-profile rounded-circle mb-2" width="80" height="80">
                        <h5 class="font-weight-bold">{{ $rekamMedis->pasien->name }}</h5>
                        <p class="text-muted mb-0">{{ $rekamMedis->pasien->email }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-2"><strong>No. Telepon:</strong></p>
                            <p class="text-muted">{{ $rekamMedis->pasien->phone ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-2"><strong>Tanggal Lahir:</strong></p>
                            <p class="text-muted">{{ $rekamMedis->pasien->tanggal_lahir ? \Carbon\Carbon::parse($rekamMedis->pasien->tanggal_lahir)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-2"><strong>Jenis Kelamin:</strong></p>
                            <p class="text-muted">{{ $rekamMedis->pasien->jenis_kelamin ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-2"><strong>Alamat:</strong></p>
                            <p class="text-muted">{{ $rekamMedis->pasien->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Status Rekam Medis
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($rekamMedis->status == 'final')
                        <span class="badge badge-success badge-lg px-3 py-2">
                            <i class="fas fa-check-circle"></i> Final
                        </span>
                    @else
                        <span class="badge badge-warning badge-lg px-3 py-2">
                            <i class="fas fa-clock"></i> Draft
                        </span>
                    @endif
                    
                    <p class="mt-3 mb-0 text-muted">
                        <small>Dibuat: {{ $rekamMedis->created_at->format('d/m/Y H:i') }}</small><br>
                        <small>Diperbarui: {{ $rekamMedis->updated_at->format('d/m/Y H:i') }}</small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Detail Rekam Medis -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-medical"></i> Detail Pemeriksaan
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Info Pemeriksaan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary">Tanggal Pemeriksaan</h6>
                            <p class="mb-3">{{ \Carbon\Carbon::parse($rekamMedis->tanggal_pemeriksaan)->format('d F Y') }}</p>
                        </div>
                        @if($rekamMedis->reservasi)
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary">No. Reservasi</h6>
                            <p class="mb-3">#{{ str_pad($rekamMedis->reservasi->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Tanda Vital -->
                    @if($rekamMedis->tinggi_badan || $rekamMedis->berat_badan || $rekamMedis->tekanan_darah || $rekamMedis->suhu_tubuh || $rekamMedis->nadi)
                    <div class="card border-left-info mb-4">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-info mb-3">
                                <i class="fas fa-heartbeat"></i> Tanda Vital
                            </h6>
                            <div class="row">
                                @if($rekamMedis->tinggi_badan)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-ruler-vertical text-info fa-2x mb-2"></i>
                                        <h6 class="font-weight-bold">{{ $rekamMedis->tinggi_badan }} cm</h6>
                                        <small class="text-muted">Tinggi Badan</small>
                                    </div>
                                </div>
                                @endif
                                
                                @if($rekamMedis->berat_badan)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-weight text-info fa-2x mb-2"></i>
                                        <h6 class="font-weight-bold">{{ $rekamMedis->berat_badan }} kg</h6>
                                        <small class="text-muted">Berat Badan</small>
                                    </div>
                                </div>
                                @endif
                                
                                @if($rekamMedis->tekanan_darah)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-tachometer-alt text-info fa-2x mb-2"></i>
                                        <h6 class="font-weight-bold">{{ $rekamMedis->tekanan_darah }}</h6>
                                        <small class="text-muted">Tekanan Darah</small>
                                    </div>
                                </div>
                                @endif
                                
                                @if($rekamMedis->suhu_tubuh)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-thermometer-half text-info fa-2x mb-2"></i>
                                        <h6 class="font-weight-bold">{{ $rekamMedis->suhu_tubuh }}°C</h6>
                                        <small class="text-muted">Suhu Tubuh</small>
                                    </div>
                                </div>
                                @endif
                                
                                @if($rekamMedis->nadi)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-heartbeat text-info fa-2x mb-2"></i>
                                        <h6 class="font-weight-bold">{{ $rekamMedis->nadi }} bpm</h6>
                                        <small class="text-muted">Nadi</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Keluhan -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-comment-medical"></i> Keluhan Pasien
                        </h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $rekamMedis->keluhan }}</p>
                        </div>
                    </div>

                    <!-- Diagnosa -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-stethoscope"></i> Diagnosa
                        </h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $rekamMedis->diagnosa }}</p>
                        </div>
                    </div>

                    <!-- Tindakan -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-procedures"></i> Tindakan
                        </h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $rekamMedis->tindakan }}</p>
                        </div>
                    </div>

                    <!-- Resep Obat -->
                    @if($rekamMedis->resep_obat)
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-pills"></i> Resep Obat
                        </h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $rekamMedis->resep_obat }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Dokter -->
                    @if($rekamMedis->catatan_dokter)
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary">
                            <i class="fas fa-sticky-note"></i> Catatan Dokter
                        </h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $rekamMedis->catatan_dokter }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.badge-lg {
    font-size: 1.1em;
    padding: 0.5rem 1rem;
}

.img-profile {
    object-fit: cover;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
</style>
@endpush
@endsection