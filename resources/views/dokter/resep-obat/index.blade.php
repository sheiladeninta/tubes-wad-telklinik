@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.dokter')
@section('title', 'Resep Obat')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Resep Obat</h3>
                    <a href="{{ route('dokter.resep-obat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Resep Baru
                    </a>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['total'] }}</h4>
                                    <small>Total Resep</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['pending'] }}</h4>
                                    <small>Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['diproses'] }}</h4>
                                    <small>Diproses</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['siap'] }}</h4>
                                    <small>Siap</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-secondary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['diambil'] }}</h4>
                                    <small>Diambil</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Form -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari pasien atau nomor resep..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="{{ App\Models\ResepObat::STATUS_PENDING }}" 
                                            {{ request('status') == App\Models\ResepObat::STATUS_PENDING ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="{{ App\Models\ResepObat::STATUS_DIPROSES }}" 
                                            {{ request('status') == App\Models\ResepObat::STATUS_DIPROSES ? 'selected' : '' }}>
                                        Diproses
                                    </option>
                                    <option value="{{ App\Models\ResepObat::STATUS_SIAP }}" 
                                            {{ request('status') == App\Models\ResepObat::STATUS_SIAP ? 'selected' : '' }}>
                                        Siap
                                    </option>
                                    <option value="{{ App\Models\ResepObat::STATUS_DIAMBIL }}" 
                                            {{ request('status') == App\Models\ResepObat::STATUS_DIAMBIL ? 'selected' : '' }}>
                                        Diambil
                                    </option>
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
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('dokter.resep-obat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Resep</th>
                                    <th>Pasien</th>
                                    <th>Tanggal Resep</th>
                                    <th>Diagnosa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resepObat as $index => $resep)
                                <tr>
                                    <td>{{ $resepObat->firstItem() + $index }}</td>
                                    <td>{{ $resep->nomor_resep }}</td>
                                    <td>
                                        {{ $resep->pasien->name }}
                                        @if($resep->pasien->user_type)
                                            <br><small class="text-muted">{{ $resep->pasien->user_type }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $resep->tanggal_resep->format('d/m/Y H:i') }}</td>
                                    <td>{{ Str::limit($resep->diagnosa, 50) }}</td>
                                    <td>
                                        @switch($resep->status)
                                            @case(App\Models\ResepObat::STATUS_PENDING)
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case(App\Models\ResepObat::STATUS_DIPROSES)
                                                <span class="badge badge-info">Diproses</span>
                                                @break
                                            @case(App\Models\ResepObat::STATUS_SIAP)
                                                <span class="badge badge-success">Siap</span>
                                                @break
                                            @case(App\Models\ResepObat::STATUS_DIAMBIL)
                                                <span class="badge badge-secondary">Diambil</span>
                                                @break
                                            @default
                                                <span class="badge badge-light">{{ ucfirst($resep->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dokter.resep-obat.show', $resep) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($resep->status == App\Models\ResepObat::STATUS_PENDING)
                                                <a href="{{ route('dokter.resep-obat.edit', $resep) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('dokter.resep-obat.destroy', $resep) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
                                            <h5 class="text-muted">Tidak ada data resep obat</h5>
                                            <p class="text-muted">Belum ada resep yang dibuat atau sesuai dengan filter yang dipilih.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($resepObat->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $resepObat->firstItem() }} - {{ $resepObat->lastItem() }} 
                                dari {{ $resepObat->total() }} resep
                            </div>
                            <div>
                                {{ $resepObat->links() }}
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
        
        // Confirm delete
        $('form[action*="destroy"]').on('submit', function(e) {
            if (!confirm('Yakin ingin menghapus resep ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
                e.preventDefault();
                return false;
            }
        });
        
        // Add loading state to buttons
        $('.btn[type="submit"]').on('click', function() {
            var $btn = $(this);
            $btn.prop('disabled', true);
            var originalText = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
            
            setTimeout(function() {
                $btn.prop('disabled', false);
                $btn.html(originalText);
            }, 3000);
        });
    });
</script>
@endpush