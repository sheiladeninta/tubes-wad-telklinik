@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.dokter')
@section('title', 'Rekam Medis Pasien')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Rekam Medis Pasien</h3>
                    <a href="{{ route('dokter.rekam-medis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Rekam Medis
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['total'] ?? $rekamMedis->total() }}</h4>
                                    <small>Total Rekam Medis</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['draft'] ?? $rekamMedis->where('status', 'draft')->count() }}</h4>
                                    <small>Draft</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['final'] ?? $rekamMedis->where('status', 'final')->count() }}</h4>
                                    <small>Selesai</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['today'] ?? $rekamMedis->where('tanggal_pemeriksaan', '>=', now()->startOfDay())->count() }}</h4>
                                    <small>Hari Ini</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-secondary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['thisWeek'] ?? $rekamMedis->where('tanggal_pemeriksaan', '>=', now()->startOfWeek())->count() }}</h4>
                                    <small>Minggu Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter Form -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari pasien atau keluhan..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="final" {{ request('status') == 'final' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal_dari" class="form-control" 
                                       value="{{ request('tanggal_dari') }}" 
                                       placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal_sampai" class="form-control" 
                                       value="{{ request('tanggal_sampai') }}" 
                                       placeholder="Sampai Tanggal">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-info filter-btn">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Pasien</th>
                                    <th>Keluhan</th>
                                    <th>Diagnosa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $index => $rm)
                                    <tr>
                                        <td>{{ $rekamMedis->firstItem() + $index }}</td>
                                        <td>{{ $rm->tanggal_pemeriksaan->format('d/m/Y H:i') }}</td>
                                        <td>
                                            {{ $rm->pasien->name }}
                                            @if($rm->pasien->email)
                                                <br><small class="text-muted">{{ $rm->pasien->email }}</small>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($rm->keluhan, 50) }}</td>
                                        <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                                        <td>
                                            @if($rm->status == 'final')
                                                <span class="badge badge-success">Selesai</span>
                                            @else
                                                <span class="badge badge-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dokter.rekam-medis.show', $rm) }}" 
                                                   class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($rm->status == 'draft')
                                                    <a href="{{ route('dokter.rekam-medis.edit', $rm) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" 
                                                          action="{{ route('dokter.rekam-medis.destroy', $rm) }}" 
                                                          class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Tidak ada data rekam medis</h5>
                                                <p class="text-muted">Belum ada rekam medis yang dibuat atau sesuai dengan filter yang dipilih.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($rekamMedis->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $rekamMedis->firstItem() }} - {{ $rekamMedis->lastItem() }} 
                                dari {{ $rekamMedis->total() }} rekam medis
                            </div>
                            <div>
                                {{ $rekamMedis->links() }}
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
        // Auto submit form when status changes
        $('select[name="status"]').change(function() {
            $(this).closest('form').submit();
        });
        
        // Auto submit form when date changes
        $('input[name="tanggal_dari"], input[name="tanggal_sampai"]').change(function() {
            // Optional: Auto submit on date change
            // $(this).closest('form').submit();
        });
        
        // Handle delete confirmation dan loading
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = this;
            var $btn = $(form).find('.delete-btn');
            
            if (confirm('Yakin ingin menghapus rekam medis ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
                // Show loading state
                $btn.prop('disabled', true);
                var originalHtml = $btn.html();
                $btn.html('<i class="fas fa-spinner fa-spin"></i>');
                
                // Submit form setelah konfirmasi
                form.submit();
            }
        });
        
        // Add loading state hanya untuk filter button
        $('.filter-btn').on('click', function() {
            var $btn = $(this);
            $btn.prop('disabled', true);
            var originalText = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
            
            // Reset loading state after 5 seconds (fallback)
            setTimeout(function() {
                $btn.prop('disabled', false);
                $btn.html(originalText);
            }, 5000);
        });
    });
</script>
@endpush