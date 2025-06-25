@extends('layouts.admin')

@section('title', 'Manajemen Data Dokter')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-user-md me-2"></i>
                        Manajemen Data Dokter
                    </h4>
                    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Dokter
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin.doctors.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control" 
                                           placeholder="Cari nama, email, spesialisasi, atau nomor lisensi...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-filter me-1"></i>
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Success/Error Messages -->
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

                    <!-- Doctors Table -->
                    @if($doctors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Dokter</th>
                                        <th>Email</th>
                                        <th>Spesialisasi</th>
                                        <th>No. Lisensi</th>
                                        <th>Telepon</th>
                                        <th>Status</th>
                                        <th>Terdaftar</th>
                                        <th width="200">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $index => $doctor)
                                        <tr>
                                            <td>{{ $doctors->firstItem() + $index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                            {{ strtoupper(substr($doctor->name, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $doctor->name }}</div>
                                                        @if($doctor->gender)
                                                            <small class="text-muted">
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
                                            <td>{{ $doctor->license_number }}</td>
                                            <td>{{ $doctor->phone ?? '-' }}</td>
                                            <td>
                                                @if($doctor->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>
                                                        Tidak Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $doctor->created_at->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.doctors.show', $doctor) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" 
                                                       class="btn btn-sm btn-outline-warning" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.doctors.toggle-status', $doctor) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-{{ $doctor->is_active ? 'secondary' : 'success' }}" 
                                                                title="{{ $doctor->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                                onclick="return confirm('Yakin ingin {{ $doctor->is_active ? 'menonaktifkan' : 'mengaktifkan' }} dokter ini?')">
                                                            <i class="fas fa-{{ $doctor->is_active ? 'ban' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Hapus"
                                                                onclick="return confirm('Yakin ingin menghapus dokter ini? Aksi ini tidak dapat dibatalkan.')">
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
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $doctors->firstItem() }} - {{ $doctors->lastItem() }} 
                                dari {{ $doctors->total() }} data
                            </div>
                            <div>
                                {{ $doctors->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-user-md fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Tidak ada data dokter</h5>
                            <p class="text-muted mb-4">
                                @if(request()->has('search') || request()->has('status'))
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
                                <i class="fas fa-plus me-1"></i>
                                Tambah Dokter Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar {
    position: relative;
    display: inline-block;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.alert {
    border-radius: 0.5rem;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush
@endsection