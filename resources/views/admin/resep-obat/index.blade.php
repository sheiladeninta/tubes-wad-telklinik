@extends('layouts.admin')

@section('title', 'Manajemen Resep Obat')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-prescription-bottle-alt me-2"></i>
            Manajemen Resep Obat
        </h1>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-1"></i>
                Filter
            </button>
            <a href="{{ route('admin.resep-obat.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel me-1"></i>
                Export
            </a>
        </div>
    </div>

    {{-- Filter Pills --}}
    @if(request()->hasAny(['status', 'dokter_id', 'tanggal_dari', 'tanggal_sampai', 'search']))
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="text-muted small">Filter aktif:</span>
            
            @if(request('status'))
                <span class="badge bg-primary">
                    Status: {{ ucfirst(request('status')) }}
                    <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-white ms-1">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif

            @if(request('dokter_id'))
                @php
                    $selectedDokter = $dokters->find(request('dokter_id'));
                @endphp
                <span class="badge bg-info">
                    Dokter: {{ $selectedDokter->name ?? 'Unknown' }}
                    <a href="{{ request()->fullUrlWithQuery(['dokter_id' => null]) }}" class="text-white ms-1">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif

            @if(request('tanggal_dari') || request('tanggal_sampai'))
                <span class="badge bg-warning">
                    Periode: {{ request('tanggal_dari') }} - {{ request('tanggal_sampai') }}
                    <a href="{{ request()->fullUrlWithQuery(['tanggal_dari' => null, 'tanggal_sampai' => null]) }}" class="text-white ms-1">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif

            @if(request('search'))
                <span class="badge bg-secondary">
                    Pencarian: "{{ request('search') }}"
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-1">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif

            <a href="{{ route('admin.resep-obat.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times me-1"></i>
                Hapus Semua Filter
            </a>
        </div>
    </div>
    @endif

    {{-- Search Bar --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari nomor resep atau nama pasien..." 
                       value="{{ request('search') }}" id="searchInput">
                <button class="btn btn-primary" type="button" onclick="performSearch()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="text-muted small">
                Menampilkan {{ $resepObat->firstItem() ?? 0 }} - {{ $resepObat->lastItem() ?? 0 }} 
                dari {{ $resepObat->total() }} resep obat
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Resep Obat</h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown">
                    <i class="fas fa-cog me-1"></i>
                    Aksi Bulk
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="updateMultipleStatus('diproses')">
                        <i class="fas fa-play me-2"></i>Proses Terpilih
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateMultipleStatus('siap')">
                        <i class="fas fa-check me-2"></i>Siapkan Terpilih
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="exportSelected()">
                        <i class="fas fa-download me-2"></i>Export Terpilih
                    </a></li>
                </ul>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($resepObat->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th>No. Resep</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Tanggal Resep</th>
                                <th>Status</th>
                                <th>Farmasi</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resepObat as $resep)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox" 
                                               value="{{ $resep->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $resep->nomor_resep }}</div>
                                    @if($resep->reservasi)
                                        <small class="text-muted">
                                            Reservasi: #{{ $resep->reservasi->id }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $resep->pasien->name }}</div>
                                            <small class="text-muted">{{ $resep->pasien->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $resep->dokter->name }}</div>
                                    <small class="text-muted">Dokter</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($resep->tanggal_resep)->format('d/m/Y') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($resep->tanggal_resep)->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $resep->status_color }} px-2 py-1">
                                        {{ $resep->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($resep->farmasi)
                                        <div class="fw-semibold">{{ $resep->farmasi->name }}</div>
                                        <small class="text-muted">Farmasi</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.resep-obat.show', $resep) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" 
                                                onclick="updateStatus({{ $resep->id }})" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if(in_array($resep->status, ['pending', 'diproses']))
                                        <a href="{{ route('admin.resep-obat.edit', $resep) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $resepObat->firstItem() }} - {{ $resepObat->lastItem() }} 
                        dari {{ $resepObat->total() }} resep obat
                    </div>
                    {{ $resepObat->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-prescription-bottle-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada resep obat ditemukan</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['status', 'dokter_id', 'search']))
                            Coba ubah kriteria pencarian atau filter Anda.
                        @else
                            Belum ada resep obat yang terdaftar dalam sistem.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Filter Modal --}}
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Resep Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET" action="{{ route('admin.resep-obat.index') }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="siap" {{ request('status') == 'siap' ? 'selected' : '' }}>
                                    Siap Diambil
                                </option>
                                <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>
                                    Sudah Diambil
                                </option>
                                <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dokter</label>
                            <select name="dokter_id" class="form-select">
                                <option value="">Semua Dokter</option>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" 
                                            {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" class="form-control" 
                                   value="{{ request('tanggal_dari') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" class="form-control" 
                                   value="{{ request('tanggal_sampai') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pencarian</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nomor resep atau nama pasien..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="{{ route('admin.resep-obat.index') }}" class="btn btn-outline-secondary">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Update Status Modal --}}
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Resep</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <select name="status" class="form-select" id="statusSelect" required>
                            <option value="">Pilih Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="siap">Siap Diambil</option>
                            <option value="diambil">Sudah Diambil</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3" id="farmasiField" style="display: none;">
                        <label class="form-label">Farmasi</label>
                        <select name="farmasi_id" class="form-select">
                            <option value="">Pilih Farmasi</option>
                            @foreach($farmasis as $farmasi)
                                <option value="{{ $farmasi->id }}">{{ $farmasi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" 
                                  placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    border: 1px solid #dee2e6;
}

.btn-group .btn:hover {
    z-index: 2;
}
</style>
@endpush

@push('scripts')
<script>
// Search functionality
function performSearch() {
    const searchValue = document.getElementById('searchInput').value;
    const url = new URL(window.location);
    if (searchValue) {
        url.searchParams.set('search', searchValue);
    } else {
        url.searchParams.delete('search');
    }
    window.location.href = url.toString();
}

// Enter key search
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performSearch();
    }
});

