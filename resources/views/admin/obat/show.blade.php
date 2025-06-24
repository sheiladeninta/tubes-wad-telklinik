@extends('layouts.admin')

@section('title', 'Detail Obat')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Obat</h1>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Detail Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Obat</h6>
                    <span class="badge badge-{{ $obat->status == 'aktif' ? 'success' : 'secondary' }} badge-lg">
                        {{ ucfirst($obat->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Nama Obat:</strong>
                            <p class="mb-0">{{ $obat->nama_obat }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Jenis Obat:</strong>
                            <p class="mb-0">
                                <span class="badge badge-info text-dark">{{ ucfirst($obat->jenis_obat) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Stok:</strong>
                            <p class="mb-0">
                                <span class="badge badge-{{ $obat->stok > 10 ? 'success' : ($obat->stok > 0 ? 'warning' : 'danger') }} badge-lg text-dark">
                                    {{ $obat->stok }} unit
                                </span>
                                @if($obat->stok == 0)
                                    <small class="text-danger d-block">Stok habis</small>
                                @elseif($obat->stok < 10)
                                    <small class="text-warning d-block">Stok menipis</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Harga:</strong>
                            <p class="mb-0 text-success font-weight-bold">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Tanggal Kadaluarsa:</strong>
                            <p class="mb-0">
                                @if($obat->tanggal_kadaluarsa)
                                    {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d F Y') }}
                                    @php
                                        $daysDiff = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($obat->tanggal_kadaluarsa), false);
                                    @endphp
                                    @if($daysDiff < 0)
                                        <small class="text-danger d-block">
                                            <i class="fas fa-exclamation-triangle"></i> Sudah kadaluarsa
                                        </small>
                                    @elseif($daysDiff <= 180)
                                        <small class="text-warning d-block">
                                            <i class="fas fa-exclamation-triangle"></i> Hampir kadaluarsa ({{ $daysDiff }} hari lagi)
                                        </small>
                                    @endif
                                @else
                                    <span class="text-muted">Tidak ada tanggal kadaluarsa</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Pabrik:</strong>
                            <p class="mb-0">{{ $obat->pabrik ?? 'Tidak ada data' }}</p>
                        </div>
                        @if($obat->deskripsi)
                        <div class="col-12 mb-3">
                            <strong class="text-gray-800">Deskripsi:</strong>
                            <p class="mb-0">{{ $obat->deskripsi }}</p>
                        </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Total Nilai Stok:</strong>
                            <p class="mb-0 text-primary font-weight-bold">
                                Rp {{ number_format($obat->stok * $obat->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong class="text-gray-800">Terakhir Diupdate:</strong>
                            <p class="mb-0 text-muted">
                                {{ $obat->updated_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gambar Obat</h6>
                </div>
                <div class="card-body text-center">
                    @if($obat->gambar)
                        <img src="{{ asset('storage/' . $obat->gambar) }}"
                             alt="{{ $obat->nama_obat }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 250px;">
                    @else
                        <div class="bg-light rounded p-4">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($obat->stok == 0 || ($obat->tanggal_kadaluarsa && \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($obat->tanggal_kadaluarsa), false) <= 180))
            <div class="card border-left-warning shadow mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Peringatan
                            </div>
                            <div class="text-xs mb-0 text-gray-800">
                                @if($obat->stok == 0)
                                    Stok obat habis!
                                @elseif($obat->stok < 10)
                                    Stok obat menipis!
                                @endif

                                @if($obat->tanggal_kadaluarsa && \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($obat->tanggal_kadaluarsa), false) <= 180)
                                    <br>Obat hampir kadaluarsa!
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
