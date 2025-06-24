@extends('layouts.dokter')
@section('title', 'Detail Resep Obat')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Resep Obat</h3>
                    <div>
                        <a href="{{ route('dokter.resep-obat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($resepObat->status == 'pending')
                            <a href="{{ route('dokter.resep-obat.edit', $resepObat) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        <button onclick="window.print()" class="btn btn-info">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Resep -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Resep</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nomor Resep:</strong></td>
                                            <td>{{ $resepObat->nomor_resep }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Resep:</strong></td>
                                            <td>{{ $resepObat->tanggal_resep->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @switch($resepObat->status)
                                                    @case('pending')
                                                        <span class="badge badge-warning badge-lg">Pending</span>
                                                        @break
                                                    @case('diproses')
                                                        <span class="badge badge-info badge-lg">Diproses</span>
                                                        @break
                                                    @case('siap')
                                                        <span class="badge badge-success badge-lg">Siap</span>
                                                        @break
                                                    @case('diambil')
                                                        <span class="badge badge-secondary badge-lg">Diambil</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dokter:</strong></td>
                                            <td>{{ $resepObat->dokter->name ?? 'N/A' }}</td>
                                        </tr>
                                        @if($resepObat->reservasi)
                                        <tr>
                                            <td><strong>Tanggal Reservasi:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($resepObat->reservasi->tanggal_reservasi)->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jam Reservasi:</strong></td>
                                            <td>{{ $resepObat->reservasi->jam_reservasi }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td><strong>Jenis Resep:</strong></td>
                                            <td><span class="badge badge-info">Resep Langsung</span></td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Informasi Pasien -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Pasien</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>{{ $resepObat->pasien->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $resepObat->pasien->email }}</td>
                                        </tr>
                                        @if($resepObat->pasien->user_type)
                                        <tr>
                                            <td><strong>Tipe Pasien:</strong></td>
                                            <td>
                                                <span class="badge badge-primary">
                                                    {{ $resepObat->pasien->user_type_display ?? ucfirst($resepObat->pasien->user_type) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($resepObat->pasien->phone)
                                        <tr>
                                            <td><strong>Telepon:</strong></td>
                                            <td>{{ $resepObat->pasien->phone }}</td>
                                        </tr>
                                        @endif
                                        @if($resepObat->pasien->date_of_birth)
                                        <tr>
                                            <td><strong>Tanggal Lahir:</strong></td>
                                            <td>{{ $resepObat->pasien->date_of_birth->format('d/m/Y') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($resepObat->reservasi && $resepObat->reservasi->keluhan)
                    <!-- Keluhan Pasien dari Reservasi -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Keluhan Pasien</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $resepObat->reservasi->keluhan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Diagnosa -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Diagnosa</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $resepObat->diagnosa }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($resepObat->catatan_dokter)
                    <!-- Catatan Dokter -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Catatan Dokter</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $resepObat->catatan_dokter }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Daftar Obat -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Daftar Obat</h5>
                                </div>
                                <div class="card-body">
                                    @if($resepObat->detailResep && $resepObat->detailResep->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan</th>
                                                    <th>Aturan Pakai</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resepObat->detailResep as $index => $detail)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $detail->nama_obat }}</strong></td>
                                                    <td>{{ $detail->dosis }}</td>
                                                    <td>{{ number_format($detail->jumlah) }}</td>
                                                    <td>{{ $detail->satuan }}</td>
                                                    <td>{{ $detail->aturan_pakai }}</td>
                                                    <td>{{ $detail->keterangan ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Tidak ada detail obat yang ditemukan untuk resep ini.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($resepObat->farmasi)
                    <!-- Informasi Farmasi -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Farmasi</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Petugas Farmasi:</strong></td>
                                            <td>{{ $resepObat->farmasi->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Diproses:</strong></td>
                                            <td>{{ $resepObat->tanggal_diproses ? $resepObat->tanggal_diproses->format('d/m/Y H:i') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Siap:</strong></td>
                                            <td>{{ $resepObat->tanggal_siap ? $resepObat->tanggal_siap->format('d/m/Y H:i') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Diambil:</strong></td>
                                            <td>{{ $resepObat->tanggal_diambil ? $resepObat->tanggal_diambil->format('d/m/Y H:i') : '-' }}</td>
                                        </tr>
                                        @if($resepObat->catatan_farmasi)
                                        <tr>
                                            <td><strong>Catatan Farmasi:</strong></td>
                                            <td>{{ $resepObat->catatan_farmasi }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($resepObat->status == 'pending')
                    <!-- Alert untuk resep pending -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Resep ini masih dalam status pending dan dapat diubah atau dihapus. 
                                Setelah diproses oleh farmasi, resep tidak dapat diubah lagi.
                            </div>
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
    @media print {
        .card-header,
        .btn,
        .no-print,
        .alert {
            display: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .table {
            font-size: 12px;
        }
        
        .badge-lg {
            font-size: 14px;
            padding: 8px 12px;
        }
        
        body {
            font-size: 12px;
        }
        
        .card-title {
            font-size: 14px;
            font-weight: bold;
        }
    }
    
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
    
    .table-borderless td {
        padding: 0.5rem 0.75rem;
    }
    
    .table-borderless td:first-child {
        width: 35%;
        vertical-align: top;
    }
</style>
@endpush

@endsection