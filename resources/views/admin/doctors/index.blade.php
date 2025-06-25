@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-md me-2"></i>Kelola Dokter
            </h1>
            <p class="text-muted mb-0">Manajemen data dokter dan spesialisasi</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Tambah Dokter
        </a>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Dokter</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doctors->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dokter Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doctors->where('is_active', 1)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dokter Tidak Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doctors->where('is_active', 0)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Spesialisasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doctors->pluck('specialist')->unique()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
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
            <form method="GET" action="{{ route('admin.doctors.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Dokter</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nama, email, spesialisasi, atau nomor lisensi...">
                </div>
                <div class="col-md-2">
                    <label for="specialist" class="form-label">Spesialisasi</label>
                    <select class="form-select" id="specialist" name="specialist">
                        <option value="">Semua Spesialisasi</option>
                        @foreach($doctors->pluck('specialist')->unique()->filter() as $specialist)
                            <option value="{{ $specialist }}" {{ request('specialist') == $specialist ? 'selected' : '' }}>
                                {{ $specialist }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">Semua</option>
                        <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokter</h6>
        </div>
        <div class="card-body">
            @if($doctors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Dokter</th>
                                <th>Email</th>
                                <th>Spesialisasi</th>
                                <th>No. Lisensi</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $index => $doctor)
                                <tr>
                                    <td>{{ $doctors->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px;">
                                                    {{ strtoupper(substr($doctor->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $doctor->name }}</div>
                                                @if($doctor->gender)
                                                    <small class="text-muted">
                                                        <i class="fas fa-{{ $doctor->gender == 'L' ? 'mars' : 'venus' }} me-1"></i>
                                                        {{ $doctor->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $doctor->email }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $doctor->specialist }}</span>
                                    </td>
                                    <td>
                                        <code>{{ $doctor->license_number }}</code>
                                    </td>
                                    <td>
                                        @if($doctor->phone)
                                            <a href="tel:{{ $doctor->phone }}" class="text-decoration-none">
                                                <i class="fas fa-phone me-1"></i>{{ $doctor->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $doctor->is_active ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $doctor->is_active ? 'check' : 'times' }} me-1"></i>
                                            {{ $doctor->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $doctor->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.doctors.show', $doctor) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.doctors.edit', $doctor) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.doctors.toggle-status', $doctor) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-{{ $doctor->is_active ? 'secondary' : 'success' }}" 
                                                        title="{{ $doctor->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                        onclick="return confirm('Yakin ingin {{ $doctor->is_active ? 'menonaktifkan' : 'mengaktifkan' }} dokter ini?')">
                                                    <i class="fas fa-{{ $doctor->is_active ? 'ban' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.doctors.destroy', $doctor) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus dokter ini? Aksi ini tidak dapat dibatalkan.')">
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
                        Menampilkan {{ $doctors->firstItem() }} sampai {{ $doctors->lastItem() }} dari {{ $doctors->total() }} data
                    </div>
                    <div>
                        {{ $doctors->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data dokter</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'specialist', 'gender']))
                            Tidak ada dokter yang sesuai dengan kriteria pencarian.
                            <br>
                            <a href="{{ route('admin.doctors.index') }}" class="text-decoration-none">
                                Tampilkan semua dokter
                            </a>
                        @else
                            Belum ada dokter yang terdaftar dalam sistem.
                        @endif
                    </p>
                    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Dokter Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

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
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
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
.avatar {
    position: relative;
    display: inline-block;
}
code {
    font-size: 0.875em;
    background-color: #f8f9fc;
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    padding: 0.125rem 0.25rem;
}
</style>
@endpush