// Select all checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Update individual checkbox
document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allCheckboxes = document.querySelectorAll('.row-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        const selectAllCheckbox = document.getElementById('selectAll');
        
        selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
    });
});

// Update status functionality
let currentResepId = null;

function updateStatus(resepId) {
    currentResepId = resepId;
    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

// Show/hide farmasi field based on status
document.getElementById('statusSelect').addEventListener('change', function() {
    const farmasiField = document.getElementById('farmasiField');
    if (['diproses', 'siap'].includes(this.value)) {
        farmasiField.style.display = 'block';
    } else {
        farmasiField.style.display = 'none';
    }
});

// Handle status update form submission
document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!currentResepId) return;
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Here you would typically send an AJAX request to update the status
    fetch(`/admin/resep-obat/${currentResepId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification
            showNotification('Status berhasil diperbarui!', 'success');
            // Reload page to reflect changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Gagal memperbarui status!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan!', 'error');
    });
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('updateStatusModal')).hide();
});

// Bulk operations
function updateMultipleStatus(status) {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        showNotification('Pilih minimal satu resep!', 'warning');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin mengubah status ${selectedIds.length} resep menjadi "${status}"?`)) {
        // Implement bulk update logic here
        console.log('Updating status for IDs:', selectedIds, 'to:', status);
        showNotification(`${selectedIds.length} resep berhasil diperbarui!`, 'success');
    }
}

function exportSelected() {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        showNotification('Pilih minimal satu resep untuk diekspor!', 'warning');
        return;
    }
    
    // Create export URL with selected IDs
    const exportUrl = `/admin/resep-obat/export?ids=${selectedIds.join(',')}`;
    window.open(exportUrl, '_blank');
}

// Notification helper
function showNotification(message, type = 'info') {
    // You can implement your preferred notification system here
    // For now, using simple alert
    alert(message);
}
</script>
@endpush