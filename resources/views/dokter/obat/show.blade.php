@extends('layouts.dokter')
@section('title', 'Detail Obat - ' . $obat->nama_obat)
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-pills text-primary"></i> Detail Obat
        </h1>
        <a href="{{ route('dokter.obat.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
    
    <div class="row">
        <!-- Main Information Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Obat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            @if($obat->gambar)
                                <img src="{{ asset('storage/' . $obat->gambar) }}" 
                                     class="img-fluid rounded shadow" 
                                     alt="{{ $obat->nama_obat }}"
                                     style="max-height: 300px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" 
                                     style="height: 300px;">
                                    <i class="fas fa-pills fa-5x text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h2 class="text-primary font-weight-bold mb-3">{{ $obat->nama_obat }}</h2>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Jenis Obat:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge badge-primary badge-pill">{{ ucfirst($obat->jenis_obat) }}</span>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Harga:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="text-success font-weight-bold h5">{{ $obat->harga_format }}</span>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Stok:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge badge-{{ $obat->status_stok_badge }} badge-pill">
                                        {{ $obat->status_stok }} ({{ $obat->stok }} unit)
                                    </span>
                                </div>
                            </div>
                            
                            @if($obat->pabrik)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Pabrik:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $obat->pabrik }}
                                    </div>
                                </div>
                            @endif
                            
                            @if($obat->nomor_batch)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Nomor Batch:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <code>{{ $obat->nomor_batch }}</code>
                                    </div>
                                </div>
                            @endif
                            
                            @if($obat->tanggal_kadaluarsa)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Tanggal Kadaluarsa:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge badge-{{ $obat->isKadaluarsa() ? 'danger' : ($obat->isHampirKadaluarsa() ? 'warning' : 'success') }}">
                                            {{ $obat->tanggal_kadaluarsa->format('d/m/Y') }}
                                            @if($obat->isKadaluarsa())
                                                (Kadaluarsa)
                                            @elseif($obat->isHampirKadaluarsa())
                                                (Hampir Kadaluarsa)
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Deskripsi dan Komposisi -->
            @if($obat->deskripsi || $obat->komposisi)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Deskripsi & Komposisi</h6>
                    </div>
                    <div class="card-body">
                        @if($obat->deskripsi)
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-dark">Deskripsi:</h6>
                                <p class="text-gray-700">{{ $obat->deskripsi }}</p>
                            </div>
                        @endif
                        
                        @if($obat->komposisi)
                            <div class="mb-0">
                                <h6 class="font-weight-bold text-dark">Komposisi:</h6>
                                <p class="text-gray-700">{{ $obat->komposisi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            
            <!-- Dosis dan Cara Pakai -->
            @if($obat->dosis || $obat->cara_pakai)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Dosis & Cara Pakai</h6>
                    </div>
                    <div class="card-body">
                        @if($obat->dosis)
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-dark">Dosis:</h6>
                                <p class="text-gray-700">{{ $obat->dosis }}</p>
                            </div>
                        @endif
                        
                        @if($obat->cara_pakai)
                            <div class="mb-0">
                                <h6 class="font-weight-bold text-dark">Cara Pakai:</h6>
                                <p class="text-gray-700">{{ $obat->cara_pakai }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            
            <!-- Peringatan -->
            @if($obat->efek_samping || $obat->kontraindikasi)
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-warning">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fas fa-exclamation-triangle"></i> Peringatan & Efek Samping
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($obat->efek_samping)
                            <div class="mb-4">
                                <h6 class="font-weight-bold text-warning">Efek Samping:</h6>
                                <p class="text-gray-700">{{ $obat->efek_samping }}</p>
                            </div>
                        @endif
                        
                        @if($obat->kontraindikasi)
                            <div class="mb-0">
                                <h6 class="font-weight-bold text-danger">Kontraindikasi:</h6>
                                <p class="text-gray-700">{{ $obat->kontraindikasi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Obat</h6>
                </div>
                <div class="card-body">
                    <!-- Status Stok -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <i class="fas fa-boxes fa-2x text-{{ $obat->status_stok_badge }}"></i>
                        </div>
                        <div>
                            <div class="font-weight-bold text-{{ $obat->status_stok_badge }}">
                                {{ $obat->status_stok }}
                            </div>
                            <div class="text-gray-600 small">{{ $obat->stok }} unit tersedia</div>
                        </div>
                    </div>
                    
                    <!-- Status Kadaluarsa -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <i class="fas fa-calendar-times fa-2x text-{{ $obat->isKadaluarsa() ? 'danger' : ($obat->isHampirKadaluarsa() ? 'warning' : 'success') }}"></i>
                        </div>
                        <div>
                            <div class="font-weight-bold text-{{ $obat->isKadaluarsa() ? 'danger' : ($obat->isHampirKadaluarsa() ? 'warning' : 'success') }}">
                                @if($obat->isKadaluarsa())
                                    Kadaluarsa
                                @elseif($obat->isHampirKadaluarsa())
                                    Hampir Kadaluarsa
                                @else
                                    Masih Aman
                                @endif
                            </div>
                            <div class="text-gray-600 small">
                                @if($obat->tanggal_kadaluarsa)
                                    Exp: {{ $obat->tanggal_kadaluarsa->format('d/m/Y') }}
                                @else
                                    Tanggal tidak tersedia
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alert untuk peringatan -->
                    @if($obat->stok == 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Perhatian!</strong> Stok obat habis.
                        </div>
                    @elseif($obat->stok < 10)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Peringatan!</strong> Stok obat menipis.
                        </div>
                    @endif
                    
                    @if($obat->isKadaluarsa())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Bahaya!</strong> Obat sudah kadaluarsa.
                        </div>
                    @elseif($obat->isHampirKadaluarsa())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Peringatan!</strong> Obat akan segera kadaluarsa.
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Info Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Singkat</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-right">
                            <div class="h5 font-weight-bold text-primary">{{ $obat->stok }}</div>
                            <div class="small text-gray-500">Unit Stok</div>
                        </div>
                        <div class="col-6">
                            <div class="h5 font-weight-bold text-success">{{ $obat->harga_format }}</div>
                            <div class="small text-gray-500">Harga</div>
                        </div>
                    </div>
                    
                    @if($obat->tanggal_kadaluarsa)
                        <hr>
                        <div class="text-center">
                            <div class="small text-gray-500">Masa Berlaku</div>
                            <div class="font-weight-bold">
                                {{ $obat->tanggal_kadaluarsa->diffForHumans() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush