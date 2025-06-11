@extends('layouts.pasien')

@section('title', 'Surat Keterangan - Tel-Klinik')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-dark mb-1" style="font-weight: 600;">
                        <i class="fas fa-file-alt me-2 text-danger"></i>
                        Surat Keterangan
                    </h2>
                    <p class="text-muted mb-0">Kelola request surat keterangan medis Anda</p>
                </div>
                <a href="{{ route('pasien.surat-keterangan.create') }}" class="btn btn-danger">
                    <i class="fas fa-plus me-2"></i>Request Surat Baru
                </a>
            </div>
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

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffc107, #ffb300);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1">Menunggu</h6>
                            <h3 class="mb-0">{{ $requests->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1">Diproses</h6>
                            <h3 class="mb-0">{{ $requests->where('status', 'diproses')->count() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-cog fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1">Selesai</h6>
                            <h3 class="mb-0">{{ $requests->where('status', 'selesai')->count() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545, #bd2130);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1">Ditolak</h6>
                            <h3 class="mb-0">{{ $requests->where('status', 'ditolak')->count() }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Request Surat Keterangan
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal Request</th>
                                        <th>Jenis Surat</th>
                                        <th>Dokter</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-medium">{{ $request->tanggal_request->format('d/m/Y') }}</span>
                                                    <small class="text-muted">{{ $request->tanggal_request->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $request->jenis_surat_label }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-medium">{{ $request->dokter->name ?? 'N/A' }}</span>
                                                    @if($request->dokter && $request->dokter->spesialis)
                                                        <small class="text-muted">{{ $request->dokter->spesialis }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $request->keperluan }}">
                                                    {{ $request->keperluan }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $request->status_badge_color }}">
                                                    {{ $request->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('pasien.surat-keterangan.show', $request) }}" 
                                                       class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    @if($request->status === 'selesai' && $request->file_surat)
                                                        <a href="{{ route('pasien.surat-keterangan.download', $request) }}" 
                                                           class="btn btn-outline-success btn-sm" title="Download Surat">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($request->status === 'pending')
                                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                                onclick="confirmCancel('{{ route('pasien.surat-keterangan.cancel', $request) }}')"
                                                                title="Batalkan Request">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($requests->hasPages())
                            <div class="d-flex justify-content-center p-3">
                                {{ $requests->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted mb-3">Belum Ada Request Surat Keterangan</h5>
                            <p class="text-muted mb-4">Anda belum pernah membuat request surat keterangan.</p>
                            <a href="{{ route('pasien.surat-keterangan.create') }}" class="btn btn-danger">
                                <i class="fas fa-plus me-2"></i>Buat Request Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan request surat keterangan ini?</p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="cancelForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmCancel(url) {
    document.getElementById('cancelForm').action = url;
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}
</script>
@endsection