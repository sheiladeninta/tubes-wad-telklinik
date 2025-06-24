@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-pills me-2"></i>Kelola Obat
            </h1>
            <p class="text-muted mb-0">Manajemen data obat dan stok</p>
        </div>
        <a href="{{ route('admin.obat.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Tambah Obat
        </a>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Obat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pills fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Stok Menipis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat->where('stok', '<', 10)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Hampir Kadaluarsa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $obat->where('tanggal_kadaluarsa', '<=', now()->addMonths(6))->where('tanggal_kadaluarsa', '>', now())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Obat Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat->where('status', 'aktif')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Filter and Search Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.obat.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Obat</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nama obat, jenis, atau pabrik...">
                </div>
                <div class="col-md-2">
                    <label for="jenis" class="form-label">Jenis Obat</label>
                    <select class="form-select" id="jenis" name="jenis">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisObat as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                {{ ucfirst($jenis) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="stok_status" class="form-label">Status Stok</label>
                    <select class="form-select" id="stok_status" name="stok_status">
                        <option value="">Semua Stok</option>
                        <option value="habis" {{ request('stok_status') == 'habis' ? 'selected' : '' }}>Habis</option>
                        <option value="menipis" {{ request('stok_status') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                        <option value="hampir_kadaluarsa" {{ request('stok_status') == 'hampir_kadaluarsa' ? 'selected' : '' }}>Hampir Kadaluarsa</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Obat</h6>
        </div>
        <div class="card-body">
            @if($obat->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Obat</th>
                                <th>Jenis</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Kadaluarsa</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obat as $index => $item)
                                <tr>
                                    <td>{{ $obat->firstItem() + $index }}</td>
                                    <td>
                                        @if($item->gambar)
                                            <img src="{{ Storage::url($item->gambar) }}" 
                                                 alt="{{ $item->nama_obat }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; border-radius: 4px;">
                                                <i class="fas fa-pills text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $item->nama_obat }}</strong>
                                        @if($item->pabrik)
                                            <br><small class="text-muted">{{ $item->pabrik }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($item->jenis_obat) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'success';
                                            $statusText = 'Tersedia';
                                            
                                            if($item->stok == 0) {
                                                $badgeClass = 'danger';
                                                $statusText = 'Habis';
                                            } elseif($item->stok < 10) {
                                                $badgeClass = 'warning';
                                                $statusText = 'Menipis';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ $item->stok }} {{ $statusText }}
                                        </span>
                                        <br>
                                        <button class="btn btn-sm btn-outline-primary mt-1" onclick="showStockModal({{ $item->id }}, '{{ $item->nama_obat }}', {{ $item->stok }})">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->tanggal_kadaluarsa)
                                            @php
                                                $isKadaluarsa = $item->tanggal_kadaluarsa <= now();
                                                $isHampirKadaluarsa = $item->tanggal_kadaluarsa <= now()->addMonths(6) && $item->tanggal_kadaluarsa > now();
                                                $badgeClass = $isKadaluarsa ? 'danger' : ($isHampirKadaluarsa ? 'warning' : 'success');
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">
                                                {{ $item->tanggal_kadaluarsa->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.obat.show', $item->id) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.obat.edit', $item->id) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.obat.destroy', $item->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        Menampilkan {{ $obat->firstItem() }} sampai {{ $obat->lastItem() }} dari {{ $obat->total() }} data
                    </div>
                    <div>
                        {{ $obat->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data obat</h5>
                    <p class="text-muted">Belum ada obat yang terdaftar atau sesuai dengan filter yang dipilih.</p>
                    <a href="{{ route('admin.obat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Obat Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockModalLabel">Update Stok Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="stockForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="obat_id" name="obat_id">
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Nama Obat:</strong></label>
                        <p id="nama_obat" class="text-muted"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Stok Saat Ini:</strong></label>
                        <p id="stok_sekarang" class="text-muted"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="aksi" class="form-label">Aksi</label>
                        <select class="form-select" id="aksi" name="aksi" required>
                            <option value="">Pilih aksi...</option>
                            <option value="tambah">Tambah Stok</option>
                            <option value="kurang">Kurangi Stok</option>
                            <option value="set">Set Stok Baru</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="stok" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                        <div class="form-text" id="stok_help"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showStockModal(id, nama, stok) {
    document.getElementById('obat_id').value = id;
    document.getElementById('nama_obat').textContent = nama;
    document.getElementById('stok_sekarang').textContent = stok + ' unit';
    
    // Reset form
    document.getElementById('stockForm').reset();
    document.getElementById('obat_id').value = id;
    
    // Show modal
    var modal = new bootstrap.Modal(document.getElementById('stockModal'));
    modal.show();
}

// Handle aksi change to update help text
document.getElementById('aksi').addEventListener('change', function() {
    const helpText = document.getElementById('stok_help');
    const stokInput = document.getElementById('stok');
    
    switch(this.value) {
        case 'tambah':
            helpText.textContent = 'Masukkan jumlah stok yang akan ditambahkan';
            stokInput.placeholder = 'Contoh: 50';
            break;
        case 'kurang':
            helpText.textContent = 'Masukkan jumlah stok yang akan dikurangi';
            stokInput.placeholder = 'Contoh: 10';
            break;
        case 'set':
            helpText.textContent = 'Masukkan jumlah stok baru (mengganti stok saat ini)';
            stokInput.placeholder = 'Contoh: 100';
            break;
        default:
            helpText.textContent = '';
            stokInput.placeholder = '';
    }
});

// Handle form submission
document.getElementById('stockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const obatId = document.getElementById('obat_id').value;
    
    fetch(`{{ url('admin/obat') }}/${obatId}/update-stock`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Insert alert at the top of the container
            const container = document.querySelector('.container-fluid');
            const firstChild = container.children[1]; // After page header
            container.insertBefore(alertDiv, firstChild);
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('stockModal')).hide();
            
            // Refresh page after short delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            alert('Terjadi kesalahan: ' + (data.errors ? Object.values(data.errors).join(', ') : 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui stok');
    });
});
</script>
@endpush

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
}
</style>
@endpush